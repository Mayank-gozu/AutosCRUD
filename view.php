
<?php
    session_start();

    if ( ! isset($_SESSION["name"]) ) {
    die('Not logged in');
}

if ( isset($_POST["logout"]) ) {
    header('Location: logout.php');
    return;
}
if(isset($_POST["add"])){
  header('Location:add.php');
  return;
}
require_once "pdo.php";

$stmt = $pdo->query("SELECT make,model,year,mileage,autos_id FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<?php require_once "bootstrap.php";?>
<title > Mayank Agrawal Automobile Tracker</title>
<body style="font-family: sans-serif;">
  <div class="container">
  <h1>Welcome to the Automobiles Database
  </h1>
<?php
        if ( isset($_SESSION["success"]) ) {
          echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
          unset($_SESSION["success"]);
        }
        ?>
        <p>
          <?php
            if($rows == FALSE){
              echo("No rows found");
            }
            else{?>
              <h2>Automobiles</h2>
        <table border="2" style = "width:100%">
          <th>Make</th>
          <th>Model</th>
          <th>Year</th>
          <th>Mileage</th>
          <th>Action</th>
        <?php
        foreach ( $rows as $row ) {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }
      }
        ?>
        </p>
        </table>
        <form method ="post">
          <p>
  <a href="add.php">Add New Entry</a> </p>
</br>
  <p><a href="logout.php">Logout</a>
  </p>
      </form>
    </body>
</body>
</html>
