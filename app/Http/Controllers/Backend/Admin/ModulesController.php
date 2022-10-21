<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Test;
use App\Models\Media;
use App\Models\Formation;
use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FormationTimeline;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreModulesRequest;
use App\Http\Requests\Admin\UpdateModulesRequest;

class ModulesController extends BackendBaseController
{
    use FileUploadTrait;

    /**
     * Display a listing of Module.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('module_access')) {
            return abort(401);
        }
        $formations = $formations = Formation::has('category')->ofTeacher()->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.modules.index', compact('formations'));
    }

    /**
     * Display a listing of Modules via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {

        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $modules = "";
        $modules = Module::whereIn('formation_id', Formation::ofTeacher()->pluck('id'));


        if ($request->formation_id != "") {
            $modules = $modules->where('formation_id', (int)$request->formation_id)->orderBy('created_at', 'desc')->get();
        }

        if ($request->show_deleted == 1) {
            if (!Gate::allows('module_delete')) {
                return abort(401);
            }
            $modules = Module::query()->with('formation')->orderBy('created_at', 'desc')->onlyTrashed()->get();
        }


        if (auth()->user()->can('module_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('module_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('module_delete')) {
            $has_delete = true;
        }

        return DataTables::of($modules)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.modules', 'label' => 'module', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.modules.show', ['module' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.modules.edit', ['module' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.modules.destroy', ['module' => $q->id])])
                        ->render();
                    $view .= $delete;
                }

                if (auth()->user()->can('test_view')) {
                    if ($q->test != "") {
                        $view .= '<a href="' . route('admin.tests.index', ['module_id' => $q->id]) . '" class="btn btn-success btn-block mb-1">' . trans('labels.backend.tests.title') . '</a>';
                    }
                }

                return $view;
            })
            ->editColumn('formation', function ($q) {
                return ($q->formation) ? $q->formation->title : 'N/A';
            })
            ->editColumn('module_image', function ($q) {
                return ($q->module_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->module_image) . '">' : 'N/A';
            })
            ->editColumn('free_module', function ($q) {
                return ($q->free_module == 1) ? "Yes" : "No";
            })
            ->editColumn('published', function ($q) {
                return ($q->published == 1) ? "Yes" : "No";
            })
            ->rawColumns(['module_image', 'actions'])
            ->make();
    }

    /**
     * Show the form for creating new Module.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('module_create')) {
            return abort(401);
        }
        $formations = Formation::has('category')->ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');
        return view('backend.modules.create', compact('formations'));
    }

    /**
     * Store a newly created Module in storage.
     *
     * @param  \App\Http\Requests\StoreModulesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModulesRequest $request)
    {
        if (!Gate::allows('module_create')) {
            return abort(401);
        }

        $module = Module::create($request->except('downloadable_files', 'module_image')
            + ['position' => Module::where('formation_id', $request->formation_id)->max('position') + 1]);


        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Module::class;
            $model_id = $module->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $module->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Module')
                    ->where('model_id', '=', $module->id)
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
                        ->where('model_id', '=', $module->id)
                        ->first();
                }
            } else if ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $module->title . ' - video';
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

        $request = $this->saveAllFiles($request, 'downloadable_files', Module::class, $module);

        if (($request->slug == "") || $request->slug == null) {
            $module->slug = Str::slug($request->title);
            $module->save();
        }

        $sequence = 1;
        if (count($module->formation->formationTimeline) > 0) {
            $sequence = $module->formation->formationTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ($module->published == 1) {
            $timeline = FormationTimeline::where('model_type', '=', Module::class)
                ->where('model_id', '=', $module->id)
                ->where('formation_id', $request->formation_id)->first();
            if ($timeline == null) {
                $timeline = new FormationTimeline();
            }
            $timeline->formation_id = $request->formation_id;
            $timeline->model_id = $module->id;
            $timeline->model_type = Module::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }

        return redirect()->route('admin.modules.index', ['formation_id' => $request->formation_id])->with('success', __('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Module.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('module_edit')) {
            return abort(401);
        }
        $videos = '';
        $formations = Formation::has('category')->ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');

        $module = Module::with('media')->findOrFail($id);
        if ($module->media) {
            $videos = $module->media()->where('media.type', '=', 'YT')->pluck('url')->implode(',');
        }

        return view('backend.modules.edit', compact('module', 'formations', 'videos'));
    }

    /**
     * Update Module in storage.
     *
     * @param  \App\Http\Requests\UpdateModulesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModulesRequest $request, $id)
    {
        if (!Gate::allows('module_edit')) {
            return abort(401);
        }
        $module = Module::findOrFail($id);
        $module->update($request->except('downloadable_files', 'module_image'));
        if (($request->slug == "") || $request->slug == null) {
            $module->slug = Str::slug($request->title);
            $module->save();
        }

        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Module::class;
            $model_id = $module->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $module->title . ' - video';
            $media = $module->mediavideo;
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
                    $filename = $module->title . ' - video';
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
                        ->where('model_id', '=', $module->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
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
            }
        }
        if ($request->hasFile('add_pdf')) {
            $pdf = $module->mediaPDF;
            if ($pdf) {
                $pdf->delete();
            }
        }


        $request = $this->saveAllFiles($request, 'downloadable_files', Module::class, $module);

        $sequence = 1;
        if (count($module->formation->formationTimeline) > 0) {
            $sequence = $module->formation->formationTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ((int)$request->published == 1) {
            $timeline = FormationTimeline::where('model_type', '=', Module::class)
                ->where('model_id', '=', $module->id)
                ->where('formation_id', $request->formation_id)->first();
            if ($timeline == null) {
                $timeline = new FormationTimeline();
            }
            $timeline->formation_id = $request->formation_id;
            $timeline->model_id = $module->id;
            $timeline->model_type = Module::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }


        return redirect()->route('admin.modules.index', ['formation_id' => $request->formation_id])->with('success', __('alerts.backend.general.updated'));
    }


    /**
     * Display Module.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('module_view')) {
            return abort(401);
        }
        $formations = Formation::get()->pluck('title', 'id')->prepend('Please select', '');

        $tests = Test::where('module_id', $id)->get();

        $module = Module::findOrFail($id);


        return view('backend.modules.show', compact('module', 'tests', 'formations'));
    }


    /**
     * Remove Module from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('module_delete')) {
            return abort(401);
        }
        $module = Module::findOrFail($id);
        $module->chapterStudents()->where('formation_id', $module->formation_id)->forceDelete();
        $module->delete();

        return back()->with('success', __('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Module at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('module_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Module::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Module from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('module_delete')) {
            return abort(401);
        }
        $module = Module::onlyTrashed()->findOrFail($id);
        $module->restore();

        return back()->with('success', trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Module from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('module_delete')) {
            return abort(401);
        }
        $module = Module::onlyTrashed()->findOrFail($id);

        if (File::exists(public_path('/storage/uploads/' . $module->module_image))) {
            File::delete(public_path('/storage/uploads/' . $module->module_image));
            File::delete(public_path('/storage/uploads/thumb/' . $module->module_image));
        }

        $timelineStep = FormationTimeline::where('model_id', '=', $id)
            ->where('formation_id', '=', $module->formation->id)->first();
        if ($timelineStep) {
            $timelineStep->delete();
        }

        $module->forceDelete();



        return back()->with('success', trans('alerts.backend.general.deleted'));
    }
}
