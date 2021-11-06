function shuffle(array) {
    let currentIndex = array.length,  randomIndex;

    // While there remain elements to shuffle...
    while (currentIndex != 0) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
    }

    return array;
}

function createCards(cards) {
    let result = [];
    let currentIndex = cards.length * 2;
    while (currentIndex != 0) {
        currentIndex--;
        result.push(Object.assign({'num': currentIndex, 'state': 'back'}, cards[Math.floor(currentIndex / 2)]))
    }
    return shuffle(result);
}

export {createCards}
