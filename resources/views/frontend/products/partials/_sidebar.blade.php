
{{-- <div class="list-group" v-if="show.showSideBar">
    @foreach($categories as $category)
        <a class="list-group-item {{ (isset($search ) && $search === $category->name) ? 'active' : '' }}"
           href="{{ route('shopping.search.product.category' , ['category' => $category->name ]) }}">
            {{ $category->name }}
        </a>
    @endforeach
</div> --}}
<div class="col-md-12 sitebar py-4 bg-black-0 rounded-lg">
    <div class="widget mercado-widget categories-widget">
        <h2 class="widget-title">All Categories</h2>
        <div class="widget-content">
            <ul class="list-category">
                <li class="category-item has-child-cate">
                    <a href="#" class="cate-link">Fashion & Accessories</a>
                    <span class="toggle-control">+</span>
                    <ul class="sub-cate">
                        <li class="category-item"><a href="#" class="cate-link">Batteries (22)</a></li>
                        <li class="category-item"><a href="#" class="cate-link">Headsets (16)</a></li>
                        <li class="category-item"><a href="#" class="cate-link">Screen (28)</a></li>
                    </ul>
                </li>
                <li class="category-item has-child-cate">
                    <a href="#" class="cate-link">Furnitures & Home Decors</a>
                    <span class="toggle-control">+</span>
                    <ul class="sub-cate">
                        <li class="category-item"><a href="#" class="cate-link">Batteries (22)</a></li>
                        <li class="category-item"><a href="#" class="cate-link">Headsets (16)</a></li>
                        <li class="category-item"><a href="#" class="cate-link">Screen (28)</a></li>
                    </ul>
                </li>
                <li class="category-item has-child-cate">
                    <a href="#" class="cate-link">Digital & Electronics</a>
                    <span class="toggle-control">+</span>
                    <ul class="sub-cate">
                        <li class="category-item"><a href="#" class="cate-link">Batteries (22)</a></li>
                        <li class="category-item"><a href="#" class="cate-link">Headsets (16)</a></li>
                        <li class="category-item"><a href="#" class="cate-link">Screen (28)</a></li>
                    </ul>
                </li>
                <li class="category-item">
                    <a href="#" class="cate-link">Tools & Equipments</a>
                </li>
                <li class="category-item">
                    <a href="#" class="cate-link">Kid’s Toys</a>
                </li>
                <li class="category-item">
                    <a href="#" class="cate-link">Organics & Spa</a>
                </li>
            </ul>
        </div>
    </div><!-- Categories widget-->

{{--
    <div class="widget mercado-widget widget-product">
        <h2 class="widget-title">Popular Products</h2>
        <div class="widget-content">
            <ul class="products">
                <li class="product-item">
                    <div class="product product-widget-style">
                        <div class="thumbnnail">
                            <a href="detail.html" title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                <figure><img src="{{ asset('assets/images/products/temp/products/digital_01.jpg') }}"
                                        alt=""></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                    Speaker...</span></a>
                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                        </div>
                    </div>
                </li>

                <li class="product-item">
                    <div class="product product-widget-style">
                        <div class="thumbnnail">
                            <a href="detail.html" title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                <figure><img src="{{ asset('assets/images/products/temp/products/digital_17.jpg') }}"
                                        alt=""></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                    Speaker...</span></a>
                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                        </div>
                    </div>
                </li>

                <li class="product-item">
                    <div class="product product-widget-style">
                        <div class="thumbnnail">
                            <a href="detail.html" title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                <figure><img src="{{ asset('assets/images/products/temp/products/digital_18.jpg') }}"
                                        alt=""></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                    Speaker...</span></a>
                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                        </div>
                    </div>
                </li>

                <li class="product-item">
                    <div class="product product-widget-style">
                        <div class="thumbnnail">
                            <a href="detail.html" title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                <figure><img src="{{ asset('assets/images/products/temp/products/digital_20.jpg') }}"
                                        alt=""></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                    Speaker...</span></a>
                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div><!-- brand widget--> --}}

</div>
<!--end sitebar-->
