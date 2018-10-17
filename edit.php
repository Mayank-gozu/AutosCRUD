<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}


if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage'])
     && isset($_POST['autos_id'])) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1
        || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    if((is_numeric($_POST['year']) == false))
    {
      $_SESSION["error"] = "Year must be numeric";
      header("Location: edit.php?autos_id=".$_POST['autos_id']);
      return;
    }
    if((is_numeric($_POST['mileage'])==false) )
    {
      $_SESSION["error"] = "Mileage must be numeric";
      header("Location: edit.php?autos_id=".$_POST['autos_id']);
      return;
    }

    $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year,
            mileage = :mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record edited';
    header( 'Location: view.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: view.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM `autos` WHERE autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: view.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$m = htmlentities($row['make']);
$y = htmlentities($row['year']);
$mo = htmlentities($row['model']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<html>
<head>
  <?php require_once "bootstrap.php";?>
  <title>Mayank Agrawal Automobile Tracker</title>
  <body>
    <div class = "container">
<p><h1>Editing Automobile</h1></p>
<form method="post">
<p>Make
<input type="text" name="make" value="<?= $m ?>"></p>
<p>Model
<input type="text" name="model" value="<?= $mo ?>"></p>
<p>Year
<input type="text" name="year" value="<?= $y ?>"></p>
<p>Mileage
<input type="text" name="mileage" value="<?= $mi ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<p><input type="submit" name = "add" value="Save"/>
<input type="submit" name="cancel" value="Cancel"></p>
</form>
</div>
</body>
</html>
