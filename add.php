<?php
require_once "pdo.php";
session_start();
//handling bad login
if ( ! isset($_SESSION["name"]) ) {
die('ACCESS DENIED');

}
//handling the cancel button
if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}

if (isset($_POST['make']) && (isset($_POST['model']))
     && isset($_POST['year'])&& isset($_POST['mileage'])) {
       if(strlen($_POST['make'])<1 ||strlen($_POST['year'])<1||
     strlen($_POST['model'])<1||strlen($_POST['mileage'])<1){
         $_SESSION["error"] = "All fields are required";
         header('Location:add.php');
         return;
       }
     if((is_numeric($_POST['year']) == false))
     {
       $_SESSION["error"] = "Year must be numeric";
       header('Location:add.php');
       return;
     }
     if((is_numeric($_POST['mileage'])==false) )
     {
       $_SESSION["error"] = "Mileage must be numeric";
       header('Location:add.php');
       return;
     }

     if($_SESSION["error"] ==false){
       $_SESSION["success"] = "Record added";
    $sql = "INSERT INTO autos (make,model, year, mileage)
              VALUES (:make,:model,:year, :mileage)";
  //  echo("<pre>\n".$sql."\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' =>$_POST['mileage']));
        if(isset($_POST['add']) ){
          header('Location:view.php');
          return;
        }
}
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Mayank Agrawal Automobile Tracker</title>
</head>
<body>
  <div class = "container">
<?php
if ( isset($_SESSION["error"]) ) {
    echo('<p style="color:red">'.htmlentities($_SESSION["error"])."</p>\n");
    unset($_SESSION["error"]);
}
?>
<h1>Tracking Autos for
  <?php
 echo($_SESSION["name"]);
  ?>
</h1>
<form method="post">
<p>Make
<input type="text" name="make"></p>
<p>Model
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
  <input type="text" name = "mileage"></p>
<p><input type="submit" name = "add" value="Add"/>
<input type="submit" name="cancel" value="Cancel"></p>
</form>
</body>
</html>
