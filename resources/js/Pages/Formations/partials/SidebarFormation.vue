<template>
    <div class="side-bar">
        <div class="crs-side-bar-widget">

            <template v-if="$page.props.purchased_formation === true">

                <h3>

                    <span v-if="formation.free == 1"> {{ trans.get('labels.backend.formations.fields.free') }}</span>

                    <template v-else>
                        {{ trans.get('labels.frontend.formation.price') }}<span> {{ appCurrency + ' ' +
                                formation.price
                        }}</span>
                    </template>

                </h3>
                <!-- Cart::session(auth()->user()->id)->get( $formation->id)) -->
                <button
                    v-if="$page.props.app.user === true && $page.props.app.user.r === 'stu' && session_formation === true"
                    class="btn genius-btn btn-block text-center my-2 text-uppercase  btn-success text-white "
                    type="submit">{{ trans.get('labels.frontend.formation.added_to_cart') }}
                </button>
                <template v-else-if="$page.props.app.user === true">
                    <Link v-if="formation.free == 1" :href="$route('login')"
                        class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{
                                trans.get('labels.frontend.formation.get_now')
                        }} <i class="fas fa-caret-right"></i>
                    </Link>

                    <template v-else>

                        <Link :href="$route('login')"
                            class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{
                                    trans.get('labels.frontend.formation.buy_now')
                            }} <i class="fas fa-caret-right"></i>
                        </Link>
                        <Link :href="$route('login')"
                            class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{
                                    trans.get('labels.frontend.formation.add_to_cart')
                            }} <i class="fa fa-shopping-bag"></i>
                        </Link>

                    </template>
                </template>
                <template v-else-if="$page.props.app.user === true && $page.props.app.user.r === 'stu'">
                    <get-now-cart v-if="formation.free == 1" :product-id="formation.id" type="formation" cart-text
                        @getnow="formations_purchased"></get-now-cart>
                    <!-- <Form v-if="formation.free == 1" id="card-getnow" @submit.prevent="onSubmit_card_getnow" v-slot="{ errors }" ref="card_getnow" enctype="multipart/form-data">
            <Field as="hidden" name="formation_id" :value="formation.id" />
            <Field as="hidden" name="amount" :value="(formation.free == 1) ? 0 : formation.price" />
            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " href="#">{{ trans.get('labels.frontend.formation.get_now') }} <i class="fas fa-caret-right"></i></button>
          </Form> -->
                    <template v-else>
                        <!-- <Form id="card-checkout" @submit.prevent="onSubmit_card_checkout" v-slot="{ errors }" ref="card_checkout" enctype="multipart/form-data">

              <Field as="hidden" name="formation_id" :value="formation.id " />
              <Field as="hidden" name="amount" :value="(formation.free == 1) ? 0 : formation.price" />
              <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " href="#">{{ trans.get('labels.frontend.formation.buy_now') }} <i class="fas fa-caret-right"></i></button>
            </Form> -->
                        <add-cart-icon :product-id="formation.id" type="formation" cart-text></add-cart-icon>
                    </template>

                </template>

                <h6 v-else class="alert alert-danger"> {{ trans.get('labels.frontend.formation.buy_note') }}</h6>

            </template>
            <template v-else>

                <Link v-if="continueFormation !== null"
                    :href="route('modules.show', { formation_id: formation.id, slug: continueFormation.model.slug })"
                    class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{
                            trans.get('labels.frontend.formation.continue_formation')
                    }}

                <i class="fa fa-arow-right"></i>
                </Link>
            </template>

        </div>
        <div class="enrolled-student">
            <div class="comment-ratting float-left ul-li">
                <ul>
                    <li v-for="n in Math.round(formation.rating)" :key="n">
                        <AppHeroIcon icon="StarIcon" size="w-4 h-4" />
                    </li>
                </ul>
            </div>
            <div class="student-number ">
                {{ formation.students_count }} {{ trans.get('labels.frontend.formation.enrolled') }}
            </div>
        </div>
        <div class="crs-feature ul-li-block">
            <ul>
                <li> {{ trans.get('labels.frontend.formation.chapters') }}
                    <span> {{ formation.chapter_count }} </span>
                </li>

                <li class="d-inline-block w-100">{{ trans.get('labels.frontend.formation.category') }}
                    <span class="text-right" v-for="category in formation.categories" :key="category.id">
                        <!-- <a href="{{route('formations.category',['category'=>$formation->category->slug])}}"
                                target="_blank">{{ formation.category.name}}</a> -->
                        <Link :href="$route('formations.category', { category: category.slug })">
                        {{ category.name }}</Link>
                    </span>
                </li>
                <li> {{ trans.get('labels.frontend.formation.author') }} <span>

                        <!-- <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                            {{$teacher->full_name}}@if($key < count($formation->teachers )), @endif
                        </a> -->
                        <!-- <router-link v-for="( teacher, index) in formation.teachers" :key="index" :to="{ name: 'teachers.show', params: { id : teacher.id }}">
                            {{teacher.full_name + (index < Object.keys(formation.teachers).length ? ',' : '' )}}
                        </router-link> -->

                    </span>
                </li>
            </ul>

        </div>
    </div>
</template>

<script setup lang="ts">

const props = defineProps(["formation", "purchased", "continueFormation"]);


const appCurrency = usePage().props.value.app.appCurrency;

const session_formation = ref(false);

    // session_formation.value = await $filters.Session.cartSession(
    //     props.value.formation.id,
    //     "formation"
    // )
</script>

