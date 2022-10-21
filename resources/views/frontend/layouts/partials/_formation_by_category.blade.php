<section id="formation-category" class="formation-category-section">
    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.formations_categories')</span>
            <h2>@lang('labels.frontend.layouts.partials.browse_formation_by_category')</h2>
        </div>
        @if($formation_categories)
            <div class="category-item">
                <div class="row">
                    @foreach($formation_categories->take(8) as $category)
                        <div class="col-md-3">
                            <a href="{{route('formations.category',['category'=>$category->slug])}}">
                                <div class="category-icon-title text-center ">
                                    <div class="category-icon">
                                        <i class="text-gradiant {{$category->icon}}"></i>
                                    </div>
                                    <div class="category-title">
                                        <h4>{{$category->name}}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                @endforeach
                <!-- /category -->
                </div>
            </div>
        @endif
    </div>
</section>
