<template>
    <div class="p-2 rounded objective">
        <div class="flex items-center">
            <input class="mr-2" type="checkbox" name="completed" v-model="form.completed" @change="update()">

            <input type="text" class="w-full leading-loose pointer" :class="form.completed ? 'line-through' : ''" name="body" v-model="form.body" @change="update()">

            <i class="fas fa-trash ml-2" @click="remove()"></i>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['objective'],
        data() {
            return {
                id: this.objective.id,
                form: {
                    body: this.objective.body,
                    completed: this.objective.completed,
                },
                endpoint: this.getGatewayUrl() + `tasks/${this.objective.task_id}/objectives/${this.objective.id}`
            }
        },
        methods: {
            update() {
                axios.patch(this.endpoint, this.form)
                    .then(() => {
                        flash('Objective have been updated');
                        this.$emit('updated');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            remove() {
                axios.delete(this.endpoint, this.id)
                    .then(() => {
                        flash('Objective have been deleted');
                        this.$emit('deleted');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            }
        },
    }
</script>

<style lang="scss" scoped>
    .pointer {
        cursor: pointer;
    }

    .objective:hover {
        background-color: #e2e8f0;
        input {
            background-color: #e2e8f0;
        }

    }
</style>
