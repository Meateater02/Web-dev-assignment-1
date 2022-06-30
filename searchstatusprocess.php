<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Status Information</title>
</head>

<body>
    <h1>Status Information</h1>
    <div class="content">
        <?php
        require_once('../../conf/settings.php'); //to get access to the database

        $search = $_GET['Search'];

        if (isset($search) && $search != "") {
            $conn = mysqli_connect($host, $user, $pswd, $dbnm) or die("<p>Server connection failure.</p>"); //connection to the database

            if ($conn) { //database connected
                $sqlExist = "SELECT 1 FROM statusForm";
                $exists = mysqli_query($conn, $sqlExist);

                if ($exists) {
                    $query = "SELECT * FROM statusForm WHERE stat LIKE '%" . $search . "%'";

                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        echo "<p>Something is wrong with " . $query . "</p>";
                    } else if (mysqli_num_rows($result) == 0) {
                        echo "<p>Status not found. Please try a different keyword.</p>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "Status code: " . $row["statusCode"] . "<br>";
                            echo "Status: " . $row["stat"] . "<br>";
                            echo "Share: " . $row["share"] . "<br>";
                            echo "Date: " . $row["dateEntered"] . "<br>";
                            echo "Permission:" . "<br>";
                            echo "Allow Like: " . $row["allowLike"] . "<br>";
                            echo "Allow Comment: " . $row["allowComment"] . "<br>";
                            echo "Allow Share: " . $row["allowShare"] . "<br>";
                            echo "<br><br>";
                        }
                        mysqli_free_result($result);
                    }
                } else {
                    echo "<p>No records found. Post something first.</p>";
                }
            } else {
                echo "<p>Database connection failure.</p>";
            }
        } else {
            echo "<p>Error! Search is blank. Please enter a keyword to search.</p>";
        }

        ?>
        <br>
        <a href="searchstatusform.html">Search for another status</a>
        <br>
        <a href="index.html">Return to Home Page</a>
    </div>
</body>

</html>