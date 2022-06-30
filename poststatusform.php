<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Post Status Form</title>
</head>

<body>
    <ul class="navbar">
        <li class="navlist">
            <a href="index.html" class="name">Home</a>
        </li>
        <li class="navlist active">
            <a href="poststatusform.php">Post Status</a>
        </li>
        <li class="navlist">
            <a href="searchstatusform.html">Search Status</a>
        </li>
        <li class="navlist">
            <a href="about.html">About This Assignment</a>
        </li>

    </ul>
    <div class="cntxt content">
        <h1>Post Status Form</h1>

        <form method="post" action="poststatusprocess.php">
            <label>Status Code (required):
                <input type="text" name="statuscode" placeholder="e.g. S0001">
            </label>
            <br>
            <br>
            <label>Status (required):
                <input type="text" name="status" placeholder="What are you currently doing?">
            </label>
            <br>
            <br>
            <label>Share:
                <input type="radio" name="share" value="public">
                <label for="html">Public</label>
                <input type="radio" name="share" value="friends">
                <label for="css">Friends</label>
                <input type="radio" name="share" value="onlyMe">
                <label for="javascript">Only Me</label>
            </label>
            <br>
            <br>
            <label>Date (dd/mm/yyyy):
                <input name="date" type="text" value="<?php echo date('d/m/Y') ?>" />
            </label>
            <br>
            <br>
            <label>Permission Type:
                <input type="checkbox" name="perm1" value="yes">
                <label for="html">Allow Like</label>
                <input type="checkbox" name="perm2" value="yes">
                <label for="css">Allow Comments</label>
                <input type="checkbox" name="perm3" value="yes">
                <label for="javascript">Allow Share</label>
            </label>
            <br>
            <br>
            <button type="submit" name="submit">Submit</button>
        </form>
	<br>
	<a href="index.html">Return to Home page</a>
    </div>

<footer>Davina Phan 1300285</footer>
</body>

</html>