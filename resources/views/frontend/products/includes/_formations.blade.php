@if($products->total() > 0)
    @foreach($products->items() as $product)
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="card mb-4">
                <img class="card-img-top" src="{{ asset('storage/uploads/pdts/'.$product->thumbnail()) }}" alt="Card image cap">
                <div class="card-body">
                    <div class="caption">
                                        <h4 class="card-title"><a href="{{ route('shopping.product.show', ['title' => $product->name]) }}">{{ $product->name }}</a></h4>
                <h4 class="{{ $product->hasSale() ? 'price-cut' : 'price-amount' }}">
                        ${{ $product->price }}
                        @if($product->hasSale())
                            <span class="pull-right price-amount">${{ $product->salePrice() }}</span>
                        @endif
                </h4>
                <p class="card-text">{{ $product->description }}</p>
                    </div>
                <add-cart-icon :product_id="'{{ $product->id }}'" @add-to-cart="addToCart" type="product">

                </add-cart-icon>
                <div class="ratings">
                    <p class="pull-right"><small class="text-muted">{{ $product->reviews()->count() }} reviews</small></p>
                    <review-stars :stars="'{{ round($product->reviews()->avg('stars'), PHP_ROUND_HALF_UP) }}'">

                    </review-stars>
                </div><!-- /.rating -->
                </div>
            </div>
        </div><!-- /.col -->
    @endforeach
@endif
<div class="row my-0 mx-auto">
    {{ $products->links() }}
</div><!-- /.row -->


