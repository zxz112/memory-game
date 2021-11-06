<template>
    <div class="game">
        <div class="game__header">
            <h1 class="game__title">Игра "Память"</h1>
        </div>
        <div class="game__info">
            <div class="game__attempt">Количество попыток: {{attempt}}</div>
            <timer :active="gameOn" @time="setResultTime"></timer>
        </div>
        <div class="game__cards">
            <card
                v-for="(card, num) in cardsAll"
                :key="'card_'+ num"
                :card="cards[num]"
                :lockEvent="lockEvent"
                @selectCard="cardSelected"
            ></card>
        </div>
        <div v-if="showResult">
            <result @hideResult="showResult = false"></result>
        </div>
    </div>
</template>

<script>
import Card from './Card';
import Timer from './Timer';
import Result from './Result';

import {createCards} from '../helper';

export default {
    data() {
        return {
            cards: [],
            selectedCard: null,
            lockEvent: false,
            countCards: 18,
            animationDuration: 1000,
            timeForSelect: 5000,
            timer: null,
            gameStarted: false,
            attempt: 0,
            resultTime: 0,
            loading: false,
            showResult: false
        }
    },
    components: {
      'card': Card,
      'timer': Timer,
      'result': Result,
    },
    mounted() {
        this.getCards();
    },
    methods: {
        getCards: async function() {
            this.loading = true;
            try {
                await fetch(`/api/cards?limit=${this.countCards}`)
                    .then(response => response.json())
                    .then(json => {
                        this.cards = createCards(json);
                    });
                this.loading = false;
            } catch (e) {
                this.errors = true;
            }
        },
        cardSelected(card) {
            if (!this.gameStarted)
                this.gameStarted = true;
            this.lockEvent = true;
            this.resetTimer();
            this.setStateCard(card, 'face');
            if (this.selectedCard && this.selectedCard.id === card.id) {
                clearTimeout(this.timer);
                this.resetSelectedCard();
                this.attempt++;
            } else if (this.selectedCard && this.selectedCard.id !== card.id) {
                this.attempt++;
                setTimeout(() => {
                    this.setStateCard(card, 'back');
                    this.setStateCard(this.selectedCard, 'back');
                    this.resetSelectedCard();
                    this.lockEvent = false;
                }, this.animationDuration)
                return;
            } else {
                this.timerForSelectedCard();
                this.selectedCard = card;
            }
            this.lockEvent = false;
        },
        timerForSelectedCard() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.setStateCard(this.selectedCard, 'back');
                this.resetSelectedCard();
                this.attempt++;
             }, this.timeForSelect);
        },
        resetTimer() {
            clearTimeout(this.timer);
        },
        setStateCard(card, state, key = 'num') {
            let index = this.cards.findIndex(s => s[key] === card[key]);
            this.cards[index].state = state;
        },
        resetSelectedCard() {
            this.selectedCard = null;
        },
        setResultTime(time) {
            this.resultTime = time;
        },
        saveResult: async function() {
            try {
                await fetch(`/api/result/store`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        seconds: this.resultTime,
                        attempt: this.attempt
                    })
                })
                    .then(response => response.json())
                    .then(json => {
                        this.$store.commit('setResultGame', {
                            id: json,
                            time: this.resultTime,
                            attempt: this.attempt
                        });
                    });
                setTimeout(() => {
                    this.showResult = true;
                }, 1000);
            } catch (e) {
                this.errors = true;
            }
        }

    },
    computed: {
        cardsAll() {
            return this.cards;
        },
        gameIsOver() {
            let isOver = true;
            if (this.loading) {
                return false;
            }
            this.cardsAll.forEach(card => {
                if (card.state !== 'face') {
                    isOver = false;
                }
            })
            return isOver;
        },
        gameOn() {
            return this.gameStarted && !this.gameIsOver;
        }
    },
    watch: {
        gameIsOver(val) {
            if (val === true) {
                this.saveResult();
            }
        }
    }
}
</script>
