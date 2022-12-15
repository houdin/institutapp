<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Media;
use App\Models\Formation;
use function foo\func;
use App\Models\Category;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FormationTimeline;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use DataTables;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreFormationsRequest;
use App\Http\Requests\Admin\UpdateFormationsRequest;
use App\Models\Image;
use Session;

class FormationsController extends BackendBaseController
{
    use FileUploadTrait;

    /**
     * Display a listing of Formation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if (!Gate::allows('formation_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (!Gate::allows('formation_delete')) {
                return abort(401);
            }
            $formations = Formation::onlyTrashed()->ofTeacher()->get();
        } else {
            $formations = Formation::ofTeacher()->get();
        }


        return view('backend.formations.index', compact('formations'));
    }

    /**
     * Display a listing of Formations via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {

        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $formations = "";

        if (request('show_deleted') == 1) {
            if (!Gate::allows('formation_delete')) {
                return abort(401);
            }
            $formations = Formation::onlyTrashed()
                ->whereHas('category')
                ->ofTeacher()->orderBy('id', 'desc')->get();
        } else if (request('teacher_id') != "") {
            $id = request('teacher_id');
            $formations = Formation::ofTeacher()
                ->whereHas('category')
                ->whereHas('teachers', function ($q) use ($id) {
                    $q->where('formation_user.user_id', '=', $id);
                })->orderBy('id', 'desc')->get();
        } else if (request('cat_id') != "") {
            $id = request('cat_id');
            $formations = Formation::ofTeacher()
                ->whereHas('category')
                ->where('category_id', '=', $id)->orderBy('id', 'desc')->get();
        } else {
            $formations = Formation::ofTeacher()
                ->whereHas('category')
                ->orderBy('id', 'desc')->get();
        }


        if (auth()->user()->can('formation_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('formation_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('module_delete')) {
            $has_delete = true;
        }
        // dd($formations);

        return DataTables::of($formations)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.formations', 'label' => 'module', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.formations.show', ['formation' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.formations.edit', ['formation' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.formations.destroy', ['formation' => $q->id])])
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
                    ->with(['route' => route('admin.formations.publish', ['id' => $q->id])])->render();
                return $view;
            })
            ->editColumn('teachers', function ($q) {
                $teachers = "";
                foreach ($q->teachers as $singleTeachers) {
                    $teachers .= '<span class="label label-info label-many">' . $singleTeachers->name . ' </span>';
                }
                return $teachers;
            })
            ->addColumn('modules', function ($q) {
                $module = '<a href="' . route('admin.modules.create', ['formation_id' => $q->id]) . '" class="btn btn-success mb-1"><i class="fa fa-plus-circle"></i></a>  <a href="' . route('admin.modules.index', ['formation_id' => $q->id]) . '" class="btn mb-1 btn-warning text-white"><i class="fa fa-arrow-circle-right"></a>';
                return $module;
            })
            ->editColumn('formation_image', function ($q) {
                return ($q->image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->image->name) . '">' : 'N/A';
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
            ->rawColumns(['teachers', 'modules', 'formation_image', 'actions', 'status'])
            ->make();
    }


    /**
     * Show the form for creating new Formation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('formation_create')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');

        $categories = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('backend.formations.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created Formation in storage.
     *
     * @param  \App\Http\Requests\StoreFormationsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormationsRequest $request)
    {
        if (!Gate::allows('formation_create')) {
            return abort(401);
        }

        $request->all();

        $request = $this->saveFiles($request);

        $formation_image = $request->formation_image;
        $name = head(explode('.', $formation_image));
        $extension = '.' . last(explode('.', $formation_image));

        unset($request['formation_image']);

        // dd($request->all());

        $formation = Formation::create($request->all());

        $formation->image()->save(Image::create([
            'name' => $formation_image,
            'file_name' => Str::slug($formation->title),
            'url' => asset('storage/uploads/images/' . date('Y/m/') . 'origin/' . Str::slug($formation->title) . '.jpg')
        ]));




        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Formation::class;
            $model_id = $formation->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $formation->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Formation')
                    ->where('model_id', '=', $formation->id)
                    ->first();
                $size = 0;
            } elseif ($request->media_type == 'upload') {
                if (\Illuminate\Support\Facades\Request::hasFile('video_file')) {
                    $file = \Illuminate\Support\Facades\Request::file('video_file');
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $size = $file->getSize() / 1024;
                    $path = public_path() . '/storage/uploads/';
                    $file->move($path, $filename);

                    $video_id = $filename;
                    $url = asset('storage/uploads/' . $filename);

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Module')
                        ->where('model_id', '=', $formation->id)
                        ->first();
                }
            } else if ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $formation->title . ' - video';
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
            $formation->slug = Str::slug($request->title);
            $formation->save();
        }
        if ((int)$request->price == 0) {
            $formation->price = NULL;
            $formation->save();
        }


        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $formation->teachers()->sync($teachers);


        return redirect()->route('admin.formations.index')->with('success', trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Formation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('formation_edit')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');
        $categories = Category::where('status', '=', 1)->pluck('name', 'id');


        $formation = Formation::findOrFail($id);

        return view('backend.formations.edit', compact('formation', 'teachers', 'categories'));
    }

    /**
     * Update Formation in storage.
     *
     * @param  \App\Http\Requests\UpdateFormationsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormationsRequest $request, $id)
    {
        if (!Gate::allows('formation_edit')) {
            return abort(401);
        }
        $formation = Formation::findOrFail($id);
        $request = $this->saveFiles($request);


        //Saving  videos
        if ($request->media_type != "" || $request->media_type  != null) {
            if ($formation->mediavideo) {

                $formation->mediavideo->delete();
            }
            $model_type = Formation::class;
            $model_id = $formation->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $formation->title . ' - video';
            $media = $formation->mediavideo;
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
                    $filename = $formation->title . ' - video';
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
                        ->where('model_type', '=', 'App\Models\Formation')
                        ->where('model_id', '=', $formation->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
                    }
                    $media->model_type = $model_type;
                    $media->model_id = $model_id;
                    $media->name = $name;
                    $media->url = url('storage/uploads/' . $request->video_file);
                    $media->type = $request->media_type;
                    $media->file_name = $request->video_file;
                    $media->size = 0;
                    $media->save();
                }
            }
        }
        $formation_image = $request->formation_image;
        $name = head(explode('.', $formation_image));
        $extension = '.' . last(explode('.', $formation_image));

        $currentImage = $formation->image->name;

        if ($currentImage !== $formation_image) {
            $formation->image()->update([
                'name' => $formation_image,
                'file_name' => Str::slug($formation->title),
                'url' => asset('storage/uploads/images/' . date('Y/m/') . 'origin/' . Str::slug($formation->title) . '.jpg')
            ]);
        }


        $formation->update($request->all());
        if (($request->slug == "") || $request->slug == null) {
            $formation->slug = Str::slug($request->title);
            $formation->save();
        }

        if ((int)$request->price == 0) {
            $formation->price = NULL;
            $formation->save();
        }

        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $formation->teachers()->sync($teachers);

        return redirect()->route('admin.formations.index')->with('success', trans('alerts.backend.general.updated'));
    }


    /**
     * Display Formation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('formation_view')) {
            return abort(401);
        }
        $teachers = User::get()->pluck('name', 'id');
        $modules = \App\Models\Module::where('formation_id', $id)->get();
        $tests = \App\Models\Test::where('formation_id', $id)->get();

        $formation = Formation::findOrFail($id);
        $formationTimeline = $formation->formationTimeline()->orderBy('sequence', 'asc')->get();

        return view('backend.formations.show', compact('formation', 'modules', 'tests', 'formationTimeline'));
    }


    /**
     * Remove Formation from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Gate::allows('formation_delete')) {
            return abort(401);
        }
        $formation = Formation::findOrFail($id);
        if ($formation->students->count() >= 1) {

            // session()->flash('danger', trans('alerts.backend.general.delete_warning'));

            return redirect()->route('admin.formations.index')->with('danger', 'alerts.backend.general.delete_warning');
        } else {
            $formation->delete();
        }


        return redirect()->route('admin.formations.index')->with('success', trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Formation at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {

        if (!Gate::allows('formation_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Formation::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Formation from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('formation_delete')) {
            return abort(401);
        }
        $formation = Formation::onlyTrashed()->findOrFail($id);
        $formation->restore();

        return redirect()->route('admin.formations.index')->with('success', trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Formation from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('formation_delete')) {
            return abort(401);
        }
        $formation = Formation::onlyTrashed()->findOrFail($id);
        $formation->forceDelete();

        return redirect()->route('admin.formations.index')->with('success', trans('alerts.backend.general.deleted'));
    }

    /**
     * Permanently save Sequence from storage.
     *
     * @param  Request
     */
    public function saveSequence(Request $request)
    {
        if (!Gate::allows('formation_edit')) {
            return abort(401);
        }

        foreach ($request->list as $item) {
            $formationTimeline = FormationTimeline::find($item['id']);
            $formationTimeline->sequence = $item['sequence'];
            $formationTimeline->save();
        }

        return 'success';
    }


    /**
     * Publish / Unpublish formations
     *
     * @param  Request
     */
    public function publish($id)
    {
        if (!Gate::allows('formation_edit')) {
            return abort(401);
        }

        $formation = Formation::findOrFail($id);
        if ($formation->published == 1) {
            $formation->published = 0;
        } else {
            $formation->published = 1;
        }
        $formation->save();

        return back()->with('success', trans('alerts.backend.general.updated'));
    }
}
