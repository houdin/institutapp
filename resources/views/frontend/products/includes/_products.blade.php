



@if($products->total() > 0)

    @foreach($products->items() as $product)


        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
            <div class="product  equal-elem card shop-card mb-4 bg-black-0 rounded-lg overflow-hidden shadow" style="height: 380px">
                <div class="product-thumnail">
                    <a href="{{ route('shopping.product.show', ['slug' => $product->slug]) }}">

                        <figure>

                            <img class="card-img-top" src="{{ asset('assets/images/pdts/'.$product->image->name) }}" alt="Card image cap">
                        </figure>
                    </a>
                </div>
                <div class="card-body">
                    <div class="caption">
                        <h4 class="card-title"><a href="{{ route('shopping.product.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a></h4>
                        <span>Weight : {{ $product->weight }} kg</span>
                <h4 class="{{ $product->hasSale() ? 'price-cut' : 'price-amount' }}">
                        ${{ $product->price }}
                        @if($product->hasSale())
                            <span class="pull-right price-amount">${{ $product->salePrice() }}</span>
                        @endif
                </h4>
                {{-- <p class="card-text">{{ $product->description }}</p> --}}
                    </div>
                <add-cart-icon :product_id="'{{ $product->id }}'" @add-to-cart="addToCart" type="product">

                </add-cart-icon>

                </div>
            </div>
        </div><!-- /.col -->
    @endforeach

@endif



