{{-- <div class="row carousel-holder">
    <div class="col-md-12">
        <div id="ecommerce-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#ecommerce-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#ecommerce-carousel" data-slide-to="1"></li>
                <li data-target="#ecommerce-carousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="slide-image" src="{{ asset('images/headerimagescale.jpg') }}" alt="Image header of sale">
                </div>
                <div class="carousel-item">
                    <img class="slide-image"  src="{{ asset('images/headerimagescale2.jpg') }}" alt="Image header of sale two">
                </div>
            </div><!-- /.carousel-indicators -->
            <a class="carousel-control-prev" href="#ecommerce-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#ecommerce-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div><!-- /.carousel-example-generic -->
    </div><!-- /.col -->
</div><!-- /.row --> --}}

<div class="col-md-12 mb-5">
        <div class="banner-shop">
            <a href="#" class="banner-link">
                <img src="{{ asset('assets/images/products/temp/shop-banner.jpg') }}" alt="">
            </a>
        </div>

        <div class="wrap-shop-control bg-black-0">

            <h1 class="shop-title color-white-1">Digital & Electronics</h1>

            <div class="wrap-right">

                <div class="sort-item orderby ">
                    <select name="orderby" class="use-chosen">
                        <option value="menu_order" selected="selected">Default sorting</option>
                        <option value="popularity">Sort by popularity</option>
                        <option value="rating">Sort by average rating</option>
                        <option value="date">Sort by newness</option>
                        <option value="price">Sort by price: low to high</option>
                        <option value="price-desc">Sort by price: high to low</option>
                    </select>
                </div>

                <div class="sort-item product-per-page">
                    <select name="post-per-page" class="use-chosen">
                        <option value="12" selected="selected">12 per page</option>
                        <option value="16">16 per page</option>
                        <option value="18">18 per page</option>
                        <option value="21">21 per page</option>
                        <option value="24">24 per page</option>
                        <option value="30">30 per page</option>
                        <option value="32">32 per page</option>
                    </select>
                </div>


            </div>

        </div>
        <!--end wrap shop control-->
    </div>
