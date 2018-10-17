<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Mayank Agrawal - Autos Database</title>
<?php require_once "bootstrap.php"; ?>
<?php
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }
    ?>
</head>
<body>
<div class="container">
<h1>Welcome to Autos Database</h1>
<p>
<a href="login.php">Please log in</a>
</p>
<p>
Attempt to go to
<a href="add.php">add.php</a> without logging in - it should fail with an error message.
</p>
<p>
Attempt to go to
<a href="view.php">view.php</a> without logging in - it should fail with an error message.
</p>
</div>
</body>
