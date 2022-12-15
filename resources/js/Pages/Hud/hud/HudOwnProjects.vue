<template >
    <input placeholder="Search projects" type="text" class="form-control" v-model="my_project_text" />
    <hr />
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="project in projects" :key="index">
                <td>{{ index + 1 }}</td>

                <td>
                    <Link :href="route('projects.show', { 'id': project.id })">{{ project.name }}</Link>

                </td>

                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                            aria-valuemax="100"
                            style="width:{{ project.completedWeight / project.totalWeight * 100 }}%;"></div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script setup lang="ts">
</script>
