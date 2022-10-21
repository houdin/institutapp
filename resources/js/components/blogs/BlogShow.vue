<template>

  <div v-if="!!data?.blog" class="row justify-content-center">
    <div class="blog-details-content">
      <div class="post-content-details">

        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-9-md col-lg-8">
            <h1 class="mb-4">{{ data.blog.title }}</h1>
            <div class="date-meta ">
              <span><i class="fas fa-calendar-alt"></i> {{ $date.format(new Date(data.blog.created_at), 'EEEE, d MMMM yyyy')}}</span>
              <span v-if="!!data.blog?.author.first_name"><i class="fas fa-user"></i> {{data.blog.author.first_name}}</span>
              <span v-if="!!data.blog?.comments_count"><i class="fas fa-comment-dots"></i> {{data.blog.comments_count}}</span>
              <span><i class="fas fa-tag">

                </i>
                <router-link :to="{ name: 'blogs.category', params: { category : data.blog.category.slug}}">{{data.blog.category.name}}</router-link>
              </span>
            </div>

            <div v-if="!!data.blog?.image" class="blog-detail-thumbnile mb35">
              <img :src="$filters.Image.featuredImageUrl(data.blog.image, 5)" alt="">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-9-md col-lg-8">
            <p v-if="!!data.blog?.content " class="color-gray-1">
              {{ data.blog.content }}
            </p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-9-md col-lg-8">
            <div class="blog-share-tag">
              <div class="share-text float-left">
                {{ trans.get('labels.frontend.blog.share_this_news') }}
              </div>

              <div class="share-social ul-li float-right">
                <ul>
                  <li><a target="_blank" :href="`http://www.facebook.com/sharer/sharer.php?u=${currentUrl}`"><i class="fab fa-facebook-f"></i></a></li>
                  <li><a target="_blank" :href="`http://twitter.com/share?url=${currentUrl}&text=${data.blog.title}`"><i class="fab fa-twitter"></i></a></li>
                  <li><a target="_blank" :href="`http://www.linkedin.com/shareArticle?url=${currentUrl}&title=${data.blog.title}&summary=${data.blog.content.substr(0,40)}...`"><i class="fab fa-linkedin"></i></a></li>
                  <li><a target="_blank" :href="`https://api.whatsapp.com/send?phone=&text=${currentUrl}`"><i class="fab fa-whatsapp"></i></a></li>
                </ul>
              </div>
            </div>

            <div class="next-prev-post d-flex justify-content-between">
              <div v-if="!!data?.previous?.slug" class="next-post-item">
                <router-link :to="{ name: 'blogs.show', params: { slug : data.previous.slug}}" class="color-gray-1"><i class="fas fa-arrow-circle-left "></i>Article précédent</router-link>
              </div>

              <div v-if="!!data?.next?.slug" class="next-post-item">
                <router-link :to="{ name: 'blogs.show', params: { slug : data.next.slug}}" class="color-gray-1">Article suivant<i class="fas fa-arrow-circle-right"></i></router-link>
              </div>

            </div>
            <div class="w-100">
              <template v-if="!!data?.related_news[0]">
                <div class=" mb-4">
                  <h3 class="h-5"> Articles en lien avec "<span class="color-base-2">{{$_.capitalize(data.blog.category.name)}}</span>"</h3>
                </div>
                <div class="recent-post-item d-flex justify-content-between w-100">
                  <div v-for="item in data.related_news" :key="item.id" class="w-3">
                    <div class="w-100">
                      <h2 class="h5 mb-3">
                        <router-link :to="{ name: 'blogs.show', params: { slug : item.slug}}">{{item.title}}</router-link>
                      </h2>
                    </div>
                  </div>
                </div>
                <div class="recent-post-item d-flex justify-content-between w-100 ">
                  <div v-for="item in data.related_news" :key="item.id" class="w-40  h-180-px _border-rad-5 overflow-hidden">
                    <router-link :to="{ name: 'blogs.show', params: { slug : item.slug}}" class="w-100 h-100">
                      <img :src="$filters.Image.featuredImageUrl(item.image, 1)" alt="" class="w-100">
                    </router-link>

                    <!-- <div v-if="item?.image" class="blog-thumnile" :style="`background-image: url(${.url})`"></div> -->
                  </div>

                </div>
              </template>

            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-9-md col-lg-8">
            <div class="blog-comment-area ul-li about-teacher-2 pt-4">
              <div class="reply-comment-box">
                <div class="pb-3">
                  <h2 class="color-gray-5" v-html="trans.get('labels.frontend.blog.post_comments')"> </h2>
                </div>

                <div v-if="!!currentUser?.id" class="teacher-faq-form">
                  <form class="was-validated" data-lead="Residential">
                    <div class="mb-3">
                      <label for="validationTextarea" class="form-label">{{ trans.get('labels.frontend.blog.write_a_comment') }}</label>
                      <textarea class="form-control is-invalid" id="validationTextarea" placeholder="Required example textarea" required></textarea>
                      <div class="invalid-feedback">
                        Please enter a message in the textarea.
                      </div>
                    </div>

                    <div class="mb-3">
                      <button class="btn btn-primary" type="submit" disabled>{{ trans.get('labels.frontend.blog.add_comment') }}</button>
                    </div>
                  </form>
                  <Form @submit.prevent="submit" v-slot="{ errors}" data-lead="Residential">

                    <div class="form-group">
                      <label for="comment"> {{ trans.get('labels.frontend.blog.write_a_comment') }}</label>
                      <Field as="textarea" class="color-gray-1 mb-0" name="comment" v-model="comment" rules="required|alpha" id="comment" rows="2" cols="15" />
                      <span v-show="errors.comment" class="help-block text-danger">{{ errors.comment }}</span>
                    </div>

                    <div class="text-center">
                      <button type="submit" value="Submit" class="btn nws-button gradient-bg text-white"> {{ trans.get('labels.frontend.blog.add_comment') }}</button>
                    </div>
                  </Form>
                </div>
                <router-link v-else :to="{ name: 'login'}" class="btn nws-button gradient-bg text-white">{{ trans.get('labels.frontend.blog.login_to_post_comment') }}</router-link>
                <!-- <a v-else id="openLoginModal" class="btn nws-button gradient-bg text-white" data-target="#myModal"> </a> -->
              </div>

              <ul v-if="!!data.blog?.comments_count[0]" class="comment-list my-5">
                <li v-for="item in data.blog.comments" :key="item.id" class="d-block">
                  <div class="comment-avater">
                    <img :src="item.user.picture" alt="">
                  </div>

                  <div class="author-name-rate">
                    <div class="author-name float-left">
                      {{ trans.get('labels.frontend.blog.by') }}: <span>{{item.name}}</span>
                    </div>

                    <div class="time-comment float-right">{{ $date.formatDistance(new Date(item.created_at), new Date(), { addSuffix: true})}}</div><br>
                    <div v-if="!!currentUser?.id && item.user_id === currentUser.id" class="time-comment float-right">
                      <router-link :to="{ name: 'blogs.comment.delete', params : {id : item.id}}">{{trans.get('labels.general.delete')}}</router-link>

                    </div>
                  </div>
                  <div class="author-designation-comment">
                    <p>{{item.comment}}</p>
                  </div>
                </li>

              </ul>
              <p v-else class="my-5">{{trans.get('labels.frontend.blog.no_comments_yet')}}</p>

            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- <blog-sidebar :popular-tags="data.popular_tags" :categories="data.categories" :tags="data.blog.tags" :category="data.blog.category"></blog-sidebar> -->
  </div>

</template>

<script setup>
import { Form, Field } from "vee-validate";

import {
  computed,
  onBeforeMount,
  onMounted,
  ref,
  watch,
} from "@vue/runtime-core";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
const route = useRoute();
const store = useStore();
// method="POST" action="{{route('blogs.comment',['id'=>$blog->id])}}"
const data = ref(null);
getArticle();
const comment = ref("");

const currentUrl = Laravel.urls.index + route.path;

const currentUser = computed(() => store.state.CurrentUser.user);

onBeforeMount(async () => {});

onMounted(async () => {});

async function getArticle() {
  try {
    const response = await axios.get(
      Laravel.urls.blogs_show.replace(":slug", route.params.slug)
    );
    data.value = response.data;
  } catch (err) {
    console.log(err);
  }
}

watch(
  () => route.path,
  () => {
    // console.log(route.path);
    getArticle();
  }
);
const submit = (values) => {
  console.log(values);
};
</script>
