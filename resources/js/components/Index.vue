<template>
    <game v-if="true"></game>
    <rating v-else></rating>
</template>

<script>
import Game from './Game';
import Rating from './Rating';
export default {
    components: {
        'game': Game,
        'rating': Rating,
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
