<template>
  <div id="search-formation" class="search-formation-section">

    <div class="search-formation mb30 position-relative ">
      <form :action="$laravel.urls.search" method="get">

        <div class="input-group search-group">
          <input class="formation" name="q" type="text" :placeholder="trans.get('labels.frontend.home.search_formation_placeholder')">
          <!-- <select name="category" class="select form-control">
                @if(count($categories) > 0 )
                <option value="">{{ trans.get('labels.frontend.formation.select_category') }}</option>
                @foreach($categories as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>

                @endforeach
                @else
                <option>>{{ trans.get('labels.frontend.home.no_data_available') }}</option>
                @endif

              </select> -->
          <div class="nws-button position-relative text-center  gradient-bg text-capitalize">
            <button type="submit" value="Submit">{{ trans.get('labels.frontend.home.search_formation') }}</button>
          </div>
        </div>
      </form>
    </div>

  </div>
</template>
