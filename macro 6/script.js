// keep track of the time
let time = 0;
let timeInterval = null;

// click start button to start the game
document.getElementById("startBtn").onclick = function() {
    let difficulty = document.getElementById("difficulty").value;
    startGame(difficulty);
}

// start game based on difficulty selected
function startGame(difficulty) {
    let rows;
    let cols;
    if (difficulty === "easy") {
        rows = 3;
        cols = 4;
    } else if (difficulty === "medium") {
        rows = 4;
        cols = 5;
    } else if (difficulty === "hard") {
        rows = 5;
        cols = 6;
    }

    let totalPairs = (rows * cols) / 2;

    let bestTimeKey = `best-time-${difficulty}`;
    let bestTimeNameKey = `best-time-name-${difficulty}`;
    let localBestTime = localStorage.getItem(bestTimeKey);
    let localBestTimeName = localStorage.getItem(bestTimeNameKey);

    if (localBestTime !== null) {
        bestTime = parseInt(localBestTime);
        bestTimeName = localBestTimeName;
        document.getElementById("best-time").textContent = `${bestTime} - ${bestTimeName}`;
    } else {
        bestTime = 100000;
        document.getElementById("best-time").textContent = "";
    }

    document.querySelector(".start-title").classList.add("hidden");
    document.getElementById("start-screen").classList.add("hidden");
    document.querySelector(".play-title").classList.remove("hidden");
    document.getElementById("play-screen").classList.remove("hidden");
    document.querySelector(".container").classList.remove("hidden");
    createTokens(rows, cols, totalPairs);

    // timer
    startTimer();
}

let assets = ['snorlax.png', 'electrabuzz.png', 'chansey.png', 'oddish.png',
              'pikachu.png', 'paras.png', 'arcanine.png', 'ponita.png',
              'venonat.png', 'eggsecute.png', 'machop.png', 'pidgey.png',
              'psyduck.png', 'tauros.png', 'vulpix.png', 'gloom.png',
              'krabby.png', 'butterfree.png', 'bulbasaur.png', 'clefairy.png',
              'koffing.png', 'goldeen.png', 'magikarp.png', 'beedrill.png',
              'lapras.png', 'meowth.png', 'ekans.png', 'jigglypuff.png',
              'horsea.png', 'polywog.png', 'sandshrew.png', 'rattata.png',
              'gengar.png', 'eevee.png', 'bellsprout.png', 'squirtle.png',
              'seel.png', 'caterpie.png'];

// create game tokens
function createTokens(rows, cols, totalPairs) {

    const containerWidth = document.querySelector(".container").clientWidth;
    const containerHeight = window.innerHeight * 0.8;

    let tokenSizeWidth = Math.floor(containerWidth / cols) - 2;
    let tokenSizeHeight = Math.floor(containerHeight / rows) - 2;

    let tokenSize = Math.min(tokenSizeWidth, tokenSizeHeight);

    // Determine token size based on board size
    if (rows === 3 && cols === 4) {
        tokenSize = 120;
    } else if (rows === 4 && cols === 5) {
        tokenSize = 110;
    } else if (rows === 5 && cols === 6) {
        tokenSize = 100;
    }

    let totalImages = rows * cols;

    // create empy array to store selected images
    let selectedImages = [];

    // keep pushing random image to the selected image array until the number reaches required
    while (selectedImages.length < totalImages / 2) {
        let rand = parseInt(Math.random() * assets.length);
        let randImg = assets[rand];
        if (!selectedImages.includes(randImg)) {
            selectedImages.push(randImg);
        }
    }

    // double the images
    let tokens = selectedImages.concat(selectedImages);

    // create a function to shuffle array
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            let j = parseInt(Math.random() * (i + 1));
            let temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
    }

    // shuffle the array
    shuffleArray(tokens);

    // Adjust container grid layout dynamically
    let container = document.querySelector(".container");
    container.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
    container.innerHTML = '';

    tokens.forEach(tokenImage => {
        let tokenElement = document.createElement("img");
        tokenElement.setAttribute("src", "images/pokeball.png");
        tokenElement.setAttribute("data-secret-image", "images/" + tokenImage);
        tokenElement.classList.add("token");
        tokenElement.style.width = `${tokenSize}px`;
        tokenElement.style.height = `${tokenSize}px`;
        container.appendChild(tokenElement);
    });

    findMatch(totalPairs);
}

// find match
let token1 = false;
let token2 = false;
let count = 0;
let bestTime;
let bestTimeName;

// get best time from local storage
let localBestTime = localStorage.getItem("best-time");
let localBestTimeName = localStorage.getItem("best-time-name");

