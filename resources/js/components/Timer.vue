<template>
    <div>
       <time-parser :time="time"></time-parser>
    </div>
</template>

<script>
import TimeParser from './TimeParser';

export default {
    data() {
        return {
            time: 0,
            timer: null
        }
    },
    props: ['active'],
    components: {
        'time-parser': TimeParser
    },
    methods: {
        setTimer() {
            this.timer = setInterval(() => {
                this.time++;
                this.$emit('time', this.time);
            }, 1000)
        },
        stopTimer() {
            clearTimeout(this.timer);
        },
        resetTimer() {
            this.time = 0;
            this.stopTimer();
        },
    },
    watch: {
        active() {
            this.active ? this.setTimer() : this.stopTimer();
        }
    }
}
</script>
