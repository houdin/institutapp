<template>
  <!-- @inject('markdown', 'Parsedown')
@php
    // TODO: There should be a better place for this.
    $markdown->setSafeMode(true);
@endphp -->

  <div :id="'comment-' + comment.id" class="media">
    <img class="mr-3" src="/assets/images/user-default.jpg?s=64" :alt="comment.commenter.full_name + ' Avatar'">
    <div class="media-body">
      <h5 class="mt-0 mb-1">{{ comment.commenter.full_name }} <small class="text-muted">- {{ $date.formatDistance(new
      Date(comment.created_at), new Date()) }}</small></h5>
      <div style="white-space: pre-wrap;">{{ comment.comment }}</div>

      <div>
        <!-- @can('reply-to-comment', $comment) -->
        <button v-if="permissions.reply_to_comment === true" data-toggle="modal"
          data-target="#reply-modal-{{ $comment.id }}"
          class="btn btn-sm btn-link text-uppercase">@lang('comments::comments.reply')</button>
        <!-- @can('edit-comment', $comment) -->
        <button v-if="permissions.edit_comment === true" data-toggle="modal"
          data-target="#comment-modal-{{ $commen.id }}"
          class="btn btn-sm btn-link text-uppercase">@lang('comments::comments.edit')</button>
        <!-- @can('delete-comment', $comment) -->
        <template v-if="permissions.delete_comment === true">
          <a href="#" @click.prevent="deleteComment(comment.id)"
            class="btn btn-sm btn-link text-danger text-uppercase">@lang('comments::comments.delete')</a>

        </template>

      </div>

      <!-- @can('edit-comment', $comment) -->
      <div v-if="permissions.edit_comment === true" class="modal fade" id="comment-modal-{{ comment.id }}" tabindex="-1"
        role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <!-- <form method="POST" action="{{ route('comments.update', comment.getKey()) }}"> -->
            <form method="POST">
              <!-- @method('PUT')
              @csrf -->
              <div class="modal-header">
                <h5 class="modal-title">@lang('comments::comments.edit_comment')</h5>
                <button type="button" class="close" data-dismiss="modal">
                  <span>&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="message">@lang('comments::comments.update_your_message_here')</label>
                  <textarea required class="form-control" name="message" rows="3" v-model="comment.comment"></textarea>
                  <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' =>
                    'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase"
                  data-dismiss="modal">@lang('comments::comments.cancel')</button>
                <button type="submit"
                  class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.update')</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- @can('reply-to-comment', $comment) -->
      <div v-if="permissions.reply_to_comment === true" class="modal fade" id="reply-modal-{{ comment.id }}"
        tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <!-- <form method="POST" action="{{ route('comments.reply', $comment->getKey()) }}"> -->
            <form method="POST">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title">@lang('comments::comments.reply_to_comment')</h5>
                <button type="button" class="close" data-dismiss="modal">
                  <span>&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="message">@lang('comments::comments.enter_your_message_here')</label>
                  <textarea required class="form-control" name="message" rows="3"></textarea>
                  <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' =>
                    'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase"
                  data-dismiss="modal">@lang('comments::comments.cancel')</button>
                <button type="submit"
                  class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.reply')</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <br />
      <!-- {{-- Margin bottom --}} -->

      <!-- <?php
            if (!isset($indentationLevel)) {
                $indentationLevel = 1;
            } else {
                $indentationLevel++;
            }
        ?> -->

      <!-- {{-- Recursion for children --}} -->
      <!-- @if($grpComments->has($comment->getKey()) && $indentationLevel <= $maxIndentationLevel)
            {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
            @foreach($grpComments[$comment->getKey()] as $child)
                @include('comments::_comment', [
                    'comment' => $child,
                    'grouped_comments' => $grpComments
                ])
            @endforeach
        @endif -->
      <div v-if="comments.length > 0">

        <!-- @if($comment_id == '') -->
        <template v-if="!!grpComments[comment.id] && indentationLevel <= maxIndentationLevel">
          <!-- <template v-for="comments in grpComments[comment.id]"> -->

          <one-comment v-for="child in   grpComments[comment.id]" :key="child.id" :comment="child"
            :grp-comments="grouped_comments" :max-indentation-level="3"></one-comment>
          <!-- </template> -->
        </template>

      </div>

    </div>
  </div>
  <template v-if="!!grpComments[comment.id] && indentationLevel <= maxIndentationLevel">
    <!-- <template v-for="comments in grpComments[comment.id]"> -->

    <one-comment v-for="child in grpComments[comment.id]" :key="child.id" :comment="child"
      :grp-comments="grouped_comments" :max-indentation-level="3"></one-comment>
    <!-- </template> -->
  </template>
  <!-- {{-- Recursion for children --}}
@if($grpComments->has($comment->getKey()) && $indentationLevel > $maxIndentationLevel)
    // TODO: Don't repeat code. Extract to a new file and include it.
    @foreach($grpComments[$comment->getKey()] as $child)
        @include('comments::_comment', [
            'comment' => $child,
            'grouped_comments' => $grpComments
        ])
    @endforeach
@endif  -->
</template>

<script setup lang="ts">
const { ref, reactive } = require("@vue/reactivity");

const can_reply_comment = ref(false);
const can_delete_comment = ref(false);
const can_edit_comment = ref(false);

const permissions = reactive({
  "reply-to-comment": false,
  "delete-comment": false,
  "edit-comment": false,
});

const deleteComment = (id) => {
  try {
    const res = axios.post(Laravel.urls.comments_destroy, { id: id });
    return res.data;
  } catch (error) {}
};
</script>


