<script setup>
const props = defineProps({
    activity: Object
});
</script>

<template>
    <div v-if="activity.type === 'create_project'">
        {{ activity.user.name }} created the project
    </div>
    <div v-else-if="activity.type === 'update_project_title'">
        {{ activity.user.name }} updated title: <b>"{{ activity.oldValue }}"</b> => <b>"{{ activity.newValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'update_project_description'">
        {{ activity.user.name }} updated description: <b>"{{ activity.oldValue }}"</b> => <b>"{{ activity.newValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'update_project_notes'">
        {{ activity.user.name }} updated notes: <b>"{{ activity.oldValue }}"</b> => <b>"{{ activity.newValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'create_task'">
        {{ activity.user.name }} created task: <b>"{{ activity.newValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'update_task'">
        {{ activity.user.name }} updated task: <b>"{{ activity.oldValue }}"</b> => <b>"{{ activity.newValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'complete_task'">
        {{ activity.user.name }} completed task <b>"{{ activity.oldValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'incomplete_task'">
        {{ activity.user.name }} incompleted task <b>"{{ activity.oldValue }}"</b>
    </div>
    <div v-else-if="activity.type === 'new_member'">
        Added new member
    </div>
    <div v-else-if="activity.type === 'delete_member'">
        Member deleted
    </div>
</template>
