<template>
    <div class="bg-white shadow-md p-3 my-3 task-card"
        @click="showDetails"
    >
        <p v-text="item.title"></p>
        <div class="flex">
            <div v-if="hasDescription" class="text-gray-600 px-2 py-1 text-xs mr-2">
                <font-awesome-icon :icon="['fas', 'align-left']"></font-awesome-icon>
            </div>
            <div v-if="hasObjectives" class="text-gray-600 px-2 py-1 rounded text-xs" :class="{objectivesCompleted: completed}">
                <font-awesome-icon :icon="['fas', 'check-square']"></font-awesome-icon>
                {{ completeObjectives }}
                /
                {{ totalObjectives }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Task",
        props: ['task'],
        data() {
            return {
                item: this.task,
            }
        },
        watch: {
            task: function(task) {
                this.item = task;
            }
        },
        methods: {
            showDetails() {
                window.events.$emit('show-taskDetails', this.task);
            }
        },
        computed: {
            completeObjectives() {
                return (this.item.objectives.filter(obj => obj.completed === true).length);
            },
            totalObjectives() {
                return (this.item.objectives.length);
            },
            completed() {
                return (this.item.objectives.filter(obj => obj.completed === true).length === this.item.objectives.length) && this.item.objectives.length > 0;
            },
            hasObjectives() {
                return (this.item.objectives && this.item.objectives.length > 0);
            },
            hasDescription() {
                return (this.item.description);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .task-card:hover {
        cursor: pointer;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
