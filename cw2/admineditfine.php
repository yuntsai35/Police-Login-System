<?php
session_start();
?>
<?php  
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$dbname = "coursework2"; 
$error=[];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$id = $_GET['id'];
//Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
$incident_sql="SELECT Fines.Fine_ID, People.People_name,
Vehicle.Vehicle_plate FROM Fines JOIN Incident ON Fines.incident_ID = Incident.Incident_ID JOIN  People ON Incident.People_ID = People.People_ID JOIN Vehicle ON Incident.Vehicle_ID = Vehicle.Vehicle_ID WHERE Fine_ID='$id'";
$incident_result = mysqli_query($conn, $incident_sql);
$incident_row = mysqli_fetch_assoc($incident_result);
$people=$incident_row['People_name'];
$vehicle=$incident_row['Vehicle_plate'];
$sql = "SELECT Fine_Amount, Fine_Points FROM Fines WHERE Fine_ID='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$amount = $row['Fine_Amount'];
$point = $row['Fine_Points'];

if (isset($_POST['amount']) && $_POST['amount'] != "" && 
    isset($_POST['point']) && $_POST['point'] != "") {  

    $new_amount = $_POST['amount'];
    $new_point = $_POST['point'];

    
    $sql = "UPDATE Fines 
            SET Fine_Amount = '$new_amount', Fine_Points = '$new_point' 
            WHERE Fine_ID = '$id'";
    $result = mysqli_query($conn, $sql);

    $detail = "People Name=$people, Vehicle plate=$vehicle changed password: old Fine Amount=$amount, Fine Point=$point change to New Fine Amount=$new_amount, Fine Point=$new_point";

    $ssql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
             VALUES ('$_SESSION[name]', '$_SESSION[username_type]', 'adminfine', 'Edit', '$detail', NOW())";

    mysqli_query($conn, $ssql);

    header("Location: adminfine.php");
    exit();
}

    
?>

<html>
  <head>
    <title>Edit admin user</title>
    
    <style>
        .form-label {
           margin: auto;
           display: block;
        }
        .parent {
           display: grid;
           place-items: center;
        }
    </style>
    <!--Bootstriap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
  </head>

  <body style="background-color:#92a8d1;">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <nav class="navbar sticky-top navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Police System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Admin
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="adminuser.php">User information</a></li>
            <li><a class="dropdown-item" href="adminfine.php">Fine Edit</a></li>
            <li><a class="dropdown-item" href="adminhistory.php">History Recording</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">Edit admin user</h1>

<form method="post">
  <div class="parent">
      Fine Amount: <input type="text" placeholder="Enter Amount" name="amount" class="form-control w-25" value=<?php echo $amount;?>><br>
      Fine Point: <input type="text" placeholder="Enter Points" name="point" class="form-control w-25" value=<?php echo $point;?>><br>
    <br>
       <input type="submit" value="update" class="btn btn-primary mb-2">
</div>
</div>
</form>
      </body>
      </html>