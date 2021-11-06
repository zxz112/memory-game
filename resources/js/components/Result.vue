<template>
    <div class="popup">
        <div class="result">
            <div class="result__title">Поздравляем, Игрок {{result.id}}</div>
            <div class="result__body">Ваш результат:</div>
            <div class="result__info">
                <div class="result__row">
                    <div class="result__info-title">Количество попыток:&nbsp;</div>
                    <div class="result__info-info"> {{result.attempt}}</div>
                </div>
                <div class="result__row">
                    <div class="result__info-title">Время : </div>
                    <div class="result__info-info"> <time-parser :time="result.time"></time-parser></div>
                </div>
            </div>
            <div class="result__close" @click="$emit('hideResult', true)">
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import TimeParser from './TimeParser';

export default {
    components: {
        'time-parser': TimeParser
    },
    computed: {
        ...mapState({
            result: "result"
        }),
    }
}
</script>
