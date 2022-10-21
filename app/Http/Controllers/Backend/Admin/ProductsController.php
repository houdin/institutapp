<?php

namespace App\Http\Controllers\Backend\Admin;

use DataTables;
use App\Models\Image;
use App\Models\Media;
use function foo\func;
use App\Models\Product;
use App\Models\Category;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductTimeline;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreProductsRequest;
use App\Http\Requests\Admin\UpdateProductsRequest;

class ProductsController extends BackendBaseController
{
    use FileUploadTrait;

    /**
     * Display a listing of Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Gate::allows('product_access')) {
            return abort(401);
        }
        // Show the page

        $products = Product::all();

        return view('backend.products.index', compact('products'));
    }

    /**
     * Display a listing of Products via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $products = "";

        if (request('show_deleted') == 1) {
            if (!Gate::allows('product_delete')) {
                return abort(401);
            }
            $products = Product::onlyTrashed()
                ->whereHas('category')
                ->orderBy('created_at', 'desc')->get();
        } else if (request('cat_id') != "") {
            $id = request('cat_id');
            $products = Product::whereHas('category')
                ->where('category_id', '=', $id)->orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::whereHas('category')
                ->orderBy('created_at', 'desc')->get();
        }


        if (auth()->user()->can('product_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('product_edit')) {
            $has_edit = true;
        }
        // dd($products);

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.products', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.products.show', ['product' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.products.edit', ['product' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.products.destroy', ['product' => $q->id])])
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
                    ->with(['route' => route('admin.products.publish', ['id' => $q->id])])->render();
                return $view;
            })
            ->editColumn('product_image', function ($q) {
                return ($q->image_id != null) ? '<img height="50px" src="' . asset('assets/' . Image::find($q->image_id)->pluck('path')) . '">' : 'N/A';
            })
            ->editColumn('status', function ($q) {
                $text = "";
                $text = ($q->published == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-dark p-1 mr-1' >" . trans('labels.backend.products.fields.published') . "</p>" : "";
                $text .= ($q->featured == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-warning p-1 mr-1' >" . trans('labels.backend.products.fields.featured') . "</p>" : "";
                $text .= ($q->trending == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-success p-1 mr-1' >" . trans('labels.backend.products.fields.trending') . "</p>" : "";
                $text .= ($q->popular == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-primary p-1 mr-1' >" . trans('labels.backend.products.fields.popular') . "</p>" : "";
                return $text;
            })
            ->editColumn('price', function ($q) {
                if ($q->free == 1) {
                    return trans('labels.backend.products.fields.free');
                }
                return $q->price;
            })
            ->addColumn('category', function ($q) {
                return $q->category->name;
            })
            ->rawColumns(['product_image', 'actions', 'status'])
            ->make();
    }


    /**
     * Show the form for creating new Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('product_create')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');

        $categories = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('backend.products.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductsRequest $request)
    {
        if (!Gate::allows('product_create')) {
            return abort(401);
        }

        $request->all();

        $request = $this->saveFiles($request);

        $product = Product::create($request->all());

        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Product::class;
            $model_id = $product->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $product->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Product')
                    ->where('model_id', '=', $product->id)
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
                        ->where('model_id', '=', $product->id)
                        ->first();
                }
            } else if ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $product->title . ' - video';
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
            $product->slug = Str::slug($request->title);
            $product->save();
        }
        if ((int)$request->price == 0) {
            $product->price = NULL;
            $product->save();
        }


        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $product->teachers()->sync($teachers);


        return redirect()->route('admin.products.index')->with('success', trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Product.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('product_edit')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');
        $categories = Category::where('status', '=', 1)->pluck('name', 'id');


        $product = Product::findOrFail($id);

        return view('backend.products.edit', compact('product', 'teachers', 'categories'));
    }

    /**
     * Update Product in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductsRequest $request, $id)
    {
        if (!Gate::allows('product_edit')) {
            return abort(401);
        }
        $product = Product::findOrFail($id);
        $request = $this->saveFiles($request);

        //Saving  videos
        if ($request->media_type != "" || $request->media_type  != null) {
            if ($product->mediavideo) {
                $product->mediavideo->delete();
            }
            $model_type = Product::class;
            $model_id = $product->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $product->title . ' - video';
            $media = $product->mediavideo;
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
                    $filename = $product->title . ' - video';
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
                        ->where('model_type', '=', 'App\Models\Product')
                        ->where('model_id', '=', $product->id)
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


        $product->update($request->all());
        if (($request->slug == "") || $request->slug == null) {
            $product->slug = Str::slug($request->title);
            $product->save();
        }
        if ((int)$request->price == 0) {
            $product->price = NULL;
            $product->save();
        }

        $teachers = \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $product->teachers()->sync($teachers);

        return redirect()->route('admin.products.index')->with('success', trans('alerts.backend.general.updated'));
    }


    /**
     * Display Product.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('product_view')) {
            return abort(401);
        }
        $teachers = User::get()->pluck('name', 'id');
        $modules = \App\Models\Module::where('product_id', $id)->get();
        $tests = \App\Models\Test::where('product_id', $id)->get();

        $product = Product::findOrFail($id);
        $productTimeline = $product->productTimeline()->orderBy('sequence', 'asc')->get();

        return view('backend.products.show', compact('product', 'modules', 'tests', 'productTimeline'));
    }


    /**
     * Remove Product from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::findOrFail($id);
        if ($product->students->count() >= 1) {
            return redirect()->route('admin.products.index')->with('danger', trans('alerts.backend.general.delete_warning'));
        } else {
            $product->delete();
        }


        return redirect()->route('admin.products.index')->with('success', trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Product at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('product_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Product::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Product from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Product from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.index')->with('success', trans('alerts.backend.general.deleted'));
    }


    /**
     * Publish / Unpublish products
     *
     * @param  Request
     */
    public function publish($id)
    {
        if (!Gate::allows('product_edit')) {
            return abort(401);
        }

        $product = Product::findOrFail($id);
        if ($product->published == 1) {
            $product->published = 0;
        } else {
            $product->published = 1;
        }
        $product->save();

        return back()->with('success', trans('alerts.backend.general.updated'));
    }
}
