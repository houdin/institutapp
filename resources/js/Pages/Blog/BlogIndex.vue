<template>
    <AppTitle title="Notre| Blog" classes="mb-12"></AppTitle>


    <div class=" space-y-10 ">

        <template v-if="$page.props.articles.data[0]">
            <!-- :ref="setItemRef" -->
            <article v-for="(item, index) in $page.props.articles.data" :key="item.id" :data-item-ref="item.id">
                <div class="card postcard dark group">
                    <div
                        class="flex flex-col md:flex-row gap-0 bg-gray-900 rounded-lg  drop-shadow-lg h-[300px] relative">

                        <span class="absolute w-full h-full rounded-lg opacity-40" :style="{
                            'backgroundImage': `linear-gradient(${index % 2 ? '80deg' : '-80deg'}, #${item.image?.colors[1].hex}, transparent 50%)`
                        }">
                        </span>
                        <Link :href="route('blogs.show', { slug: item.slug })" class="card__img_link">
                        <div class="thumbnail h-full w-[350px] relative">
                            <figure class="w-full h-full rounded-l-lg">
                                <img v-if="item.image"
                                    class=" h-full max-w-none transition-transform ease-in-out group-hover:scale-110 duration-200"
                                    :src="$helpers.Image.featuredImageUrl(item.image, 3)" alt="Image Title" />
                            </figure>
                            <!-- <app-picture v-if="!!item?.image" :class="'postcard__img'" :title="item.title" :image="item.image" :thumb="3" :thumbs="[3,3,2,2,2]"></app-picture> -->
                        </div>
                        </Link>

                        <div class="flex card-details relative">
                            <div class="card-body flex flex-col px-7 py-8 justify-between">
                                <h2 class="title text-2xl font-bold">
                                    <Link class="" :href="route('blogs.show', { slug: item.slug })">{{ item.title }}
                                    </Link>
                                </h2>

                                <div class="date text-xs">
                                    <time datetime="2020-05-25 12:00:00">
                                        <!-- <i class="fas fa-calendar-alt mr-2"></i>Mon, May 25th 2020 -->
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        {{ $date.format(new Date(item.created_at), "E', 'dd MMM yyyy", {
                                                locale:
                                                    $locale()
                                            })
                                        }}
                                    </time>
                                    <!-- <span>{{ format(new Date(item.created_at), 'd/M/Y') }}</span> -->
                                </div>
                                <div class="card__bar w-10 h-2 bg-gray-500 rounded-full mt-3 transition-width duration-200 ease-in-out group-hover:w-40"
                                    :style="{ backgroundColor: '#' + item.image?.colors[0].hex }">
                                </div>
                                <div class="card__preview-txt">{{ $helpers.Text.truncate(item.content, 300) }}</div>
                                <ul class="flex space-x-3">
                                    <li class="tag__item"><i class="fas fa-tag mr-2"></i>Podcast</li>
                                    <li class="tag__item"><i class="fas fa-clock mr-2"></i>55 mins.</li>
                                    <li class="tag__item play ">
                                        <div class="tag__item_btn">
                                            <div class="view-all-btn ">
                                                <Link as="button" class="btn btn-primary rounded-full"
                                                    :href="route('blogs.show', { slug: item.slug })">
                                                {{
                                                        trans.get('labels.general.read_more')
                                                }} <i class="fas fa-chevron-circle-right"></i>
                                                </Link>
                                                <!-- <a class="color-base-2" href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}">{{ trans.get('labels.general.read_more') }}  <i
                        class="fas fa-chevron-circle-right"></i></a> -->
                                            </div>

                                            <!-- <router-link class="fas fa-play mr-2" :to="{ name: 'blogs.show', params: {slug : item.slug} }">Lire l'article</router-link> -->
                                            <!-- <a href="#"><i class="fas fa-play mr-2"></i></a> -->
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- <blog-item :item="item" :img="getPalette(item.image.url, index)"></blog-item> -->
                        <!-- <div> -->
                    </div>
                </div>
            </article>
        </template>

    </div>
    <Pagination v-if="$page.props.articles.data[0]" :links="$page.props.articles.links" />


    <!-- <h1 class="widget-title text-capitalize"><span>Find </span>Your Course.</h1> -->

    <!-- <div class="blog-content-details">
    <div class="row">
      <div class="col-md-9">
        <div class="blog-post-content">

          <div v-if="articles[0]" class="genius-post-item">
            <div class="blog-list-view">

              <infinite-scroll @refetch="getArticles" :items="articles" :lastPage="last_page" :loading="loading" custom-class="list-blog-item bg-gray-6 shadow">

                <template v-slot:item="{ item }">

                  <blog-item :item="item"></blog-item>

                </template>

              </infinite-scroll>

            </div>

          </div>

        </div>
      </div>
      <blog-sidebar v-if="articles[0]" :popular-tags="popular_tags" :categories="categories" :tags="tag" :category="category"></blog-sidebar>

    </div>
  </div> -->

</template>

<script setup lang="ts">


</script>



