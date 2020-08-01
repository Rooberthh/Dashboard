<template>
    <div>
        <h1 class="text-3xl font-bold" v-text="board.name"></h1>
        <button class="btn btn-primary" type="button" @click="openModal">Add new status</button>
        <draggable v-model="items" @start="drag=true" @end="drag=false" group="statuses" class="flex my-3 -px-2" @change="changeStatus($event)">
            <statusBoard
                v-for="(status, index) in this.items" :key="status.id"
                :status="status"
                @deleted="remove(index)"
            >
            </statusBoard>
        </draggable>
        <taskDetails @refetch="fetch()"></taskDetails>
        <addStatus :board="this.board" @created="add"></addStatus>
    </div>
</template>

<script>
    import axios from 'axios';
    import statusBoard from '../components/StatusBoard';
    import taskDetails from '../components/modals/TaskDetails';
    import addStatus from '../components/modals/AddStatus';
    import collection from '../components/mixins/Collection';
    import draggable from 'vuedraggable'

    export default {
        components: {statusBoard, taskDetails, addStatus, draggable},
        mixins: [collection],
        data() {
            return {
                board: {},
            }
        },
        created() {
            window.events.$on('show-taskDetails', task => {
                this.$modal.show('task-details', task);
            });

            this.fetch();
        },
        methods: {
            fetch() {
                axios.get(this.getGatewayUrl() + "boards/" + this.$route.params.id)
                    .then(response => {
                        this.board = response.data;

                        this.items = response.data.statuses;
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            changeStatus(event) {
                if(event.moved) {
                    let status = event.moved && event.moved.element;

                    this.items.map((status, index) => {
                        status.order = index + 1;
                    });

                    if(status) {
                        let url = this.getGatewayUrl() + `boards/${this.board.id}/statuses`;
                        axios.patch(url, {statuses: this.items})
                            .then(() => {
                                flash('Statuses updated');
                            })
                            .catch(error => {
                                flash(error.message);
                            });
                    }

                }
            },
            updateStatus(status) {
                let url = this.getGatewayUrl() + `boards/${this.board.id}/statuses/${status.id}`;
                axios.patch(url, status)
                    .then(() => {
                        flash('Status updated');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            openModal () {
                this.$modal.show('add-status')
            }
        }
    }
</script>

<style scoped>
</style>
