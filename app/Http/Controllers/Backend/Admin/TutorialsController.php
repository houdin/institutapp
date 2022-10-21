<?php

namespace App\Http\Controllers\Backend\Admin;

use DataTables;
use App\Models\Image;
use App\Models\Media;
use function foo\func;
use App\Models\Category;
use App\Models\Tutorial;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TutorialTimeline;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreTutorialsRequest;
use App\Http\Requests\Admin\UpdateTutorialsRequest;
use App\Http\Controllers\Backend\BackendBaseController;

class TutorialsController extends BackendBaseController
{
    use FileUploadTrait;

    /**
     * Display a listing of Tutorial.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Gate::allows('tutorial_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (!Gate::allows('tutorial_delete')) {
                return abort(401);
            }
            $tutorials = Tutorial::onlyTrashed()->ofTeacher()->get();
        } else {
            $tutorials = Tutorial::ofTeacher()->get();
        }

        return view('backend.tutorials.index', compact('tutorials'));
    }

    /**
     * Display a listing of Tutorials via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $tutorials = "";

        if (request('show_deleted') == 1) {
            if (!Gate::allows('tutorial_delete')) {
                return abort(401);
            }
            $tutorials = Tutorial::onlyTrashed()
                ->whereHas('category')
                ->ofTeacher()->orderBy('created_at', 'desc')->get();
        } else if (request('teacher_id') != "") {
            $id = request('teacher_id');
            $tutorials = Tutorial::ofTeacher()
                ->whereHas('category')
                ->whereHas('teachers', function ($q) use ($id) {
                    $q->where('tutorial_user.user_id', '=', $id);
                })->orderBy('created_at', 'desc')->get();
        } else if (request('cat_id') != "") {
            $id = request('cat_id');
            $tutorials = Tutorial::ofTeacher()
                ->whereHas('category')
                ->where('category_id', '=', $id)->orderBy('created_at', 'desc')->get();
        } else {
            $tutorials = Tutorial::ofTeacher()
                ->whereHas('category')
                ->orderBy('created_at', 'desc')->get();
        }


        if (auth()->user()->can('tutorial_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('tutorial_edit')) {
            $has_edit = true;
        }


        return DataTables::of($tutorials)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.tutorials', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.tutorials.show', ['tutorial' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.tutorials.edit', ['tutorial' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.tutorials.destroy', ['tutorial' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                // $type =  'action-publish';
                if ($q->published == 1) {
                    $type = 'action-unpublish';
                } else {
                    $type = 'action-publish';
                }


                $view .= view('backend.datatable.' . $type)
                    ->with(['route' => route('admin.tutorials.publish', ['id' => $q->id])])->render();
                return $view;
            })
            ->editColumn('teachers', function ($q) {
                $teachers = "";
                foreach ($q->teachers as $singleTeachers) {
                    $teachers .= '<span class="label label-info label-many">' . $singleTeachers->name . ' </span>';
                }
                return $teachers;
            })
            ->editColumn('tutorial_image', function ($q) {
                return ($q->image != null) ? '<img height="50px" src="' . featured_image_url($q, 1) . '">' : 'N/A';
            })
            ->editColumn('status', function ($q) {
                $text = "";
                $text = ($q->published == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-dark p-1 mr-1' >" . trans('labels.backend.formations.fields.published') . "</p>" : "";
                $text .= ($q->featured == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-warning p-1 mr-1' >" . trans('labels.backend.formations.fields.featured') . "</p>" : "";
                $text .= ($q->trending == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-success p-1 mr-1' >" . trans('labels.backend.formations.fields.trending') . "</p>" : "";
                $text .= ($q->popular == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-primary p-1 mr-1' >" . trans('labels.backend.formations.fields.popular') . "</p>" : "";

                return $text;
            })
            ->editColumn('price', function ($q) {
                if ($q->free == 1) {
                    return trans('labels.backend.formations.fields.free');
                }
                return $q->price;
            })
            ->addColumn('category', function ($q) {
                return $q->category->name;
            })
            ->rawColumns(['teachers', 'tutorial_image', 'actions', 'status'])
            ->make();
    }


    /**
     * Show the form for creating new Tutorial.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('tutorial_create')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');

        $categories = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('backend.tutorials.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created Tutorial in storage.
     *
     * @param  \App\Http\Requests\StoreTutorialsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTutorialsRequest $request)
    {
        if (!Gate::allows('tutorial_create')) {
            return abort(401);
        }

        $request->all();

        $request = $this->saveFiles($request);

        $tutorial_image = $request->tutorial_image;
        $name = head(explode('.', $tutorial_image));
        $extension = '.' . last(explode('.', $tutorial_image));

        unset($request['tutorial_image']);

        $tutorial = Tutorial::create($request->all());

        $tutorial->image()->save(Image::create([
            'name' => $tutorial_image,
            'file_name' => $name,
            'url' => asset('storage/uploads/' . date('Y/m/') . $tutorial_image)
        ]));

        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Tutorial::class;
            $model_id = $tutorial->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $tutorial->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Tutorial')
                    ->where('model_id', '=', $tutorial->id)
                    ->first();
                $size = 0;
            } elseif ($request->media_type == 'upload') {
                if (\Illuminate\Support\Facades\Request::hasFile('video_file')) {
                    $file = \Illuminate\Support\Facades\Request::file('video_file');
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $size = $file->getSize() / 1024;
                    $path = public_path() . '/storage/uploads/tols/';
                    $file->move($path, $filename);

                    $video_id = $filename;
                    $url = asset('storage/uploads/' . $filename);

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Tutorial')
                        ->where('model_id', '=', $tutorial->id)
                        ->first();
                }
            } else if ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $tutorial->title . ' - video';
            }

            if ($media == null) {
                $media = new Media();
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }
        }


        if (($request->slug == "") || $request->slug == null) {
            $tutorial->slug = Str::slug($request->title);
            $tutorial->save();
        }
        if ((int)$request->price == 0) {
            $tutorial->price = NULL;
            $tutorial->save();
        }


        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $tutorial->teachers()->sync($teachers);


        return redirect()->route('admin.tutorials.index')->with('success', trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Tutorial.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('tutorial_edit')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');
        $categories = Category::where('status', '=', 1)->pluck('name', 'id');


        $tutorial = Tutorial::findOrFail($id);

        return view('backend.tutorials.edit', compact('tutorial', 'teachers', 'categories'));
    }

    /**
     * Update Tutorial in storage.
     *
     * @param  \App\Http\Requests\UpdateTutorialsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTutorialsRequest $request, $id)
    {
        if (!Gate::allows('tutorial_edit')) {
            return abort(401);
        }
        $tutorial = Tutorial::findOrFail($id);
        $request = $this->saveFiles($request);

        if ($request->hasFile('tutorial_image')) {
            $tutorial_image = $request->tutorial_image;
            $name = head(explode('.', $tutorial_image));
            $extension = '.' . last(explode('.', $tutorial_image));

            $currentImage = $tutorial->image->name;

            if ($currentImage !== $tutorial_image) {
                $tutorial->image()->update([
                    'name' => $tutorial_image,
                    'file_name' => $name,
                    'url' => asset('storage/uploads/' . date('Y/m/') . $tutorial_image)
                ]);
            }
        }

        //Saving  videos
        if ($request->media_type != "" || $request->media_type  != null) {
            if ($tutorial->mediavideo) {
                $tutorial->mediavideo->delete();
            }
            $model_type = Tutorial::class;
            $model_id = $tutorial->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $tutorial->title . ' - video';
            $media = $tutorial->mediavideo;
            if ($media == "") {
                $media = new  Media();
            }
            if ($request->media_type != 'upload') {
                if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                    $video = $request->video;
                    $url = $video;
                    $video_id = last(explode('/', $request->video));
                    $size = 0;
                } else if ($request->media_type == 'embed') {
                    $url = $request->video;
                    $filename = $tutorial->title . ' - video';
                }
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }

            if ($request->media_type == 'upload') {

                if ($request->video_file != null) {

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Tutorial')
                        ->where('model_id', '=', $tutorial->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
                    }
                    $media->model_type = $model_type;
                    $media->model_id = $model_id;
                    $media->name = $name;
                    $media->url = url('storage/uploads/tols/' . $request->video_file);
                    $media->type = $request->media_type;
                    $media->file_name = $request->video_file;
                    $media->size = 0;
                    $media->save();
                }
            }
        }


        $tutorial->update($request->all());
        if (($request->slug == "") || $request->slug == null) {
            $tutorial->slug = Str::slug($request->title);
            $tutorial->save();
        }
        if ((int)$request->price == 0) {
            $tutorial->price = NULL;
            $tutorial->save();
        }

        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $tutorial->teachers()->sync($teachers);

        return redirect()->route('admin.tutorials.index')->with('success', trans('alerts.backend.general.updated'));
    }


    /**
     * Display Tutorial.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('tutorial_view')) {
            return abort(401);
        }
        $teachers = User::get()->pluck('name', 'id');
        $modules = \App\Models\Module::where('tutorial_id', $id)->get();
        $tests = \App\Models\Test::where('tutorial_id', $id)->get();

        $tutorial = Tutorial::findOrFail($id);
        $tutorialTimeline = $tutorial->tutorialTimeline()->orderBy('sequence', 'asc')->get();

        return view('backend.tutorials.show', compact('tutorial', 'modules', 'tests', 'tutorialTimeline'));
    }


    /**
     * Remove Tutorial from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('tutorial_delete')) {
            return abort(401);
        }
        $tutorial = Tutorial::findOrFail($id);
        if ($tutorial->students->count() >= 1) {
            return redirect()->route('admin.tutorials.index')->with('danger', trans('alerts.backend.general.delete_warning'));
        } else {
            $tutorial->delete();
        }


        return redirect()->route('admin.tutorials.index')->with('success', trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Tutorial at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('tutorial_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Tutorial::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Tutorial from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('tutorial_delete')) {
            return abort(401);
        }
        $tutorial = Tutorial::onlyTrashed()->findOrFail($id);
        $tutorial->restore();

        return redirect()->route('admin.tutorials.index')->with('success', trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Tutorial from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('tutorial_delete')) {
            return abort(401);
        }
        $tutorial = Tutorial::onlyTrashed()->findOrFail($id);
        $tutorial->forceDelete();

        return redirect()->route('admin.tutorials.index')->with('success', trans('alerts.backend.general.deleted'));
    }

    /**
     * Permanently save Sequence from storage.
     *
     * @param  Request
     */
    public function saveSequence(Request $request)
    {
        if (!Gate::allows('tutorial_edit')) {
            return abort(401);
        }

        foreach ($request->list as $item) {
            $tutorialTimeline = TutorialTimeline::find($item['id']);
            $tutorialTimeline->sequence = $item['sequence'];
            $tutorialTimeline->save();
        }

        return 'success';
    }


    /**
     * Publish / Unpublish tutorials
     *
     * @param  Request
     */
    public function publish($id)
    {
        if (!Gate::allows('tutorial_edit')) {
            return abort(401);
        }

        $tutorial = Tutorial::findOrFail($id);
        if ($tutorial->published == 1) {
            $tutorial->published = 0;
        } else {
            $tutorial->published = 1;
        }
        $tutorial->save();

        return back()->with('success', trans('alerts.backend.general.updated'));
    }
}
