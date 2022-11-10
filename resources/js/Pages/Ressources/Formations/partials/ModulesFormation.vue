<template>
    <div v-if="modules[0]" id="accordion" class="panel-group">

        <div v-for="(module, index) in modules" :key="index" class="panel position-relative">

            <template v-if="module.model && module.model.published == 1">

                <template v-if="$page.props.app.user">

                    <div v-if="completedModules.indexOf(module.model.id) >= 0" class="position-absolute"
                        style="right: 0;top:0px">
                        <span class="gradient-bg p-1 text-white font-weight-bold completed"
                            v-html="trans.get('labels.frontend.formation.completed')"></span>
                    </div>

                </template>
                <div class="panel-title" id="headingOne">
                    <div class="ac-head">
                        <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + (index + 1)" aria-expanded="false"
                            :aria-controls="'collapse' + (index + 1)">
                            <span>{{ pad(index + 1) }}</span>
                            {{ module.model.title }}
                        </button>
                        <div v-if="module.model_type == 'App\\Models\\Test'" class="leanth-crs">
                            <span v-html="trans.get('labels.frontend.formation.test')"></span>
                        </div>
                    </div>
                </div>
                <div :id="'collapse' + (index + 1)" class="collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordion">
                    <div class="panel-body">
                        <template v-if="module.model_type == 'App\\Models\\Test'">{{ module.model.description.substr(0,
                                20) + '...'
                        }}</template>
                        <template v-else>{{ module.model.short_text }}</template>

                        <template v-if="$page.props.app.user">
                            <div v-if="completedModules.indexOf(module.model.id) >= 0">
                                <Link
                                    :href="$route('modules.show', { formation_id: module.formation_id, slug: module.model.slug })"
                                    class="btn btn-warning mt-3"><span class=" text-white font-weight-bold "
                                    v-html="trans.get('labels.frontend.formation.go') + '>'">
                                </span></Link>

                            </div>
                        </template>

                    </div>
                </div>
            </template>
        </div>

    </div>
</template>

<script setup lang="ts">

defineProps({ "modules": Object, "completedModules": Object });


// const modulesCustom = (modules) => {
//     const r = [];
//     let count = 1;
//     for (module in modules) {
//         modules[module].customIndex.push(count);
//         count++;
//     }
//     return modules;
// };

const pad = (n) => {
    return n < 10 ? "0" + n : n;
};
</script>

