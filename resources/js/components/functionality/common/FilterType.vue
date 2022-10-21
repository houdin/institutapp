<template>
  <div class="short-filter-tab">
    <div class="shorting-filter w-50 d-inline float-left me-3">
      <span v-html="trans.get('labels.frontend.formation.sort_by')"></span>
      <select id="sortBy" class="form-control d-inline w-50">
        <option value="">{{ trans.get('labels.frontend.formation.none') }}</option>
        <option value="popular">{{ trans.get('labels.frontend.formation.popular') }}</option>
        <option value="trending">{{ trans.get('labels.frontend.formation.trending') }}</option>
        <option value="featured">{{ trans.get('labels.frontend.formation.featured') }}</option>
      </select>
    </div>

  </div>
</template>

<script>
export default {
  props: {},

  methods: {
    jqu() {
      //     $(document).ready(function () {
      //     $(document).on('change', '#sortBy', function () {
      //         if ($(this).val() != "") {
      //             location.href = '{{url()->current()}}?type=' + $(this).val();
      //         } else {
      //             location.href = '{{route('tutorials.index')}}';
      //         }
      //     })
      //     @if(request('type') != "")
      //     $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
      //     @endif
      // });
    },
  },
};
</script>
