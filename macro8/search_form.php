<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macro 8</title>
    <style>
        nav a:link {
            padding: 10px;
            border-radius: 0px;
            border: 1px solid black;
            text-decoration: none;
        }
        nav {
            margin-bottom: 20px;
        }
        .active {
            border: 1px solid black;
            background-color: #DDD;
        }
        .hidden {
            display: none;
        }
        .msg {
            display: block;
            background-color: lightblue;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>My Movie Database</h1>
    <nav>
        <a href="index.php" class="tab" data-mycontentpanel="#view">View All</a>
        <a href="add_form.php" class="tab" data-mycontentpanel="#add">Add Movie</a>
        <a href="search_form.php" class="tab active" data-mycontentpanel="#search">Search Movies</a>
    </nav>

    <div id="search">
        <?php
            $titleSearch = $_GET['titleSearch'] ?? '';
            $yearSearch = $_GET['yearSearch'] ?? '';
            $message = '';
            if (empty($titleSearch) && empty($yearSearch) && (isset($_GET['titleSearch']) || isset($_GET['yearSearch']))) {
                $message = "<p class='msg'>Please enter a title or year to search.</p>";
            } else if (!empty($titleSearch) || !empty($yearSearch)) {
                $dbpath = "/home/yw6054/databases/movie.db";
                $db = new SQLite3($dbpath);
                $sql = 'SELECT * FROM movies WHERE 1=1';
                if (!empty($titleSearch)) {
                    $sql .= ' AND title LIKE :titleSearch';
                }
                if (!empty($yearSearch)) {
                    $sql .= ' AND year = :yearSearch';
                }

                $stmt = $db->prepare($sql);
                
                if (!empty($titleSearch)) {
                    $stmt->bindValue(':titleSearch', '%' . $titleSearch . '%', SQLITE3_TEXT);
                }
                if (!empty($yearSearch)) {
                    $stmt->bindValue(':yearSearch', $yearSearch, SQLITE3_INTEGER);
                }

                $result = $stmt->execute();
                $found = false;
                $output = "<ul>";
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $found = true;
                    $output .= "<li>" . htmlspecialchars($row['title']) . " (" . htmlspecialchars($row['year']) . ")</li>";
                }
                $output .= "</ul>";

                if (!$found) {
                    $message = "<p class='msg'>No movies found matching your search criteria.</p>";
                }
                $db->close();
            }
            echo $message;
        ?>

        <form action="search_form.php" method="get">
            Title: <input type="text" name="titleSearch"><br>
            Year: <input type="number" name="yearSearch">
            <input type="submit" value="Search">
        </form>

        <?php if (isset($output)) echo $output; ?>
    </div>

    <script>
        let allTabs = document.querySelectorAll('.tab');
        for (let i = 0; i < allTabs.length; i++) {
            allTabs[i].onclick = function (event) {
                document.querySelector('.active').classList.remove('active');
                event.currentTarget.classList.add('active');
                let allContent = document.querySelectorAll('#content div');
                for (let j = 0; j < allContent.length; j++) {
                    allContent[j].classList.add('hidden');
                }
                let myContentPanel = document.querySelector(event.currentTarget.dataset.mycontentpanel);
                myContentPanel.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
