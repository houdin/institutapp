<script setup lang="ts">


const props = defineProps({
    team: Object,
    permissions: Object,
});

const form = useForm({
    name: props.team.name,
});

const updateTeamName = () => {
    form.put(route('teams.update', props.team), {
        errorBag: 'updateTeamName',
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="updateTeamName">
        <template #title>
            Team Name
        </template>

        <template #description>
            The team's name and owner information.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <JetInputLabel value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_url"
                        :alt="team.owner.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-gray-700 text-sm">
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <JetInputLabel for="name" value="Team Name" />

                <JetTextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                    :disabled="!permissions.canUpdateTeam" />

                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template v-if="permissions.canUpdateTeam" #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>

            <JetPrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </JetPrimaryButton>
        </template>
    </JetFormSection>
</template>
