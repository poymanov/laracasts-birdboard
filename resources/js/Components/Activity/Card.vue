<script setup>
import List from "@/Components/Activity/List.vue";

const props = defineProps({
    activities: Array
});
</script>

<template>
    <div class="card bg-white p-5 rounded-lg shadow flex flex-col mt-6">
        <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-300 pl-4">
            Activities
        </h3>
        <List :activities="activities"/>
    </div>
</template>
