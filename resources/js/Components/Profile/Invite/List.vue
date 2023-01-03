<script setup>
import Item from "@/Components/Profile/Invite/Item.vue";
const props = defineProps({
    invitations: Array,
});
</script>

<template>
    <div v-for="invite in invitations" class="card bg-white p-5 rounded-lg shadow flex flex-col mb-3">
        <Item :invite="invite" />
    </div>
</template>
