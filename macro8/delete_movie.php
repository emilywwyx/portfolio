<?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $dbpath = "/home/yw6054/databases/movie.db";
        $db = new SQLite3($dbpath);

        $stmt = $db->prepare('DELETE FROM movies WHERE id = :id');
        $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);

        if ($stmt->execute()) {
            header('Location: index.php?msg=success');
        } else {
            header('Location: index.php?msg=error');
        }
    } else {
        header('Location: index.php?msg=invalidID');
    }
?>
