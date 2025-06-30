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
   //Professor's code of insert and delete:lab-8-demo-code/ineractive-5.php
                    
   if (
    isset($_POST['plate']) && $_POST['plate'] != "" &&
    isset($_POST['type']) && $_POST['type'] != "" &&
    isset($_POST['colour']) && $_POST['colour'] != ""
) {
    $plate = $_POST['plate'];


    $vehicle_plate_sql = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_plate = '$plate'";
    $vehicle_result = mysqli_query($conn, $vehicle_plate_sql);

    if (mysqli_num_rows($vehicle_result) == 0) {
        
        $sql = "INSERT INTO Vehicle (Vehicle_plate, Vehicle_type, Vehicle_colour) 
                VALUES ('" . $_POST['plate'] . "', '" . $_POST['type'] . "', '" . $_POST['colour'] . "')";
        
        if (mysqli_query($conn, $sql)) {
            $vehicle_id = mysqli_insert_id($conn);

            $query = "SELECT Vehicle_plate, Vehicle_type, Vehicle_colour FROM Vehicle WHERE Vehicle_ID = '$vehicle_id'";
            $result = mysqli_query($conn, $query);

            if ($row = mysqli_fetch_assoc($result)) {
                $plate = $row['Vehicle_plate'];
                $brand = $row['Vehicle_type'];
                $colour = $row['Vehicle_colour'];

                $detail = "Insert record: Plate = $plate, Brand = $brand, Colour = $colour";
                $ssql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
                         VALUES ('" . $_SESSION['name'] . "', '" . $_SESSION['username_type'] . "', 'Vehicle', 'Insert', '$detail', NOW())";
                mysqli_query($conn, $ssql);

                header("Location: newvehicle.php");
                exit();
            }
        }
    } else {
        
        $error[]= "Vehicle already exists.";
    }
}

?>


<html>
  <head>
    <title>New Vehicle</title>
    <!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI for error part-->
    <style>
        .error-container {
            display: flex;
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            text-align: center;
        }

        .error-msg {
            color: red;
            font-size: 1.2em;
            background-color: #ffe6e6;
            padding: 10px 20px;
            border: 1px solid red;
            border-radius: 5px;
            margin-top: 10px;
            display: inline-block;
            margin-bottom: 10px;
        }
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
        <li class="nav-item">
          <a class="nav-link" href="newuser.php">User</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Searching
          </a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="newpeople.php">People</a></li>
            <li><a class="dropdown-item" href="newvehicle.php">Vehicle</a></li>
            <li><a class="dropdown-item" href="newoffence.php">Offence</a></li>
            <li><a class="dropdown-item" href="newownership.php">Ownership</a></li>
            <li><a class="dropdown-item" href="newincident.php">Incident</a></li>
            <li><a class="dropdown-item" href="newfines.php">Fines</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">New Vehicle</h1>

<!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI for error part-->
<div class="align-items-center text-center w-75 p-3">
    <?php
        if (isset($error)){
            foreach($error as $error){
                echo'<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>
</div>

<form method="post">
  <div class="row justify-content-center align-items-center">
    <div class="col-auto">
       Vehicle Plate: <input type="text" placeholder="Enter Plate" name="plate" class="form-control mb-2 mr-2">
    </div>
    <div class="col-auto">
       Brand: <input type="text" placeholder="Enter Brand" name="type" class="form-control mb-2 mr-2">
    </div>
    <div class="col-auto">
       Colour: <input type="text" placeholder="Enter Colour" name="colour" class="form-control mb-2 mr-2">
    </div>
    <div class="col-auto">
       <input type="submit" value="update" class="btn btn-primary mb-2">
    </div>
  </div>
</form>
      </body>
      </html>