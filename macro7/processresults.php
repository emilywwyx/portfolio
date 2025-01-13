<?php

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $job = $_POST["job"] ?? 'default';
        $food = $_POST["food"] ?? 'default';
        $hobby = $_POST["hobby"] ?? 'default';
        $fear = $_POST["fear"] ?? 'default';
        $bart = 0;
        $homer = 0;
        $lisa = 0;
        $marge = 0;

        if ($job === 'default' || $food === 'default' || $hobby === 'default' || $fear === 'default') {
            header("Location: index.php?error=somemissing");
            exit();
        }

        $marge += ($job === 'bakery') + ($food === 'pie') + ($hobby === 'knit') + ($fear === 'fly');
        $lisa += ($job === 'french') + ($food === 'organic') + ($hobby === 'read') + ($fear === 'school');
        $bart += ($job === 'phone') + ($food === 'flakes') + ($hobby === 'skate') + ($fear === 'fearless');
        $homer += ($job === 'professor') + ($food === 'donuts') + ($hobby === 'tv') + ($fear === 'sock');

        $scores = array($bart, $homer, $lisa, $marge);
        $characters = array('Bart', 'Homer', 'Lisa', 'Marge');
        $max = max($scores);
        $index = array_search($max, $scores);
        $result = $characters[$index];

        setcookie('result', $result, time() + 86400, '/');
        header("Location: processresults.php");
        exit();
    } else if (!isset($_COOKIE['result'])) {
        header("Location: index.php");
        exit();
    }

    $result = $_COOKIE['result'];
    $imagePath = "assignment07_images/{$result}.png";
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

        #resultimg {
            display: block;
            padding: 40px;
            border: 5px solid black;
            border-radius: 10px;
            margin: 0 auto;
            background-color: white;
        }

        .resulttext {
            display: block;
            text-align: center;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #btn {
            display: block;
            margin: 0 auto;
            text-align: center;
        }

    </style>
</head>
<body>
    <h1>Which Simpson Character Am I?</h1>

    <?php
        if ($result === 'Bart') {
            $imagePath = 'assignment07_images/' . 'Bart.png';
        } else if ($result === 'Homer') {
            $imagePath = 'assignment07_images/' . 'Homer.png';
        } else if ($result === 'Lisa') {
            $imagePath = 'assignment07_images/' . 'Lisa.png';
        } else if ($result === 'Marge') {
            $imagePath = 'assignment07_images/' . 'Marge.png';
        }

        print "<div class=\"resulttext\">You are $result!</div>";
        print "<img id=\"resultimg\" src=\"$imagePath\" alt=\"$result\">";
    ?>

    <div class="btn-container">

        <?php
            print "<button class=\"btn\" onclick=\"window.location.href='index.php?retry=yes'\">Try again?</button>";
            
            if (!isset($_SESSION['quiz_submitted'])) {
                // Set the session flag
                $_SESSION['quiz_submitted'] = true;
                $path = "/home/yw6054/data";
                $filename = $path . "/results.txt";
                file_put_contents($filename, $result . "\n", FILE_APPEND);
            }
        ?>
    </div>

    <br>
    <a href="results.php">See Aggregate Results</a>

</body>
</html>
