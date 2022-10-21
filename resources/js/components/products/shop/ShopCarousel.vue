<template>
  <div class="col-md-12 mb-5">
    <div class="banner-shop">
      <a href="#" class="banner-link">
        <img :src="$filters.asset('assets/images/products/temp/shop-banner.jpg')" alt="">
      </a>
    </div>

    <div class="wrap-shop-control bg-gray-8">

      <h1 class="shop-title color-gray-1">Digital & Electronics</h1>

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
</template>

<script>
export default {};
</script>
