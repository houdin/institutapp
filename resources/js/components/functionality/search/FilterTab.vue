<template>
  <div class="short-filter-tab">
    <div class="shorting-filter w-50 d-inline float-left me-3">
      <span v-html="trans.get('labels.frontend.formation.sort_by')"></span>
      <select id="sortBy" class="form-control d-inline w-50">
        <option value="" v-html="trans.get('labels.frontend.formation.none')"></option>
        <option value="popular" v-html="trans.get('labels.frontend.formation.popular')"></option>
        <option value="trending" v-html="trans.get('labels.frontend.formation.trending')"></option>
        <option value="featured" v-html="trans.get('labels.frontend.formation.featured')"></option>
      </select>
    </div>

    <!-- <div class="tab-button blog-button ul-li text-center float-right">
            <ul class="product-tab">
                <li class="active" rel="tab1"><i class="fas fa-th"></i></li>
                <li rel="tab2"><i class="fas fa-list"></i></li>
            </ul>
        </div> -->

  </div>
</template>
