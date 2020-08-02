<template>
    <ul class="flex flex-wrap -mx-3 my-6">
        <board v-for="(board, index) in items" :board="board" :key="board.id" @deleted="remove(index)"></board>
    </ul>
</template>

<script>
    import board from './Board'
            import collection from './mixins/Collection'
            export default {
                props: ['boards'],
                components: {board},
                mixins: [collection],
                data() {
                    return {
                        loading: false,
                    }
                },
                created() {
                    this.items = this.boards
                },
                methods: {
                }
    }
</script>

<style scoped>

</style>
