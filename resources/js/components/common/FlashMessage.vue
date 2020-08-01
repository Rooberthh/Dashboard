<template>
    <div class="flash-message" :class="'flash-'+level" role="alert" v-show="show">
        <div class="p-3 flex">
            <div>
                {{ body }}
            </div>
            <div class="pl-3">
                <button @click="hide()" type="button" aria-label="Close flash-message">
                    <font-awesome-icon :icon="['fas', 'times']" />
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props:['message'],

        data()
        {
            return {
                body: this.message,
                level: 'default',
                show: false
            }
        },
        created()
        {
            if(this.message)
            {
                this.flash();
            }

            window.events.$on('flash', message => {
                this.flash(message);
            });
        },
        methods: {
            flash(data) {
                if(data){
                    this.body = data.message;
                    this.level = data.level;
                }

                this.show = true;

                setTimeout(() => {
                    this.hide();
                }, 3000);
            },

            hide() {
                this.show = false;
            }
        }
    };
</script>

<style type="text/css">
    .flash-message {
        position: fixed !important;
        bottom: 25px;
        right: 25px;

        font-weight: bold;
    }

    i {
        cursor: pointer;
    }
</style>

