<template>
    <div class="timer">
        <span class="hours">{{ formatTime(hours) }}</span>
        <span class="delimeter">:</span>
        <span class="minutes">{{ formatTime(minutes)}}</span>
        <span class="delimeter">:</span>
        <span class="seconds">{{ formatTime(seconds) }}</span>
    </div>
</template>

<script>
export default {
    props: ['time'],
    methods: {
        formatTime(time) {
            if (!time) {
                return '00';
            }
            if (time < 10) {
                return `0${time}`;
            }
            return time;
        }
    },
    computed: {
        seconds() {
            return Math.trunc(this.time % 60);
        },
        minutes() {
            return Math.trunc(this.time / 60 % 60);
        },
        hours() {
            return Math.trunc(this.time / 60 / 60 % 60);
        },
    }
}
</script>
