<script setup>
const props = defineProps({
    project: Object
});
</script>

<template>
    <div class="card bg-white p-5 rounded-lg shadow flex flex-col" style="height: 200px">
        <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-300 pl-4">
            <a href="" class="text-default no-underline">{{ project.title }}</a>
        </h3>

        <div class="mb-4 flex-1">{{ project.shortDescription }}</div>
    </div>
</template>
