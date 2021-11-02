<template>
    <div class="game__card" :style="'background-image: url(' + background + ');'" @click="emitClick();">
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
    props: ['card', 'cardBack', 'lockEvent'],
    methods: {
        emitClick() {
            if (this.card.state == 'hide' || this.lockEvent) {
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
        background() {
            console.log(this.card.state)
            if (this.card.state == 'hide') {
                return '';
            }
            if (this.card.state == 'face') {
                return this.card.img;
            }
            return this.cardBack;
        },
        lock() {
            return this.lockEvent;
        }
    },
}
</script>
