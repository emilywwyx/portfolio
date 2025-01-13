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
    </style>
</head>

<body>
    <h1>My Movie Database</h1>
    <nav>
        <a href="index.php" class="tab" data-mycontentpanel="#view">View All</a>
        <a href="add_form.php" class="tab active" data-mycontentpanel="#add">Add Movie</a>
        <a href="search_form.php" class="tab" data-mycontentpanel="#search">Search Movies</a>
    </nav>

    <?php
        if (isset($_GET['error'])) {
            $type = $_GET['error'];
            if ($type === "miss") {
                print "<p class='msg'>Please fill in all fields!</p>";
            }
        }

        if (isset($_GET['success'])) {
            if ($_GET['success'] === "yes") {
                print "<p class='msg'>Movie was added successfully!</p>";
            }
        }

    ?>

    <div id="content">
        <div id="view" class="hidden">
        </div>
        <div id="add">
        </div>
        <div id="search" class="hidden">
        </div>
    </div>

    <form action="add_save.php" method="post">
        Title: <input type="text" name="title"><br>
        Year: <input type="number" name="year">
        <input type="submit" value="Save">
    </form>

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