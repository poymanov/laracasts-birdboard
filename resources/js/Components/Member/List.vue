<script setup>
import Item from "@/Components/Member/Item.vue";
const props = defineProps({
    members: Array
});
</script>

<template>
    <div v-for="member in members" class="card bg-white p-5 rounded-lg shadow flex flex-col mb-3">
        <Item :member="member"/>
    </div>
</template>
