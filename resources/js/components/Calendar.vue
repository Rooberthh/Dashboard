<template>
    <section>
        <h1 class="text-3xl font-bold">Calendar</h1>
        <ul class="flex">
            <li class="mr-6 flex items-center" v-for="calendar in this.calendars">
                <div class="w-4 h-4 rounded mr-2" :style="{backgroundColor: calendar.color}"></div>
                <label class="flex items-center" :for="calendar.name">
                    <span class="mr-2">{{ calendar.name }}</span>
                    <input type="checkbox" :id="calendar.name" :value="calendar.id" @change="setCalendar($event)" checked>
                </label>
            </li>
        </ul>
        <div class="flex">
            <div class="w-full">
                <FullCalendar
                    :options="calendarOptions"
                    ref="Calendar"
                />
            </div>
        </div>
    </section>
</template>

<script>
    import FullCalendar from '@fullcalendar/vue';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin, { Draggable } from '@fullcalendar/interaction';

    export default {
        props: ['calendars'],
        components: {
            FullCalendar // make the <FullCalendar> tag available
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [timeGridPlugin , interactionPlugin ],
                    initialView: 'timeGridWeek',
                    weekends: true,
                    eventSources: [],
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }
                },
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                for (let i = 0; i < this.calendars.length; i++)
                {
                    let calendar = this.calendars[i];
                    let temp = {
                        "url": this.getBaseUrl() + `/calendars/${calendar.id}/events`,
                        "backgroundColor": calendar.color,
                        "id": calendar.id,
                    };

                    this.calendarOptions.eventSources.push(temp);
                }
            },
            setCalendar(event) {
                let checkbox = event.target;
                let api = this.$refs.Calendar.getApi();
                let src = api.getEventSourceById(checkbox.value);

                if(src != null) {
                    if(!checkbox.checked){
                        src.remove();
                    }
                } else {
                    let calendar = this.calendars.find(x => x.id === parseInt(checkbox.value));
                    let newSrc = {
                        "url": this.getBaseUrl() + `/calendars/${calendar.id}/events`,
                        "backgroundColor": calendar.color,
                        "id": calendar.id,
                    };
                    api.addEventSource(newSrc);
                }
            }
        }
    }
</script>

<style lang='scss'>
    .draggable-item {
        display: block;
        cursor: pointer;
    }

    .event-item {
        display: inline-block;
    }
</style>
