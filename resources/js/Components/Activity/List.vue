<script setup>
import Item from "@/Components/Activity/Item.vue";

const props = defineProps({
    activities: Array
});
</script>

<template>
    <ul class="text-xs list-reset" v-for="activity in activities">
        <Item :activity="activity"/>
    </ul>
</template>
