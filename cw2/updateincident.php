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
//Professor's code of insert and delete:lab-8-demo-code/ineractive-5.php for insert
if (isset($_POST['licence']) && $_POST['licence'] != "" && 
    isset($_POST['plate']) && $_POST['plate'] != "" && 
    isset($_POST['date']) && $_POST['date'] != "" && 
    isset($_POST['offence']) && $_POST['offence'] != "" && 
    isset($_POST['report']) && $_POST['report'] != "") {  

    $licence = $_POST['licence'];
    $plate = $_POST['plate'];
    $offence = $_POST['offence'];
    
    $people_id = "SELECT People_ID, People_licence FROM People WHERE People_licence = '$licence'";
    $vehicle_id = "SELECT Vehicle_ID, Vehicle_plate FROM Vehicle WHERE Vehicle_plate = '$plate'";
    $offence_id = "SELECT Offence_ID, Offence_description FROM Offence WHERE Offence_ID ='$offence'";

    $people_result = mysqli_fetch_assoc(mysqli_query($conn, $people_id));
    $vehicle_result = mysqli_fetch_assoc(mysqli_query($conn, $vehicle_id));
    $offence_result = mysqli_fetch_assoc(mysqli_query($conn, $offence_id));

    if (mysqli_num_rows(mysqli_query($conn, $people_id)) > 0 && 
        mysqli_num_rows(mysqli_query($conn, $vehicle_id)) > 0 && 
        mysqli_num_rows(mysqli_query($conn, $offence_id)) > 0) {

        $People_licence = $people_result['People_licence'];
        $Vehicle_plate = $vehicle_result['Vehicle_plate'];
        $Description = $offence_result['Offence_description'];

        $sql = "INSERT INTO incident (People_ID, Vehicle_ID, Incident_date, Incident_report, Offence_ID, Incident_name) 
                VALUES (" . $people_result['People_ID'] . ", " . $vehicle_result['Vehicle_ID'] . ", '" . $_POST['date'] . "', '" . $_POST['report'] . "', " . $offence_result['Offence_ID'] . ", '" . $_SESSION['name'] . "');";

        if (mysqli_query($conn, $sql)) {
            $incident_id = mysqli_insert_id($conn);
            $ssql = "INSERT INTO Fines (Incident_ID) VALUES ($incident_id);";
            mysqli_query($conn, $ssql);

        
            $date = $_POST['date'];
            $report = $_POST['report'];
            $detail = "Insert record: Date=$date, Plate=$Vehicle_plate, Licence=$People_licence, Report=$report, Description=$Description";
            $history_sql = "INSERT INTO history (username, type, `database`, action, detail, timestamp) 
                            VALUES ('" . $_SESSION['name'] . "', '" . $_SESSION['username_type'] . "', 'Incident', 'Insert', '$detail', NOW());";
            mysqli_query($conn, $history_sql);

            header("Location:newincident.php");
            exit();
        }
    } else {
        if (mysqli_num_rows(mysqli_query($conn, $people_id)) > 0 && 
            mysqli_num_rows(mysqli_query($conn, $vehicle_id)) == 0 && 
            mysqli_num_rows(mysqli_query($conn, $offence_id)) == 0) {
            $error[] = 'Incorrect plate or description! Please check if the information exists or is correct!';
        } elseif (mysqli_num_rows(mysqli_query($conn, $people_id)) == 0 && 
                  mysqli_num_rows(mysqli_query($conn, $vehicle_id)) > 0 && 
                  mysqli_num_rows(mysqli_query($conn, $offence_id)) == 0) {
            $error[] = 'Incorrect licence or description! Please check if the information exists or is correct!';
        } elseif (mysqli_num_rows(mysqli_query($conn, $people_id)) > 0 && 
                  mysqli_num_rows(mysqli_query($conn, $vehicle_id)) > 0 && 
                  mysqli_num_rows(mysqli_query($conn, $offence_id)) == 0) {
            $error[] = 'Please enter the description!';
        } else {
            $error[] = 'Incorrect licence or plate! Please check if the information exists or is correct!';
        }
    }
}

?>

<html>
  <head>
    <title>New incident</title>
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
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">New Incident</h1>
<!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI for error part-->
<form method="post">
  <div class="parent">
  <?php
        if (isset($error)){
            foreach($error as $error){
                echo'<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>     
  <br>
       Date: <input type="date" id="date" name="date" required class="form-control w-25"><br>
       Vehicle Plate: <input type="text" placeholder="Enter Plate" name="plate" class="form-control w-25"><br>
       Licence: <input type="text" placeholder="Enter Licence" name="licence" class="form-control w-25" ><br>
       Report: <input type="text" placeholder="Write Report" name="report" class="form-control w-25"><br>
      Description:
    <select class="form-select w-25" aria-label="Default select example" name="offence">
        <option selected>choose an option</option>
        <option value="1">Speeding</option>
        <option value="2">Speeding on a motorway</option>
        <option value="3">Seat belt offence</option>
        <option value="4">Illegal parking</option>
        <option value="5">Drink driving</option>
        <option value="6">Driving without a licence</option>
        <option value="7">Traffic light offences</option>
        <option value="8">Cycling on pavement</option>
        <option value="9">Failure to have control of vehicle</option>
        <option value="10">Dangerous driving</option>
        <option value="11">Careless driving</option>
        <option value="12">Dangerous cycling</option>
    </select>
    <br>
       <input type="submit" value="update" class="btn btn-primary mb-2">
</div>
</div>
</form>
      </body>
      </html>