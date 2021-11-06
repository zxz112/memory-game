<template>
    <div>
        <div class="game">
            <div class="game__header">
                <h1 class="game__title">Таблица рейтинга</h1>
            </div>
        </div>
        <div class="rating-list">
            <div class="rating-list__item rating-item">
                <div class="rating-item__place">Место</div>
                <div class="rating-item__name">Имя</div>
                <div class="rating-item__time">Время</div>
                <div class="rating-item__attempt">Попытки</div>
            </div>
            <div class="rating-list__item rating-item" :class="[result.id === rating.id ? 'active' : '']" v-for="(rating, num) in playersRating" :key="`rating_${rating.id}`">
                <div class="rating-item__place">{{ num + 1 }}.</div>
                <div class="rating-item__name">Игрок {{ rating.id }}</div>
                <div class="rating-item__time"><time-parser :time="rating.seconds"></time-parser></div>
                <div class="rating-item__attempt">{{rating.attempt}}</div>
            </div>
        </div>
    </div>
</template>

<script>
import TimeParser from '../TimeParser';
import { mapState } from 'vuex';

export default {
    data() {
        return {
            playersRating: []
        }
    },
    components: {
        'time-parser': TimeParser,
    },
    computed: {
        ...mapState({
            result: "result"
        }),
    },
    methods: {
        getPlayersRating: async function() {
            this.loading = true;
            try {
                await fetch(`/api/result`)
                    .then(response => response.json())
                    .then(json => {
                        this.playersRating = json;
                    });
                this.loading = false;
            } catch (e) {
                this.errors = true;
            }
        },
    },
    mounted() {
        this.getPlayersRating();
    }

}
</script>
