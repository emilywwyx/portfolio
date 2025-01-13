<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);


    $title = $_POST["title"];
    $year = $_POST["year"];

    if (empty($title) || empty($year)) {
        header("Location: add_form.php?error=miss");
        exit();
    }

    $dbpath = "/home/yw6054/databases/movie.db";

    $db = new SQLite3($dbpath);

    $sql = "INSERT INTO movies (title, year) VALUES (:title, :year)";

    $statement = $db->prepare($sql);

    $statement->bindValue(":title", $title);

    $statement->bindValue(":year", $year);

    if ($statement->execute()) {
        header("Location: add_form.php?success=yes");
    } else {
        error_log("SQLite Error: " . $db->lastErrorMsg());
        header("Location: add_form.php?error=sqlerror");
    }
    $db->close();

?>

