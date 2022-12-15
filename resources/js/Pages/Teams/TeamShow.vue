<script setup lang="ts">


defineProps({
    team: Object,
    availableRoles: Array,
    permissions: Object,
});
</script>

<template>

    <AppTitle title=" Team| Settings"></AppTitle>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <UpdateTeamNameForm :team="team" :permissions="permissions" />

            <TeamMemberManager class="mt-10 sm:mt-0" :team="team" :available-roles="availableRoles"
                :user-permissions="permissions" />

            <template v-if="permissions.canDeleteTeam && !team.personal_team">
                <JetSectionBorder />

                <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
            </template>
        </div>
    </div>

</template>
