<script setup>

import Item from "@/Components/Task/Item.vue";

const props = defineProps({
    tasks: Array,
});
</script>

<template>
    <div v-for="task in tasks" class="card bg-white p-5 rounded-lg shadow flex flex-col mb-3">
        <Item :task="task" />
    </div>
</template>
