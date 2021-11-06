<template>
    <div>
        <div class="container">
            <div class="menu">
                <router-link class="nav--link" :to="{'name': 'game'}">Главная</router-link>
                <router-link class="nav--link pr-3" :to="{'name': 'result'}">Таблица рейтинга</router-link>
            </div>
            <router-view></router-view>
        </div>
    </div>
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
