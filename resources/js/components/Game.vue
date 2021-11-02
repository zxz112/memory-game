<template>
    <div class="game">
        <div class="game__header">
            <h1 class="game__title">Игра "Память"</h1>
            <button class="game__btn">Старт</button>
        </div>
        <div class="game__cards">
            <card
                v-for="(card, num) in cardsAll"
                :key="'card_'+ num"
                :card="cards[num]"
                :cardBack="cardBack"
                :lockEvent="lockEvent"
                @selectCard="cardSelected"
            ></card>
        </div>
    </div>
</template>

<script>
import Card from './Card';
import {createCards} from '../helper';

export default {
    data() {
        return {
            cardBack: null,
            cards: [],
            selectedCard: null,
            lockEvent: false,
        }
    },
    components: {
      'card': Card
    },
    mounted() {
        this.getCards();
    },
    methods: {
        getCards: function() {
            fetch('/api/cards?limit=9')
                .then(response => response.json())
                .then(json => {
                    this.cards = createCards(json);
                    this.cardBack = 'https://i.pinimg.com/originals/c1/59/b4/c159b4738dae9c9d8d6417228024de8d.jpg';
                });
        },
        cardSelected(card) {
            this.lockEvent = true;
            if (this.selectedCard && card.num == this.selectedCard.num) {
                this.setStateCard(card, 'back');
                this.resetSelectedCard();
            } else if (this.selectedCard && this.selectedCard.id == card.id) {
                this.setStateCard(card, 'face');
                setTimeout(() => {
                    this.setStateCard(card, 'hide',);
                    this.setStateCard(this.selectedCard, 'hide');
                    this.resetSelectedCard();
                    this.lockEvent = false;
                }, 700);
                return;
            } else if (this.selectedCard && this.selectedCard.id != card.id) {
                this.setStateCard(card, 'face');
                setTimeout(() => {
                    this.setStateCard(card, 'back');
                    this.setStateCard(this.selectedCard, 'back');
                    this.resetSelectedCard();
                    this.lockEvent = false;
                }, 700)
                return;
            } else {
                this.setStateCard(card, 'face');
                this.selectedCard = card;
            }
            this.lockEvent = false;
        },
        setStateCard(card, state, key = 'num') {
            let index = this.cards.findIndex(s => s[key] == card[key]);
            this.cards[index].state = state;
        },
        resetSelectedCard() {
            this.selectedCard = null;
        },
    },
    computed: {
        cardsAll() {
            return this.cards;
        }
    }
}
</script>
