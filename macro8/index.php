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
            margin-bottom: 20px;;
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

        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 5px;
            border: 1px solid black;
        }

        th {
            background-color: #f8f9fa;
        }

        td a {
            color: blue;
        }
    </style>
</head>

<body>
    <h1>My Movie Database</h1>
    <nav>
        <a href="index.php" class="tab active" data-mycontentpanel="#view">View All</a>
        <a href="add_form.php" class="tab" data-mycontentpanel="#add">Add Movie</a>
        <a href="search_form.php" class="tab" data-mycontentpanel="#search">Search Movies</a>
    </nav>

    <?php
        if (isset($_GET['msg'])) {
            $type = $_GET['msg'];
            if ($type === 'success') {
                print "<p class='msg'>Movie was deleted successfully!</p>";
            }
            if ($type === 'error') {
                print "<p class='msg'>Error deleting movie!</p>";
            }
            if ($type === 'invalidID') {
                print "<p class='msg'>Invalid ID for movie!</p>";
            }
        }

    ?>

    <div id="content">
        <div id="view">
            <?php
                $dbpath = "/home/yw6054/databases/movie.db";
                $db = new SQLite3($dbpath) or die("Unable to open database");

                $query = "SELECT id, title, year FROM movies";
                $result = $db->query($query) or die("Query failed: " . $db->lastErrorMsg());

                print "<table border='1'>";
                print "<tr><th>Title</th><th>Year</th><th>Options</th></tr>";
                if ($result) {
                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                        print "<tr>";
                        print "<td>" . htmlspecialchars($row['title']) . "</td>";
                        print "<td>" . htmlspecialchars($row['year']) . "</td>";
                        print "<td><a href='delete_movie.php?id=" . urlencode($row['id']) . "'>Delete</a></td>";
                        print "</tr>";
                    }
                } else {
                    print "<p class='msg'>No data found</p>";
                }

                print "</table>";
                $db->close();
            ?>
        </div>
        <div id="add" class="hidden">
        </div>
        <div id="search" class="hidden">
        </div>
    </div>
    <script>
        // get a ref to all .tab elements
        let allTabs = document.querySelectorAll('.tab');

        // visit each element
        for (let i = 0; i < allTabs.length; i++) {
            // have each element listen for mouse clicks
            allTabs[i].onclick = function (event) {
                // when clicked, make the current active tab inactive
                document.querySelector('.active').classList.remove('active');

                // make this tab active
                event.currentTarget.classList.add('active');

                // hide all of the other content panels
                let allContent = document.querySelectorAll('#content div');
                for (let j = 0; j < allContent.length; j++) {
                    allContent[j].classList.add('hidden');
                }

                // use our dataset property (#ID) to figure out which tab should be shown by using its ID
                let myContentPanel = document.querySelector(event.currentTarget.dataset.mycontentpanel);
                myContentPanel.classList.remove('hidden');
            }
        }


    </script>
</body>

</html>