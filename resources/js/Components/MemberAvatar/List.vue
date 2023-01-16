<script setup>
import AvatarListItem from "@/Components/MemberAvatar/Item.vue";

const props = defineProps({
    project: Object,
    members: Array
});
</script>

<template>
    <div class="flex">
        <AvatarListItem :url="member.user.gravatarUrl" :memberName="member.user.name" v-for="member in members" />
        <AvatarListItem :url="project.owner.gravatarUrl" :memberName="project.owner.name" />
    </div>
</template>
