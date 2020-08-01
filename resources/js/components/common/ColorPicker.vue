<template>
    <div>
        <div class="relative p-1">
            <label for="color">Choose a color </label>
            <div class="dropdown-trigger"
                 @click.prevent="isOpen = !isOpen"
                 aria-haspopup="true"
                 :aria-expanded="isOpen"
            >
                <div class="p-1 color">
                    <div class="w-6 h-6" :style="{backgroundColor: chosenColor}">
                    </div>
                </div>
                <input hidden id="color" name="color" v-model="chosenColor"/>
            </div>
            <ul v-show="isOpen" class="dropdown-menu flex">
                <li class="p-1 color" v-for="color in swatches" :key="color">
                    <div class="w-6 h-6" :style="{backgroundColor: color}" @click="setColor(color)">
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['activeColor'],
        data() {
            return {
                isOpen: false,
                chosenColor: (this.activeColor) ? this.activeColor : "#1abc9c",
                swatches: ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#f1c40f", "#f39c12"],
            }
        },
        watch: {
            isOpen(isOpen) {
                if(isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            },
            activeColor(color) {
                this.setColor(color);
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if(! this.$el.contains(event.target)){
                    this.isOpen = false;
                }
            },
            setColor(color) {
                this.chosenColor = color;
                this.$emit('chosen', color);
            }
        }
    }
</script>

<style scoped>
    .dropdown-menu {
        @apply .absolute .rounded .shadow .bg-white;
        z-index: 100;
    }

    .dropdown-trigger {
        display: inline-block;
    }

    label {
        display: block;
    }

    .color {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        display: inline-block;
    }
</style>
