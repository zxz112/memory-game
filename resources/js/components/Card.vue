<template>
    <div :class="'card__' + this.state  + ' card'">
        <div class="card__side card__back" @click="emitClick();"></div>
        <div class="card__side card__front" :style="`background-image:url(${this.card.img})`"></div>
    </div>
</template>

<script>
export default {
    data() {
      return {
          selected: false,
          faceSide: false
      }
    },
    mounted() {
    },
    props: ['card', 'lockEvent'],
    methods: {
        emitClick() {
            if (this.card.state === 'face' || this.lockEvent) {
                return;
            }
            this.$emit('selectCard', this.card);
        },
        reset() {
            this.faceSide = false;
            this.selected = false;
        }
    },
    computed: {
        state() {
            return this.card.state;
        },
        lock() {
            return this.lockEvent;
        }
    },
}
</script>
