<template>
    <div class="dropdown relative">
        <div class="dropdown-trigger"
             @click.prevent="isOpen = !isOpen"
             aria-haspopup="true"
             :aria-expanded="isOpen"
        >
            <slot name="trigger"></slot>
        </div>
        <ul v-show="isOpen" class="dropdown-menu">
            <slot></slot>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isOpen: false
            }
        },
        watch: {
            isOpen(isOpen) {
                if(isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if(! this.$el.contains(event.target)){
                    this.isOpen = false;
                }
            },
        }
    }
</script>

<style scoped>
    .dropdown-item {
        @apply .pl-2 .pr-8 .leading-loose .text-xs .block;
    }

    .dropdown-menu {
        @apply .absolute .bg-gray-300 .rounded .shadow .mt-2;
        z-index: 100;
    }
</style>
