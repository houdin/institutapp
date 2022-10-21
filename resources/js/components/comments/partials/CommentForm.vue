<template>
  <div class="card">
    <div class="card-body">
      <div v-if="errors.commentable_type" class="alert alert-danger" role="alert">
        {{ $errors.commentable_type[0] }}
      </div>
      <div v-if="errors.commentable_id" class="alert alert-danger" role="alert">
        {{ $errors.commentable_id[0] }}
      </div>
      <!-- <form method="POST" action="{{ route('comments.store') }}"> -->
      <form method="POST">

        <!-- <input type="hidden" name="commentable_type" value="{{ get_class($model) }}" />
            <input type="hidden" name="commentable_id" value="{{ $model->getKey() }}" /> -->

        <div class="form-group">
          <label for="message">{{ trans.get('comments::comments.enter_your_message_here')}}</label>
          <textarea :class="{'form-control': true, 'is-invalid': errors.message }" name="message" rows="3"></textarea>
          <div class="invalid-feedback">
            {{ trans.get('comments::comments.your_message_is_required') }}
          </div>
          <small class="form-text text-muted">{{ trans.get('comments::comments.markdown_cheatsheet', {'url' : 'https://help.github.com/articles/basic-writing-and-formatting-syntax'}) }}</small>
        </div>
        <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">{{ trans.get('comments::comments.submit') }}</button>
      </form>
    </div>
  </div>
  <br />
</template>

<script setup>
const { ref } = require("@vue/reactivity");

const erros = ref({});
</script>
