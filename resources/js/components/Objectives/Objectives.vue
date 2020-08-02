<template>
    <div>
        <div v-for="(objective, index) in items">
            <objective :objective="objective" @updated="emitRefetch()" @deleted="remove(index); emitRefetch()" :key="objective.id"></objective>
        </div>

        <div>
            <new-objective :endpoint="endpoint" @created="add($event); emitRefetch()"></new-objective>
        </div>
    </div>
</template>

<script>
    import NewObjective from "./NewObjective";
    import Objective from "./Objective";
    import collection from '../mixins/Collection';
    import axios from 'axios';

    export default {
        name: "Objectives",
        props: ['taskId'],
        components: {
            NewObjective,
            Objective
        },
        mixins: [collection],
        data() {
            return {
                dataSet: false,
                endpoint: this.getBaseUrl()+ '/tasks/' + this.taskId + '/objectives'
            }
        },
        created(){
            this.fetch();
        },
        methods: {
            fetch(){
                axios.get(this.endpoint)
                    .then(this.refresh)
            },
            refresh({data}){
                this.dataSet = data;
                this.items = data;
            },
            emitRefetch() {
                this.$emit('refetch');
            }
        }
    }
</script>

<style scoped>

</style>
