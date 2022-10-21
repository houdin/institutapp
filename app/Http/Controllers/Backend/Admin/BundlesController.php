<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Bundle;
use App\Models\Formation;
use function foo\func;
use App\Models\Category;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FormationTimeline;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreBundlesRequest;
use App\Http\Requests\Admin\StoreFormationsRequest;
use App\Http\Requests\Admin\UpdateBundlesRequest;
use App\Http\Requests\Admin\UpdateFormationsRequest;

class BundlesController extends BackendBaseController
{
    use FileUploadTrait;

    /**
     * Display a listing of Formation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('bundle_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (!Gate::allows('bundle_delete')) {
                return abort(401);
            }
            $bundles = Bundle::onlyTrashed()->ofAuthor()->get();
        } else {
            $bundles = Bundle::ofAuthor()->get();
        }

        return view('backend.bundles.index', compact('bundles'));
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
        $bundles = "";

        if (request('show_deleted') == 1) {
            if (!Gate::allows('bundle_delete')) {
                return abort(401);
            }
            $bundles = Bundle::ofAuthor()->onlyTrashed()->orderBy('created_at', 'desc')->get();
        } else if (request('cat_id') != "") {
            $id = request('cat_id');
            $bundles = Bundle::ofAuthor()->where('category_id', '=', $id)->orderBy('created_at', 'desc')->get();
        } else {
            $bundles = Bundle::ofAuthor()->orderBy('created_at', 'desc')->get();
        }


        if (auth()->user()->can('bundle_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('bundle_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('bundle_delete')) {
            $has_delete = true;
        }

        return DataTables::of($bundles)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.bundles', 'label' => 'module', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.bundles.show', ['bundle' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.bundles.edit', ['bundle' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.bundles.destroy', ['bundle' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                if ($q->published == 1) {
                    $type = 'action-unpublish';
                } else {
                    $type = 'action-publish';
                }

                $view .= view('backend.datatable.' . $type)
                    ->with(['route' => route('admin.bundles.publish', ['id' => $q->id])])->render();
                return $view;
            })
            ->editColumn('formation_image', function ($q) {
                return ($q->formation_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->formation_image) . '">' : 'N/A';
            })
            ->addColumn('formations', function ($q) {
                return $q->formations->count();
            })
            ->editColumn('status', function ($q) {
                $text = "";
                $text = ($q->published == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-dark p-1 mr-1' >" . trans('labels.backend.bundles.fields.published') . "</p>" : "";
                $text .= ($q->featured == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-warning p-1 mr-1' >" . trans('labels.backend.bundles.fields.featured') . "</p>" : "";
                $text .= ($q->trending == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-success p-1 mr-1' >" . trans('labels.backend.bundles.fields.trending') . "</p>" : "";
                $text .= ($q->popular == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-primary p-1 mr-1' >" . trans('labels.backend.bundles.fields.popular') . "</p>" : "";
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
            ->rawColumns(['formation_image', 'actions', 'status'])
            ->make();
    }


    /**
     * Show the form for creating new Formation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('bundle_create')) {
            return abort(401);
        }

        $formations = Formation::ofTeacher()->pluck('title', 'id');
        $categories = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('backend.bundles.create', compact('formations', 'categories'));
    }

    /**
     * Store a newly created Formation in storage.
     *
     * @param  \App\Http\Requests\StoreBundlesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBundlesRequest $request)
    {

        if (!Gate::allows('bundle_create')) {
            return abort(401);
        }
        $request->all();

        $request = $this->saveFiles($request);
        $bundle = Bundle::create($request->all());
        if (($request->slug == "") || $request->slug == null) {
            $bundle->slug = Str::slug($request->title);
            $bundle->save();
        }
        if ((int)$request->price == 0) {
            $bundle->price = NULL;
            $bundle->save();
        }

        $bundle->user_id = auth()->user()->id;
        $bundle->save();

        $formations = array_filter((array)$request->input('formations'));
        $bundle->formations()->sync($formations);


        return redirect()->route('admin.bundles.index')->with('success', trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Formation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('bundle_edit')) {
            return abort(401);
        }

        $formations = Formation::ofTeacher()->pluck('title', 'id');


        $categories = Category::where('status', '=', 1)->pluck('name', 'id');
        $bundle = Bundle::findOrFail($id);

        return view('backend.bundles.edit', compact('bundle', 'formations', 'categories'));
    }

    /**
     * Update Formation in storage.
     *
     * @param  \App\Http\Requests\UpdateFormationsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBundlesRequest $request, $id)
    {
        if (!Gate::allows('bundle_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $bundle = Bundle::findOrFail($id);

        $bundle->update($request->all());
        if (($request->slug == "") || $request->slug == null) {
            $bundle->slug = Str::slug($request->title);
            $bundle->save();
        }


        if ((int)$request->price == 0) {
            $bundle->price = NULL;
            $bundle->save();
        }

        $formations = array_filter((array)$request->input('formations'));
        $bundle->formations()->sync($formations);


        return redirect()->route('admin.bundles.index')->with('success', trans('alerts.backend.general.updated'));
    }


    /**
     * Display Formation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('bundle_view')) {
            return abort(401);
        }
        $bundle = Bundle::findOrFail($id);

        return view('backend.bundles.show', compact('bundle'));
    }


    /**
     * Remove Formation from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('bundle_delete')) {
            return abort(401);
        }
        $bundle = Bundle::findOrFail($id);
        if ($bundle->students->count() >= 1) {
            return redirect()->route('admin.bundles.index')->with('danger', trans('alerts.backend.general.delete_warning_bundle'));
        } else {
            $bundle->delete();
        }

        return redirect()->route('admin.bundles.index')->with('success', trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Formation at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('bundle_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Bundle::whereIn('id', $request->input('ids'))->get();

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
        if (!Gate::allows('bundle_delete')) {
            return abort(401);
        }
        $bundle = Bundle::onlyTrashed()->findOrFail($id);
        $bundle->restore();

        return redirect()->route('admin.bundles.index')->with('success', trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Formation from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('bundle_delete')) {
            return abort(401);
        }
        $bundle = Bundle::onlyTrashed()->findOrFail($id);
        $bundle->forceDelete();

        return redirect()->route('admin.bundles.index')->with('success', trans('alerts.backend.general.deleted'));
    }


    /**
     * Publish / Unpublish formations
     *
     * @param  Request
     */
    public function publish($id)
    {
        if (!Gate::allows('bundle_edit')) {
            return abort(401);
        }

        $bundle = Bundle::findOrFail($id);
        if ($bundle->published == 1) {
            $bundle->published = 0;
        } else {
            $bundle->published = 1;
        }
        $bundle->save();

        return back()->with('success', trans('alerts.backend.general.updated'));
    }
}
