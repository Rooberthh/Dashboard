<template>
    <div class="p-2 mb-3 bg-gray-300 rounded">
        <form @submit.prevent="addObjective">
            <input type="text" placeholder="Add a new Objective..." class="w-full leading-loose bg-gray-300" name="body" v-model="body">
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['endpoint'],
        data() {
            return {
                body: '',
                completed: false
            }
        },
        methods: {
            addObjective() {
                axios.post(this.endpoint, {body: this.body})
                    .catch(error => {
                        flash(error.message);
                    })
                    .then(response => {
                        this.body = '';

                        this.$emit('created', response.data)
                    });
            }
        }
    }
</script>

<style scoped>

</style>
