document.addEventListener('DOMContentLoaded', function() {
    const userNumber = getNum();
    heading();
    displayTimeGreeting();
    setBackground();
    displayLuckyNums(userNumber);
    randomizeFigure();
});

function getNum() {
    let num;
    do {
        num = prompt("Please enter a positive number greater than or equal to 3:");
        num = parseInt(num);
    } while (isNaN(num) || num < 3);
    return num;
}

function heading() {
    const endings = ['Awesome', 'Fantastic', 'Fabulous', 'Superb', 'Perfect', 'Brilliant', 'Coming up Roses'];
    const ending = endings[Math.floor(Math.random() * endings.length)];
    document.querySelector('#info h1').textContent = `Everything is ${ending}`;
}

function displayTimeGreeting() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const ampm = hours >= 12 ? 'pm' : 'am';
    const formattedHours = ((hours + 11) % 12 + 1);
    const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
    const greeting = getGreeting(hours);
    document.querySelector('#time').textContent = `The current time is ${formattedHours}:${formattedMinutes} ${ampm}. ${greeting}`;
}

function getGreeting(hours) {
    if (hours < 6) return "Good Night!";
    else if (hours < 12) return "Good Morning!";
    else if (hours < 18) return "Good Afternoon!";
    else return "Good Evening!";
}

function setBackground() {
    const now = new Date();
    const hours = now.getHours();
    let background = "backgrounds/afternoon.png";
    if (hours < 6) background = "backgrounds/night.png";
    else if (hours < 12) background = "backgrounds/morning.png";
    else if (hours >= 18) background = "backgrounds/evening.png";
    document.getElementById('holder').style.backgroundImage = `url('${background}')`;
}

function displayLuckyNums(userNumber) {
    const luckyNumbers = [];
    while (luckyNumbers.length < 3) {
        const num = Math.floor(Math.random() * userNumber) + 1;
        if (!luckyNumbers.includes(num)) luckyNumbers.push(num);
    }
    const luckyNumbersText = `Your three lucky numbers today are ${luckyNumbers.join(', ')}.`;
    const timeElement = document.querySelector('#time');
    timeElement.innerHTML += `<br><div style="margin-top: 15px;">${luckyNumbersText}</div>`;
}

function randomizeFigure() {
    const heads = ['heads/head1.png', 'heads/head2.png', 'heads/head3.png', 'heads/head4.png', 'heads/head5.png', 'heads/head6.png'];
    const bodies = ['bodies/body1.png', 'bodies/body2.png', 'bodies/body3.png', 'bodies/body4.png', 'bodies/body5.png', 'bodies/body6.png'];
    const headIndex = Math.floor(Math.random() * heads.length);
    const bodyIndex = Math.floor(Math.random() * bodies.length);
    document.querySelector('#figure img:nth-child(1)').src = heads[headIndex];
    document.querySelector('#figure img:nth-child(2)').src = bodies[bodyIndex];
}