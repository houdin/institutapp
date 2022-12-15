<template>
    <form>
        <div class="space-y-6">
            <div>
                <h1 class="text-lg font-medium leading-6 text-gray-900">Project Settings</h1>
                <p class="mt-1 text-sm text-gray-500">Let’s get started by filling in the information below to create
                    your new project.</p>
            </div>

            <div>
                <label for="project-name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <div class="mt-1">
                    <input type="text" name="project-name" id="project-name"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                        value="Project Nero">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <textarea id="description" name="description" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"></textarea>
                </div>
            </div>

            <div class="space-y-2">
                <div class="space-y-1">
                    <label for="add-team-members" class="block text-sm font-medium text-gray-700">Add Team
                        Members</label>
                    <p id="add-team-members-helper" class="sr-only">Search by email address</p>
                    <div class="flex">
                        <div class="flex-grow">
                            <input type="text" name="add-team-members" id="add-team-members"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                placeholder="Email address" aria-describedby="add-team-members-helper">
                        </div>
                        <span class="ml-3">
                            <button type="button"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                                <!-- Heroicon name: mini/plus -->
                                <svg class="-ml-2 mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                <span>Add</span>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="border-b border-gray-200">
                    <ul role="list" class="divide-y divide-gray-200">
                        <li class="flex py-4">
                            <img class="h-10 w-10 rounded-full"
                                src="https://images.unsplash.com/photo-1513910367299-bce8d8a0ebf6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                            <div class="ml-3 flex flex-col">
                                <span class="text-sm font-medium text-gray-900">Calvin Hawkins</span>
                                <span class="text-sm text-gray-500">calvin.hawkins@example.com</span>
                            </div>
                        </li>

                        <li class="flex py-4">
                            <img class="h-10 w-10 rounded-full"
                                src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                            <div class="ml-3 flex flex-col">
                                <span class="text-sm font-medium text-gray-900">Bessie Richards</span>
                                <span class="text-sm text-gray-500">bessie.richards@example.com</span>
                            </div>
                        </li>

                        <li class="flex py-4">
                            <img class="h-10 w-10 rounded-full"
                                src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                            <div class="ml-3 flex flex-col">
                                <span class="text-sm font-medium text-gray-900">Floyd Black</span>
                                <span class="text-sm text-gray-500">floyd.black@example.com</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <fieldset>
                <legend class="text-sm font-medium text-gray-900">Privacy</legend>

                <div class="isolate mt-1 -space-y-px rounded-md bg-white shadow-sm">
                    <!-- Checked: "bg-sky-50 border-sky-200 z-10", Not Checked: "border-gray-200" -->
                    <label
                        class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
                        <input type="radio" name="privacy-setting" value="Public access"
                            class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500"
                            aria-labelledby="privacy-setting-0-label" aria-describedby="privacy-setting-0-description">
                        <span class="ml-3 flex flex-col">
                            <!-- Checked: "text-sky-900", Not Checked: "text-gray-900" -->
                            <span id="privacy-setting-0-label" class="block text-sm font-medium">Public access</span>
                            <!-- Checked: "text-sky-700", Not Checked: "text-gray-500" -->
                            <span id="privacy-setting-0-description" class="block text-sm">This project would be
                                available to anyone who has the link</span>
                        </span>
                    </label>

                    <!-- Checked: "bg-sky-50 border-sky-200 z-10", Not Checked: "border-gray-200" -->
                    <label class="relative border p-4 flex cursor-pointer focus:outline-none">
                        <input type="radio" name="privacy-setting" value="Private to Project Members"
                            class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500"
                            aria-labelledby="privacy-setting-1-label" aria-describedby="privacy-setting-1-description">
                        <span class="ml-3 flex flex-col">
                            <!-- Checked: "text-sky-900", Not Checked: "text-gray-900" -->
                            <span id="privacy-setting-1-label" class="block text-sm font-medium">Private to Project
                                Members</span>
                            <!-- Checked: "text-sky-700", Not Checked: "text-gray-500" -->
                            <span id="privacy-setting-1-description" class="block text-sm">Only members of this project
                                would be able to access</span>
                        </span>
                    </label>

                    <!-- Checked: "bg-sky-50 border-sky-200 z-10", Not Checked: "border-gray-200" -->
                    <label
                        class="rounded-bl-md rounded-br-md relative border p-4 flex cursor-pointer focus:outline-none">
                        <input type="radio" name="privacy-setting" value="Private to you"
                            class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500"
                            aria-labelledby="privacy-setting-2-label" aria-describedby="privacy-setting-2-description">
                        <span class="ml-3 flex flex-col">
                            <!-- Checked: "text-sky-900", Not Checked: "text-gray-900" -->
                            <span id="privacy-setting-2-label" class="block text-sm font-medium">Private to you</span>
                            <!-- Checked: "text-sky-700", Not Checked: "text-gray-500" -->
                            <span id="privacy-setting-2-description" class="block text-sm">You are the only one able to
                                access this project</span>
                        </span>
                    </label>
                </div>
            </fieldset>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                <input type="text" name="tags" id="tags"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
            </div>

            <div class="flex justify-end">
                <button type="button"
                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">Cancel</button>
                <button type="submit"
                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-sky-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">Create
                    this project</button>
            </div>
        </div>
    </form>

</template>

<script setup lang="ts">

</script>
