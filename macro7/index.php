<?php

    session_start();
    if (isset($_GET['retry']) && $_GET['retry'] == 'yes') {
        setcookie('result', '', time() - 3600, '/');

        unset($_SESSION['quiz_submitted']);
        
        header("Location: index.php");
        exit();
    }

    if (isset($_COOKIE['result']) && !empty($_COOKIE['result'])) {
        header("Location: processresults.php");
        exit();
    }
?>

<!doctype html>
<html>
<head>
    <title>Macro 7</title>
    <style>
        html, body {
            font-family: Arial;
            background-color: lightyellow;
            font-size: 20px;
        }

        h1 {
            border-bottom: 2px solid lightgrey;
            padding-top: 10px;
            padding-bottom: 25px;
        }

        a {
            display: block;
            border-top: 2px solid lightgrey;
            width: 100%;
            padding-top: 10px;
            box-sizing: border-box;
        }

        #error {
            display: block;
            background-color: red;
            padding: 10px;
            margin-bottom: 10px;
            color: white;
        }

    </style>
</head>
<body>
    <h1>Which Simpson Character Am I?</h1>

    <?php
        if (isset($_GET['error'])) {
            $type = $_GET['error'];
            if ($type === "somemissing") {
                print "<p id='error'>";
                print "Please make sure all four questions are selected";
                print "</p>";
            }
        }

    ?>

    <form action="processresults.php" method="POST">
        What is your ideal job?<br>
        <select name="job">
            <option value="default">Select a job</option>
            <option value="bakery">Working at a bakery</option>
            <option value="french">French tutor</option>
            <option value="phone">Prank phone call specialist</option>
            <option value="professor">College professor</option>
        </select>
        <br>
        <br>
        What is your favorite food?<br>
        <select name="food">
            <option value="default">Select a food</option>
            <option value="donuts">Donuts</option>
            <option value="pie">Apple pie</option>
            <option value="flakes">Krusty Flakes</option>
            <option value="organic">Anything organic or locally sourced</option>
        </select>
        <br>
        <br>
        What is your favorite hobby?<br>
        <select name="hobby">
            <option value="default">Select a hobby</option>
            <option value="tv">Watching TV</option>
            <option value="knit">Knitting</option>
            <option value="skate">Skateboarding</option>
            <option value="read">Reading</option>
        </select>
        <br>
        <br>
        What is your biggest fear?<br>
        <select name="fear">
            <option value="default">Select a fear</option>
            <option value="sock">Sock puppets</option>
            <option value="fly">Flying</option>
            <option value="fearless">I'm fearless, man</option>
            <option value="school">Getting anything below an A in school</option>
        </select>
        <br>
        <br>
        <button>What Simpson Character Am I</button>
    </form>
    <br>
    <br>
    <br>
    <a href="results.php">See Aggregate Results</a>
</body>
</html>
