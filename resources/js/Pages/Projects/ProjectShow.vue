<template>
    <div>


        <div v-if="project.id">
            <div class="container mx-auto mb-7">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">


                        <Alert :item="project" type="" message="" />

                        <!-- <v-card>
                            <v-alert :value="true" v-if="project.completed" type="success"
                                @click="incompleteProject(project.id)" class="clickable">
                                Project completed {{ project.completed_date }}.
                            </v-alert>
                            <v-alert :value="true"
                                v-else-if="!project.completed && project.due_date != '' && project.due_date != null && new Date(project.due_date) < Date.now()"
                                type="error" @click="completeProject(project.id)" class="clickable">
                                Project was due {{ project.due_date }}.
                            </v-alert>
                            <v-alert :value="true" v-else-if="!project.completed" type="warning"
                                @click="completeProject(project.id)" class="clickable">
                                <span v-if="project.due_date">Project is due {{ project.due_date }}.</span>
                                <span v-else>Project is incomplete.</span>
                            </v-alert>
                        </v-card> -->
                        <div class="mt-5">
                            <div class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between">
                                <h4 class="sr-only">Visa</h4>
                                <div class="sm:flex flex-col sm:items-start">
                                    <FolderIcon class="h-5 w-5" aria-hidden="true" />
                                    <div class="mt-3 sm:mt-0 sm:ml-4">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ project.name }}</h3>
                                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                                            <p>{{ project.description }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center mt-3 sm:mt-0 sm:ml-4">
                                        <div class="flex items-center mr-4">
                                            <UserIcon class="h-5 w-5" aria-hidden="true" />
                                            <h3 class="text-lg font-medium leading-6 text-gray-900">Client</h3>
                                        </div>
                                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                                            <Link :href="'/clients/' + project.client.id"
                                                class="hover:underline text-blue-500">{{ project.client.name }}
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                                    <button type="button"
                                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">Edit</button>
                                </div>
                            </div>
                        </div>

                        <div class="flex">

                        </div>
                    </div>
                </div>
            </div>

            <ItemsViewer :showDetail="true" :data="project.tasks" type="task"
                :header="$page.props.headerTable.project.task" icon="Bars3CenterLeftIcon">
            </ItemsViewer>
            <ItemsViewer :showDetail="true" :data="project.issues" type="issue"
                :header="$page.props.headerTable.project.issue" icon="BugAntIcon">
            </ItemsViewer>
            <ItemsViewer :showDetail="true" :data="project.files" type="file"
                :header="$page.props.headerTable.project.file" icon="DocumentIcon">
            </ItemsViewer>

            <ModalDetail></ModalDetail>



            <!-- <v-dialog v-model="dialog" width="500">
                <v-form method="POST" id="editProjectForm" @submit.prevent="updateProject" ref="form" lazy-validation>
                    <v-card>
                        <v-card-title class="blue darken-3 white--text py-4 title">Edit Project</v-card-title>
                        <v-container grid-list-sm class="pa-4">
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-text-field :rules="[v => !!v || 'Name is required']" prepend-icon="work"
                                        label="Project Name" v-model="project.name" maxlength="100" required>
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-autocomplete :items="clients" item-text="name" item-value="id"
                                        label="Select a client" prepend-icon="person" v-model="project.client_id"
                                        :rules="[v => !!v || 'Client is required']" required></v-autocomplete>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea prepend-icon="notes" label="Description" v-model="project.description">
                                    </v-textarea>

                                    <v-dialog ref="datePicker" v-model="date_dialog"
                                        :return-value.sync="project.due_date" persistent lazy full-width width="290px">
                                        <template v-slot:activator="{ on }">
                                            <v-text-field v-model="project.due_date" label="Due Date"
                                                prepend-icon="event" readonly v-on="on"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="project.due_date" scrollable @change="dueDate">
                                            <v-spacer></v-spacer>
                                            <v-btn flat color="primary" @click="date_dialog = false">Cancel</v-btn>
                                            <v-btn flat color="primary" @click="$refs.dialog.save(due_date)">OK</v-btn>
                                            <v-spacer></v-spacer>
                                        </v-date-picker>
                                    </v-dialog>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn type="submit" flat color="blue darken-2">Save</v-btn>
                            <v-btn flat color="red darken-2" form="editProjectForm" @click="dialog = false">Cancel
                            </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog> -->
        </div>
        <!-- <div v-else>
            <v-container fluid grid-list-md>
                <v-layout row>
                    <v-flex xs12 class="text-sm-center mt-3">
                        <p class="headline">
                            <v-icon>warning</v-icon>
                            Sorry, we could not load this project.
                        </p>
                        <p class="subheading">This project either does not exist or you do not have access to it.</p>

                        <v-btn type="submit" flat color="blue darken-2" to="/">
                            <v-icon left>work</v-icon>
                            Return to Projects
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-container>
        </div> -->
    </div>
</template>

<script setup lang="ts">


import ProjectIssues from '@/Components/Projects/ProjectIssues.vue';
import { FolderIcon, UserIcon } from '@heroicons/vue/24/outline'

// import Event from './../events'


let dialog = ref(false);

let date_dialog = ref(false)
//    id: '',
const props = defineProps({
    project: Object,
    clients: Array
})

let form = useForm({
    name: usePage().props.value.project.name,
    description: usePage().props.value.project.description,
    due_date: usePage().props.value.project.due_date,
    client_id: usePage().props.value.project.client_id
})


//HEADER
//Project -> Status, Name, Client, Due, Actions
//Task -> Status, Description, Due Date, Actions
//Issue -> Status, Priority, Description, Created, Actions
//File -> File Name, Uploaded At, Actions




//props: ['id']

const modalData = reactive({
    open: false,
    type: ''
})
provide('modalData', modalData)

const openModalDetail = reactive({
    open: false,
    type: ''
})

watch(modalData, (current) => {
    openModalDetail.open = current.open;
    openModalDetail.type = current.type;
})

provide('openModalDetail', openModalDetail)



const dueDate = (due_date) => {
    date_dialog = false
    $refs.datePicker.save(due_date)
}
const updateProject = () => {
    if (this.$refs.form.validate()) {
        let name = this.project.name
        let description = this.project.description
        let due_date = this.project.due_date
        let client_id = this.project.client_id

        axios.put('/api/projects/' + props.project.id, { name, description, due_date, client_id })
            .then(response => {
                Inertia.on('success', response.data.message)
            })
            .catch(function (error) {
                Inertia.on('error', response.data.message)
            })

        //this.reset()
    }
}
const completeProject = (project_id) => {
    axios.post('/api/projects/' + project_id + '/complete')
        .then(response => {
            Inertia.reload()

            Inertia.on('success', response.data.message)
        })
        .catch(function (error) {
            Inertia.on('error', response.data.message)
        })
}
const incompleteProject = (project_id) => {
    axios.post('/api/projects/' + project_id + '/incomplete')
        .then(response => {
            Inertia.reload()

            Inertia.on('warning', response.data.message)
        })
        .catch(function (error) {
            Inertia.on('error', response.data.message)
        })
}


</script>
