document.addEventListener('DOMContentLoaded', () => {
    let pokeballs = 5;
    let pokemonsCaught = 0;
    let outcomes = [];
    
    const grassElements = document.querySelectorAll('#grass img');
    const pokeballCountEl = document.getElementById('pokeballCount');
    const pokemonCaughtEl = document.getElementById('pokemonCaught');
    const statusMessageEl = document.getElementById('progress');
    const playAgainBtn = document.getElementById('playAgainBtn');

    const pokemon = [
        { name: 'Pikachu', image: 'images/pikachu.png' },
        { name: 'Bulbasaur', image: 'images/bulbasaur.png' },
        { name: 'Charmander', image: 'images/charmander.png' },
        { name: 'Eevee', image: 'images/eevee.png' },
        { name: 'Squirtle', image: 'images/squirtle.png' }
    ];

    function updateUI() {
        pokeballCountEl.textContent = pokeballs;
        pokemonCaughtEl.textContent = pokemonsCaught;
    }

    function assignOutcomes() {
        outcomes = [
            { type: 'pokemon', value: pokemon[Math.floor(Math.random() * pokemon.length)] },
            { type: 'pokeballs', value: 'images/pokeballs.png' },
            { type: 'nothing' }
        ];
        
        for (let i = outcomes.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [outcomes[i], outcomes[j]] = [outcomes[j], outcomes[i]];
        }
    }

    function clickGrass(event) {
        if (pokeballs <= 0) return;
    
        const clickedIndex = Array.from(grassElements).indexOf(event.target);
        const outcome = outcomes[clickedIndex];
    
        switch (outcome.type) {
            case 'pokemon':
                statusMessageEl.textContent = `You caught a(n) ${outcome.value.name}!`;
                event.target.src = outcome.value.image;
                pokemonsCaught++;
                break;
            case 'pokeballs':
                statusMessageEl.textContent = 'You found two Pokeballs!';
                event.target.src = outcome.value;
                pokeballs += 2;
                break;
            case 'nothing':
                statusMessageEl.textContent = 'Nothing here!';
                event.target.style.visibility = 'hidden';
                break;
        }
    
        pokeballs--; 
        updateUI();
        grassElements.forEach(grass => grass.removeEventListener('click', clickGrass));
        playAgainBtn.style.display = 'block';
    
        grassElements.forEach((grass, index) => {
            if (index !== clickedIndex) {
                grass.classList.add('missed');
                const missedOutcome = outcomes[index];
                switch (missedOutcome.type) {
                    case 'pokemon':
                        grass.src = missedOutcome.value.image;
                        break;
                    case 'pokeballs':
                        grass.src = missedOutcome.value;
                        break;
                }
            }
        });

        const historyItem = document.createElement('li');
        historyItem.textContent = outcome.type === 'pokemon' ? `${outcome.value.name} found` : outcome.type === 'pokeballs' ? 'Pokeballs found' : 'Nothing found';
        document.getElementById('historyList').prepend(historyItem); // Adds the new history item to the top

    }

    function reset() {
        assignOutcomes();
        grassElements.forEach((grass, index) => {
            grass.style.visibility = 'visible';
            grass.src = 'images/grass.png';
            grass.classList.remove('missed');
            grass.addEventListener('click', clickGrass);
        });
        statusMessageEl.textContent = 'Your progress so far ...';
        playAgainBtn.style.display = 'none';
        updateUI();
    }

    playAgainBtn.addEventListener('click', () => {
        if (pokeballs > 0) {
            reset();
        } else {
            statusMessageEl.textContent = 'Game over! You have no more Pokeballs left.';
            playAgainBtn.style.display = 'none';
        }
    });

    reset();

    document.getElementById('clearHistoryBtn').addEventListener('click', () => {
        document.getElementById('historyList').innerHTML = ''; 
    });

    document.getElementById('startOverBtn').addEventListener('click', () => {
        pokeballs = 5;
        pokemonsCaught = 0;
        document.getElementById('historyList').innerHTML = ''; 
        updateUI();
        reset();
    });
    
});