// check if local best time already existed
if (localBestTime !== null) {
    bestTime = parseInt(localBestTime);
    bestTimeName = localBestTimeName;
    document.getElementById("best-time").textContent = `${bestTime} - ${bestTimeName}`;
} else {
    // set a high best time for future comparison
    bestTime = 10000;

    // but display nothing
    document.getElementById("best-time").textContent = "";
}

// function to find matched pairs
function findMatch(totalPairs) {
    document.querySelectorAll(".token").forEach(token => {
        token.onclick = function(event) {
            let clicked = event.target;
    
            if (clicked.classList.contains("matched") || token1 === clicked || token2 === clicked || token1 && token2) {
                return;
            }

            clicked.setAttribute("src", clicked.getAttribute("data-secret-image"));

            if (!token1) {
                token1 = clicked;
            } else {
                token2 = clicked;

                if (token1.getAttribute("data-secret-image") === token2.getAttribute("data-secret-image")) {
                    // Matched pairs found
                    token1.classList.add("matched");
                    token2.classList.add("matched");
                    count++;

                    playCorrectMatchSound();

                    token1 = null;
                    token2 = null;

                    // if all pairs are matched
                    if (count === totalPairs) {
                        setTimeout(gameOver, 300);
                    }
                } else {
                    // Not matched
                    setTimeout(() => {
                        goBackNormal();
                        playIncorrectMatchSound();
                    }, 300);
                }
            }
        };
    });
}

// if no match found, go back to pokeball image
function goBackNormal() {
    if (token1 != false) {
        token1.setAttribute("src", "images/pokeball.png");
    }
    if (token2 != false) {
        token2.setAttribute("src", "images/pokeball.png");
    }

    // set token1 and token2 back to default false status
    token1 = false;
    token2 = false;
}

// start a timer
function startTimer() {
    time = 0;
    document.getElementById("time").textContent = time;
    if (timeInterval) {
        clearInterval(timeInterval);
    }
    timeInterval = setInterval(function() {
        time++;
        document.getElementById("time").textContent = time;
    }, 1000)
}

// stop the timer
function stopTimer() {
    clearInterval(timeInterval);
    timeInterval = null;
}

// show the game over screen
function gameOver() {
    stopTimer();
    document.querySelector(".play-title").classList.add("hidden");
    document.getElementById("play-screen").classList.add("hidden");
    document.querySelector(".container").classList.add("hidden");
    document.querySelector(".game-over-title").classList.remove("hidden");
    document.getElementById("game-over-screen").classList.remove("hidden");

    // update final time
    document.getElementById("final-time").textContent = time;

    let newBestTime = false;
    let bestTimeKey = `best-time-${difficulty}`;
    let bestTimeNameKey = `best-time-name-${difficulty}`;

    // Check if the current time is a new best time for the current difficulty
    if (time < bestTime) {
        bestTime = time;
        bestTimeName = prompt("Great job! You achieved a new high score for this difficulty level! Enter your name:");
        localStorage.setItem(bestTimeKey, bestTime.toString());
        localStorage.setItem(bestTimeNameKey, bestTimeName);
        newBestTime = true;
    }

    if (newBestTime === true) {
        document.getElementById("best-time").textContent = `${bestTime} - ${bestTimeName} - New High Score!`;
    } else {
        // Make sure to update this part to fetch the correct best time and name for the current difficulty
        document.getElementById("best-time").textContent = `${bestTime} - ${bestTimeName}`;
    }
}

// click "play again" button to go back to the play screen
document.getElementById("playAgainBtn").onclick = function() {
    let difficulty = document.getElementById("difficulty").value;
    let rows, cols;
    if (difficulty === "easy") {
        rows = 3;
        cols = 4;
    } else if (difficulty === "medium") {
        rows = 4;
        cols = 5;
    } else if (difficulty === "hard") {
        rows = 5;
        cols = 6;
    }
    document.querySelector(".play-title").classList.remove("hidden");
    document.getElementById("play-screen").classList.remove("hidden");
    document.querySelector(".container").classList.remove("hidden");
    document.querySelector(".game-over-title").classList.add("hidden");
    document.getElementById("game-over-screen").classList.add("hidden");

    count = 0;
    reset(rows, cols);
    startTimer();
}

// reset the game tokens
function reset(rows, cols) {
    let totalPairs = (rows * cols) / 2;
    let container = document.querySelector(".container");
    container.innerHTML = '';
    createTokens(rows, cols, totalPairs);
}

function playCorrectMatchSound() {
    var audio = new Audio('sounds/correct.mp3');
    audio.play();
}

function playIncorrectMatchSound() {
    var audio = new Audio('sounds/incorrect.mp3');
    audio.volume = 0.3;
    audio.play();
}