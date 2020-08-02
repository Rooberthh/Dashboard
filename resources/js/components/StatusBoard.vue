<template>
    <div class="status-board draggable" :style="{borderColor: item.color}">
        <div v-if="!editing">
            <div class="flex">
                <h3 class="text-lg font-bold mr-auto" v-text="item.name"></h3>
                <dropdown>
                    <template v-slot:trigger>
                        <button class="font-bold text-2xl">...</button>
                    </template>
                    <li><a @click="editing = !editing" class="dropdown-item hover:bg-gray-200">Edit</a></li>
                    <li><a @click="destroy" class="dropdown-item hover:bg-gray-200">Delete</a></li>
                </dropdown>
            </div>

            <draggable class="pb-16" v-model="tasks"  @start="drag=true" @end="drag=false" group="tasks" @change="changedTask($event, item.id)" v-if="!editing">
                <div v-for="task in tasks" :key="task.id">
                    <task :task="task"></task>
                </div>
            </draggable>
            <div class="flex">
                <div class="flex w-full justify-between" v-if="!adding">
                    <div class="flex">
                        <button
                                type="button"
                                class="w-full text-left hover:bg-gray-400 p-1 rounded"
                                @click="adding = !adding"
                        >
                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                            Add Task
                        </button>
                    </div>
                    <dropdown>
                        <template v-slot:trigger>
                            <button class="font-bold text-2xl">...</button>
                        </template>
                        <li><a @click="editing = !editing" class="dropdown-item hover:bg-gray-200">Edit</a></li>
                        <li><a @click="destroy" class="dropdown-item hover:bg-gray-200">Delete</a></li>
                    </dropdown>
                </div>
                <div class="flex-grow" v-else>
                    <textarea class="input w-full" v-model="newTask.title" id="title" placeholder="Task title"></textarea>
                    <div class="flex justify-between mt-3">
                        <button @click="addTask" type="button" class="btn btn-primary">Add task</button>
                        <button @click="adding = !adding" type="button" class="btn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="input" id="name" name="name" type="text" placeholder="Name" v-model="form.name">
                <span class="text-red-500" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
            </div>
            <div class="mb-4">
                <color-picker :default-color="this.form.color" name="color" @chosen="setColor"></color-picker>
            </div>
            <div class="flex items-center justify-between">
                <button class="btn btn-danger" type="button" @click="editing = !editing">
                    Cancel
                </button>
                <button class="btn btn-primary" type="button" @click="updateStatus()">
                    Update
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    import axios from 'axios';
    import task from './Task';
    import dropdown from './common/Dropdown';
    import colorPicker from './common/ColorPicker';
    import Form from './Form/Form';

    export default {
        name: "StatusBoard",
        components: {draggable, task, dropdown, colorPicker},
        props: ['status'],
        data() {
            return {
                editing: false,
                item: {
                    id: this.status.id,
                    name: this.status.name,
                    color: this.status.color,
                    board_id: this.status.board_id
                },
                tasks: this.status.tasks,
                adding: false,
                form: new Form({'name': this.status.name, 'color': this.status.color, 'board_id': this.status.board_id}),
                newTask : {
                    title: '',
                    status_id: this.status.id
                }
            }
        },
        watch: {
            status: function(status) {
                this.tasks = status.tasks;
            }
        },
        methods: {
            updateStatus() {
                let url = this.getBaseUrl() + `/boards/${this.status.board_id}/statuses/${this.item.id}` ;
                this.form.patch(url)
                    .then(response => {
                        this.item = response;

                        this.editing = ! this.editing;
                    })
                    .catch(error => {
                        flash(error.message);
                    })
            },
            destroy() {
                let url = this.getBaseUrl() + `/boards/${this.status.board_id}/statuses/${this.item.id}` ;
                axios.delete(url)
                    .then(() => {
                        flash('Status have been deleted');
                        this.$emit('deleted');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            changedTask(event, id) {
                if(event.added) {
                    let task = event.added && event.added.element;
                    if(task)
                    {
                        task.status_id = id;
                        this.updateTask(task);
                    }
                }
                if(event.moved) {
                    this.tasks.map((task, index) => {
                        task.order = index + 1;
                    });

                    this.updateAllTasks();
                }
            },
            updateTask(task) {
                let url = this.getBaseUrl() + `/statuses/${this.status.id}/tasks/${task.id}`;
                axios.patch(url, task)
                    .then(() => {
                        flash('Task updated');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            updateAllTasks() {
                let url = this.getBaseUrl() + `/statuses/${this.status.id}/tasks`;
                axios.patch(url, {tasks: this.tasks})
                    .then(() => {
                        flash('Tasks updated');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            addTask(){
                let url = this.getBaseUrl() + `/statuses/${this.status.id}/tasks` ;
                axios.post(url, this.newTask)
                    .then(response => {
                        this.newTask.title = '';

                        this.tasks.push(response.data);
                        this.adding = false;

                        flash('Task added');
                    })
                    .catch(error => {
                        flash(error.message);
                    });
            },
            showDetails() {
                window.events.$emit('show-statusDetails', this.item);
            },
            setColor(color) {
                this.form.color = color;
            }
        }
    }
</script>

<style scoped>
    textarea {
        min-height: 4rem;
        display: block;
    }

    .dropdown-item {
        background: #fff;
    }

    .draggable:hover {
        cursor: pointer;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .status-board {
        @apply flex-1 bg-gray-300 p-3 rounded self-start border-t-8;
    }

    .status-board + .status-board {
        @apply ml-4;
    }
</style>
