<template>
  <!-- @php
  if (isset($approved) and $approved == true) {
  $comments = $model->approvedComments;
  } else {
  $comments = $model->comments;
  }
  @endphp -->

  <div v-if="comments.length < 1" class="alert alert-warning">
    {{ trans.get('comments::comments.there_are_no_comments') }}
  </div>

  <comment-form v-if="$filters.Auth.check()"></comment-form>

  <div v-else class="card">
    <div class="card-body">
      <h5 class="card-title">{{ trans.get('comments::comments.authentication_required')}}</h5>
      <p class="card-text">{{ trans.get('comments::comments.you_must_login_to_post_a_comment') }}</p>
      <router-link :to="{ name:'logi n'}" class="btn btn-primary">{{ trans.get('comments::comments.log_in')}}
      </router-link>
    </div>
  </div>

  <div v-if="comments.length > 0">

    <!-- @if($comment_id == '') -->
    <template v-for="comments in grouped_comments">
      <!-- <template v-if="comment_id"> -->

      <one-comment v-for="comment in comments" :key="comment.id" :comment="comment" :grp-comments="grouped_comments"
        :max-indentation-level="3"></one-comment>
      <!-- </template> -->
    </template>

  </div>

</template>

<script setup lang="ts">
const { inject, ref, reactive } = require("@vue/runtime-core");

const $filters = inject("$filters");

// $comments->sortBy('created_at');
// $comments->groupBy('child_id');
const comments = ref([]);

const grouped_comments = ref();
</script>

