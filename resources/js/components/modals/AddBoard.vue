<template>
    <modal name="add-board"
           height="auto"
    >
        <form class="p-5">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="input" id="name" name="name" type="text" placeholder="Name" v-model="form.name">
                <span class="text-red-500" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
            </div>
            <div class="flex items-center justify-between">
                <button class="btn btn-primary" type="button" @click="addBoard">
                    Add
                </button>
            </div>
        </form>
    </modal>
</template>

<script>
    import Form from '../Form/Form';
    export default {
        data() {
            return {
                form: new Form({'name': ''})
            }
        },
        methods: {
            addBoard() {
                this.form.post(this.getBaseUrl() + `/boards`)
                    .then(response => {
                        this.$emit('created', response);
                        this.form.reset();
                        this.$modal.hide('add-board');
                    });
            }
        }
    }
</script>
