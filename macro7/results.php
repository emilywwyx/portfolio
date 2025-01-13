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
            width: 100%;
            padding-top: 40px;
            box-sizing: border-box;
            margin: 0 auto;
            text-align: center;
        }

        .bar {
            border: 1px solid black;
            padding: 15px;
        }

        #bar1 {
            background-color: lightblue;
        }

        #bar2 {
            background-color: yellow;
        }

        #bar3 {
            background-color: lightgreen;
        }

        #bar4 {
            background-color: lightpink;
        }

    </style>
</head>
<body>
    <h1>Simpsons Quiz Results</h1>

    <?php

    $total = $homer = $marge = $lisa = $bart = 0;
    $filename = '/home/yw6054/data/results.txt';
    $alldata = trim(file_get_contents($filename));

    $allnames = explode("\n", $alldata);

    for ($i = 0; $i < sizeof($allnames); $i++) {
        if ($allnames[$i] === 'Homer') {
            $homer++;
        } else if ($allnames[$i] === 'Marge') {
            $marge++;
        } else if ($allnames[$i] === 'Lisa') {
            $lisa++;
        } else if ($allnames[$i] === 'Bart') {
            $bart++;
        }
        $total++;
    }

    $homerPercentage = round(($homer / $total) * 100);
    $margePercentage = round(($marge / $total) * 100);
    $lisaPercentage = round(($lisa / $total) * 100);
    $bartPercentage = round(($bart / $total) * 100);
    ?>

    <p>In total there have been <?php echo $total; ?> quiz submissions.</p>

    <div class="bar" id="bar1" style="width: <?php echo $homerPercentage; ?>%;">Homer <span><?php echo $homerPercentage; ?></span>%</div>
    <div class="bar" id="bar2" style="width: <?php echo $margePercentage; ?>%;">Marge <span><?php echo $margePercentage; ?></span>%</div>
    <div class="bar" id="bar3" style="width: <?php echo $bartPercentage; ?>%;">Bart <span><?php echo $bartPercentage; ?></span>%</div>
    <div class="bar" id="bar4" style="width: <?php echo $lisaPercentage; ?>%;">Lisa <span><?php echo $lisaPercentage; ?></span>%</div>

    <a href="index.php">Back to Quiz</a>


</body>
</html>
