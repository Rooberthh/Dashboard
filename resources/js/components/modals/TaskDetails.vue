<template>
    <modal name="task-details"
           height="auto"
           @before-open="beforeOpen"
    >
        <article class="card p-5">
            <div class="card-body">
                <div class="card-header flex mb-6">
                    <div class="flex-1">
                        <input class="w-full font-bold text-l" type="text" v-model="task.title" @change="update()"/>
                    </div>
                    <div class="ml-3">
                        <font-awesome-icon @click="close" class="cross text-gray-600 text-xl" :icon="['fas', 'plus']"></font-awesome-icon>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex my-3">
                        <div>

                        </div>
                        <div class="flex-1 font-bold">
                            Description
                        </div>
                    </div>
                    <textarea class="w-full p-3 bg-gray-300 rounded textarea" v-model="task.description" @change="update()"></textarea>
                </div>
                <div class="mb-6">
                    <div class="flex my-3">
                        <div>

                        </div>
                        <div class="flex-1 font-bold">
                            Objectives
                        </div>
                    </div>
                    <objectives @refetch="refetch" :task-id="task.id"></objectives>
                </div>
                <div class="flex">
                    <button class="btn ml-auto" type="button" @click="destroy">Delete</button>
                </div>
            </div>
        </article>
    </modal>
</template>

<script>
    import Objectives from '../Objectives/Objectives'
    import axios from 'axios';

    export default {
        name: "TaskDetails",
        components: {
            Objectives
        },
        data() {
            return {
                task: {},
                editing: false,
            }
        },
        methods: {
            beforeOpen(e) {
                this.task = e.params;
            },
            close() {
                this.$modal.hide('task-details');
            },
            refetch() {
                this.$emit('refetch');
            },
            update() {
                axios.patch(this.getBaseUrl() + `/statuses/${this.task.status_id}/tasks/${this.task.id}`, this.task)
                    .then(() => {
                        flash('Task have been updated');

                        this.refetch();
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            destroy() {
                axios.delete(this.getBaseUrl() + `/statuses/${this.task.status_id}/tasks/${this.task.id}`)
                    .then(() => {
                        this.close();
                        flash('Task have been deleted');

                        this.refetch();
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            }
        }
    }
</script>

<style scoped>
    .textarea {
        min-height: 8rem;
    }
    .cross {
        transform: rotate(45deg);
        cursor: pointer;
    }
</style>
