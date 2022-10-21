@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.blog.title').' | '.app_name())

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333!important;
            font-weight: 700;
        }
        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color:white;
            border:none;

        }
        ul.pagination{
            display: inline;
            text-align: center;
        }
        .cat-item.active{
            background: black;
            color: white;
            font-weight: bold;
        }
    </style>
@endpush
@section('content')


    <!-- Start of blog content
        ============================================= -->
    <section id="blog-item" class="blog-item-post">
        <div class="container">
            <div class="blog-content-details">
                <div class="row">
                    <div class="col-md-9">
                        <div class="blog-post-content">


                            <div class="genius-post-item">
                                <div class="tab-container">
                                    @if(count($blogs) > 0)

                                        <div id="tab2" class="tab-content-1 pt35">
                                            <div class="blog-list-view">
                                                @foreach($blogs as $item)
                                                <div class="list-blog-item bg-black-1 shadow">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="blog-post-img-content border-0">
                                                                <div class="blog-img-date relative-position">
                                                                    <div class="blog-thumnile" @if($item->image )  style="background-image: url({{asset('assets/images/blogs/'.$item->image->name)}})" @endif>

                                                                    </div>
                                                                    <div class="formation-price text-center gradient-bg">
                                                                        <span>{{$item->created_at->format('d M Y')}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="blog-title-content headline">
                                                                <h3><a class="color-base-3" href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}">{{$item->title}}</a>
                                                                </h3>
                                                                <div class="blog-content">
                                                                    {!!  strip_tags(mb_substr($item->content,0,100).'...')  !!}
                                                                </div>

                                                                <div class="view-all-btn bold-font">
                                                                    <a class="color-base-3" href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}">@lang('labels.general.read_more')  <i
                                                                                class="fas fa-chevron-circle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div><!-- 2nd tab -->

                                    @endif


                                </div>
                            </div>


                            <div class="couse-pagination text-center ul-li">
                                {{ $blogs->links() }}
                            </div>
                        </div>
                    </div>
                   @include('frontend.blogs.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
    <!-- End of blog content
        ============================================= -->

@endsection
