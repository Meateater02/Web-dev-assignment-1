<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Post Status Form</title>
</head>

<body>
    <div class="content">
        <?php

        //password to connect to the database
        require_once('../../conf/settings.php');

        //connection to the database
        $conn = mysqli_connect($host, $user, $pswd, $dbnm);

        //declare the variables
        $statusCodeErr = ""; //the string to echo out if status code does not meet the requirement
        $statusErr = ""; //the string to echo out if status does not meet the requirement
        $dateErr = ""; //the string to echo out if date does not match the pattern
        $patternCode = "/^S\d{4}$/"; //pattern for the status code
        $patternSta = "/^[A-Za-z0-9!,\.\? ]+$/"; //pattern for the status
        $patternDate = "/^\d{2}\/\d{2}\/\d{4}$/"; //pattern for date

        //check if the status code matches and is not null
        if (!empty($_POST["statuscode"]) && preg_match($patternCode, $_POST["statuscode"])) {

            $sql = "SELECT 1 FROM statusForm";
            $exists = mysqli_query($conn, $sql);

            //check if table exists in the database
            if ($exists) {
                $check = $_POST["statuscode"];
                $queryCheck = "SELECT * FROM statusForm WHERE statusCode = '$check'";
                $resultCheck = mysqli_query($conn, $queryCheck);
                if (mysqli_num_rows($resultCheck) == 0) {
                    $statusCode = $_POST["statuscode"];
                } else {
                    $statusCodeErr = "<p>The status code already exists. Please try another one!</p>";
                }
            } else {
		$statusCode = $_POST["statuscode"]; //if table doesn't exist but meets the requirements
	      }
        } else if (empty($_POST["statuscode"])) {
            $statusCodeErr = "<p>Status Code cannot be empty.</p>"; //check if statusCode is empty
        } else if (!preg_match($patternCode, $_POST["statuscode"])) {
            $statusCodeErr = "<p>Wrong Format! Code must start with capital letter S followed by 4 numbers: e.g. S0001</p>"; //checks if statusCode has the right pattern
        }

        //check if the status matches and is not null
        if (!empty($_POST["status"]) && preg_match($patternSta, $_POST["status"])) {
            $status = $_POST["status"];
        } else if (empty($_POST["status"])) {
            $statusErr = "<p>Status cannot be empty.</p>"; //checks if status is empty
        } else if (!preg_match($patternSta, $_POST["status"])) {
            $statusErr = "<p>Wrong format! Status can only contain alphanumericals and spaces, comma, period, exclamation point and question mark</p>"; //checks if status has the right pattern
        }

        //check if date format is correct and not null
        if (!empty($_POST["date"]) && preg_match($patternDate, $_POST["date"])) {

            $date = $_POST["date"];
            $day = substr($date, 0, 2);
            $month = substr($date, 3, 2);
            $year = substr($date, 6, 4);

            $valid_date = checkdate($month, $day, $year);

            //check if date is a valid date
            if (!$valid_date) {
                $dateErr = "<p>Date entered is not a valid date.</p>";
            }
        } else if (empty($_POST["date"])) {
            $dateErr = "<p>Date cannot be empty.</p>"; //checks if status is empty
        } else if (!preg_match($patternDate, $_POST["date"])) {
            $dateErr = "<p>Date must be in the format dd/mm/yyyy. E.g. 01/03/2022</p>"; //checks if status has the right pattern
        }

        //check if allow share radio button is selected or not 
        if (!empty($_POST["share"])) {
            $share = $_POST["share"];
        } else {
            $share = "None";
        }

        //check for if checkbox is ticked for allow like
        if (!empty($_POST["perm1"])) {
            $perm1 = $_POST["perm1"];
        } else {
            $perm1 = "no";
        }

        //check for if checkbox is ticked for allow comment
        if (!empty($_POST["perm2"])) {
            $perm2 = $_POST["perm2"];
        } else {
            $perm2 = "no";
        }

        //check for if checkbox is ticked for allow share
        if (!empty($_POST["perm3"])) {
            $perm3 = $_POST["perm3"];
        } else {
            $perm3 = "no";
        }

        //if status code, status and date are correct, then post into the database
        if (($statusCodeErr == "") && ($statusErr == "") && ($dateErr == "")) {

            //check connection to database
            if (!$conn) {
                echo "<p>Connection failure</p>";
            } else {
		//uncomment line below for testing purpose
                //echo "<p>Connection Successful</p>"; 

                $sql = "SELECT 1 FROM statusForm";
                $exists = mysqli_query($conn, $sql);

                //check if table exists in the database
                if (!$exists) {
		    //uncomment line below for testing purpose
                    //echo "<p>table doesn't exist</p>";

                    //create table if it doesn't exist
                    $sqlString = "CREATE TABLE statusForm (
                statusCode VARCHAR(5) PRIMARY KEY,
                stat VARCHAR(128) NOT NULL,
                share VARCHAR(7),
                dateEntered VARCHAR(10) NOT NULL,
                allowLike VARCHAR(3),
                allowComment VARCHAR(3),
                allowShare VARCHAR(3))";
                    $tableResult = mysqli_query($conn, $sqlString);
                    if (!$tableResult) {
                        echo "<p>Something is wrong with " . $tableResult . "</p>";
                    } else {
                        //uncomment below for testing purpose
			//echo "<p>Table created!</p>";
                        $exists = true;
                    }
                } else {
		    //uncomment below for testing purpose
                    //echo "<p>Table exist</p>";
                }

                //if table exist, then post the data into the table
                if ($exists == true) {

                    $query = "INSERT INTO statusForm"
                        . "(statusCode, stat, share, dateEntered, allowLike, allowComment, allowShare)"
                        . "VALUES"
                        . "('$statusCode','$status','$share','$date','$perm1','$perm2','$perm3')";

                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        echo "<p>Something is wrong with " . $query . "</p>";
                    } else {
                        echo "<p>Congratulations! The status has been successfully posted!</p>";
                    }
                    mysqli_close($conn);
                }
            }
        } 

        ?>

        <?php echo $statusCodeErr ?>
        <?php echo $statusErr ?>
        <?php echo $dateErr ?>
        <a href="poststatusform.php">Post a New Form</a>
        <br>
        <a href="index.html">Return to Home Page</a>
    </div>
</body>

</html>