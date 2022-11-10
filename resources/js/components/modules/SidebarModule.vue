<template>
    <div id="sidebar" class="sidebar">
        <div class="formation-details-category ul-li">
            <p v-if="previous_module">
                <router-link
                    :to="{ name: 'modules.show', params: { formation_id : previous_module.formation_id, slug : previous_module.model.slug}}"
                    class="btn btn-block gradient-bg font-weight-bold text-white"><i
                        class="fa fa-angle-double-left"></i>
                    {{ trans.get('labels.frontend.formation.prev') }}</router-link>
                <!-- <a class="btn btn-block gradient-bg font-weight-bold text-white" href="{{ route('modules.show', [$previous_module->formation_id, $previous_module->model->slug]) }}"><i class="fa fa-angle-double-left"></i>
          {{ trans.get('labels.frontend.formation.prev') }}</a> -->
            </p>

            <p id="nextButton">
                <template v-if="next_module">
                    <router-link v-if="$filters.config('module_timer') == 1 && module.isCompleted"
                        :to="{name: 'modules.show', params: {formation_id: next_module.formation_id, slug: next_module.model.slug}}"
                        class="btn btn-block gradient-bg font-weight-bold text-white">
                        {{trans.get('labels.frontend.formation.next')}} <i class='fa fa-angle-double-right'></i>
                    </router-link>
                    <router-link v-else
                        :to="{name: 'modules.show', params: {formation_id: next_module.formation_id, slug: next_module.model.slug}}"
                        class="btn btn-block gradient-bg font-weight-bold text-white">
                        {{trans.get('labels.frontend.formation.next')}}<i class='fa fa-angle-double-right'></i>
                    </router-link>
                </template>

            </p>
            <template v-if="module.formation.progress() == 100">
                <form v-if="!module.formation.isUserCertified()" method="post"
                    action="{{route('admin.certificates.generate')}}">

                    <input type="hidden" value="module.formation.id" name="formation_id">
                    <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                        id="finish">{{ trans.get('labels.frontend.formation.finish_formation') }}</button>
                </form>
                <div v-else class="alert alert-success">
                    {{ trans.get('labels.frontend.formation.certified') }}
                </div>
            </template>

            <span class="float-none">{{ trans.get('labels.frontend.formation.formation_timeline') }}</span>

            <ul class="formation-timeline-list">
                <template v-for="(item, index) in module.formation.formationTimeline.orderBy('sequence').get()"
                    :key="index">
                    <li v-if="item.model && item.model.published == 1"
                        :class="module.id == item.model.id ? 'active': ''">
                        <router-link v-if="_.find(completed_modules, item.model.id)"
                            :to="{name: 'modules.show', params: {formation_id: module.formation.id, slug: item.model.slug}}">
                            {{item.model.title}}
                            <p v-if="item.model_type == 'App\Models\Test'" class="mb-0 text-primary">
                                - {{ trans.get('labels.frontend.formation.test') }}</p>
                            <i v-if="_.find(completed_modules, item.model.id)"
                                class="fa text-success float-right fa-check-square"></i>
                        </router-link>
                        <a v-else>
                            {{item.model.title}}
                            <p v-if="item.model_type == 'App\Models\Test'" class="mb-0 text-primary">
                                - {{ trans.get('labels.frontend.formation.test') }}</p>
                        </a>
                    </li>
                </template>

            </ul>
        </div>
        <div class="couse-feature ul-li-block">
            <ul>
                <li>
                    {{trans.get('labels.frontend.formation.chapters')}}
                    <span> {{ module.formation.chapterCount() }} </span>

                </li>
                <li>
                    {{trans.get('labels.frontend.formation.category')}}
                    <span>
                        <router-link
                            :to="{ name:'formations.category', params:{ category : module.formation.category.slug}}"
                            target="_blank">{{module.formation.category.name}}</router-link>
                    </span>
                </li>
                <li>
                    {{ trans.get('labels.frontend.formation.author') }}
                    <span>

                        <router-link v-for="(teacher, index) in module.formation.teachers" :key="index"
                            :to="{ name: 'teachers.show', params: {id: teacher.id}}" target="_blank">
                            {{teacher.full_name}} {{ index++ < module.formation.teachers.length ? ',' : '' }}
                                </router-link>
                    </span>
                </li>
                <li>
                    {{ trans.get('labels.frontend.formation.progress') }}
                    <span> <b> {{ module.formation.progress() }}
                            % {{ trans.get('labels.frontend.formation.completed') }}</b></span>
                </li>
            </ul>

        </div>
    </div>
</template>

<script setup>
</script>

