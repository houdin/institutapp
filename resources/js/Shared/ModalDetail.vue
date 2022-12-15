<template>
    <TransitionRoot as="template" :show="openModalDetail.open">
        <Dialog as="div" class="relative z-10" @close="openModalDetail.open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <Transition Child as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel as="div"
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all  sm:w-full sm:max-w-sm ">
                            <div class="m-0 p-0">
                                <div class="mt-3 text-center sm:mt-5 ">
                                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">New {{
                                            openModalDetail.type?.toUpperCase()
                                    }}
                                    </DialogTitle>

                                </div>
                                <div class="px-4 pt-2 pb-4 sm:p-6 sm:my-2">

                                    <ProjectForm v-if="openModalDetail.type === 'project'" />
                                    <TaskForm v-if="openModalDetail.type === 'task'" />
                                    <IssueForm v-if="openModalDetail.type === 'issue'" />
                                    <ClientForm v-if="openModalDetail.type === 'client'" />
                                    <FileForm v-if="openModalDetail.type === 'file'" />


                                </div>
                            </div>

                        </DialogPanel>
                    </Transition>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup lang="ts">
import ProjectForm from '@/Pages/Projects/ProjectForm.vue'
import IssueForm from '@/Pages/Issues/IssueForm.vue'
import ClientForm from '@/Pages/Clients/ClientForm.vue'

import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'


const openModalDetail = inject('openModalDetail')



</script>


