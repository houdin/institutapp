<script setup lang="ts">


const form = useForm({
    name: '',
});

const createTeam = () => {
    form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="createTeam">
        <template #title>
            Team Details
        </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>
            <div class="col-span-6">
                <JetInputLabel value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="object-cover w-12 h-12 rounded-full" :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.props.user.name }}</div>
                        <div class="text-sm text-gray-700">
                            {{ $page.props.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetInputLabel for="name" value="Team Name" />
                <JetTextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetPrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </JetPrimaryButton>
        </template>
    </JetFormSection>
</template>
