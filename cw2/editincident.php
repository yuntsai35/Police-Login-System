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
//Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
$id = $_GET['id'];

$sql = "SELECT 
    Incident.Incident_ID, 
    Vehicle.Vehicle_plate,
    People.People_name,
    People.People_licence, 
    Incident.Incident_Date,
    Incident.Incident_Report, 
    Offence.Offence_description, 
    Offence.Offence_ID
FROM Incident
JOIN People ON People.People_ID = Incident.People_ID
JOIN Vehicle ON Vehicle.Vehicle_ID = Incident.Vehicle_ID
JOIN Offence ON Offence.Offence_ID = Incident.Offence_ID
WHERE Incident.Incident_ID = '$id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$old_licence = $row['People_licence'];
$old_plate = $row['Vehicle_plate'];
$old_offence = $row['Offence_description'];
$old_date = $row['Incident_Date'];
$old_report = $row['Incident_Report'];
//Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
if (isset($_POST['licence'], $_POST['plate'], $_POST['date'], $_POST['offence'], $_POST['report']) &&
    $_POST['licence'] != "" && $_POST['plate'] != "" && $_POST['date'] != "" && $_POST['offence'] != "" && $_POST['report'] != "") {

    $licence = $_POST['licence'];
    $plate = $_POST['plate'];
    $offence = $_POST['offence'];
    $date = $_POST['date'];
    $report = $_POST['report'];

    $people_id_sql = "SELECT People_ID FROM People WHERE People_licence = '$licence'";
    $vehicle_id_sql = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_plate = '$plate'";
    $offence_id_sql = "SELECT * FROM Offence WHERE Offence_ID = '$offence'";


    $people_result = mysqli_fetch_assoc(mysqli_query($conn, $people_id_sql));
    $vehicle_result = mysqli_fetch_assoc(mysqli_query($conn, $vehicle_id_sql));
    $offence_result = mysqli_fetch_assoc(mysqli_query($conn, $offence_id_sql));

    if (mysqli_num_rows(mysqli_query($conn, $people_id_sql)) > 0 &&
        mysqli_num_rows(mysqli_query($conn, $vehicle_id_sql)) > 0 &&
        mysqli_num_rows(mysqli_query($conn, $offence_id_sql)) > 0) {

        $people_id = $people_result['People_ID'];
        $vehicle_id = $vehicle_result['Vehicle_ID'];
        $offence_id = $offence_result['Offence_ID'];
        $offence_description = $offence_result['Offence_description'];

        $sql = "UPDATE Incident 
            SET People_ID = '$people_id', Vehicle_ID = '$vehicle_id', Offence_ID = '$offence_id', 
                Incident_Date = '$date', Incident_Report = '$report' WHERE Incident_ID = '$id'";

        $result = mysqli_query($conn, $sql);

        $detail = "changed record: Date=$old_date, Plate=$old_plate, Licence=$old_licence, Report=$old_report, 
                    Description=$old_offence change to Date=$date, Plate=$plate, Licence=$licence, 
                    Report=$report, Description=$offence_description";

        $history_sql = "INSERT INTO history (username, type, `database`, action, detail, timestamp) 
                        VALUES ('" . $_SESSION['name'] . "', '" . $_SESSION['username_type'] . "', 'Incident', 'Edit', '$detail', NOW())";

        mysqli_query($conn, $history_sql);

        header("Location: newincident.php");
        exit();
    } else {
        $error = [];
        if (mysqli_num_rows(mysqli_query($conn, $people_id_sql)) == 0) {
            $error[] = 'incorrect licence or plate! Please check if the information exists or is correct!';
        }
        if (mysqli_num_rows(mysqli_query($conn, $vehicle_id_sql)) == 0) {
            $error[] = 'incorrect plate or description! Please check if the information exists or is correct!';
        }
        if (mysqli_num_rows(mysqli_query($conn, $offence_id_sql)) == 0) {
            $error[] = 'incorrect offence description! Please check if the information exists or is correct!';
        }
    }
}
?>

<html>
  <head>
    <title>Edit Incident</title>
    <!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI-->
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
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">Edit Incident</h1>

<form method="post">
  <div class="parent">
  <!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI-->
  <?php
        if (isset($error)){
            foreach($error as $error){
                echo'<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>     
  <br>
       Date: <input type="date" id="date" name="date" required class="form-control w-25" value=<?php echo $old_date;?>><br>
       Vehicle Plate: <input type="text" placeholder="Enter Plate" name="plate" class="form-control w-25" value=<?php echo $old_plate;?>><br>
       Licence: <input type="text" placeholder="Enter Licence" name="licence" class="form-control w-25" value=<?php echo $old_licence;?>><br>
       Report: <input type="text" placeholder="Write Report" name="report" class="form-control w-25" value=<?php echo $old_report;?>><br>
      Description:
    <select class="form-select w-25" aria-label="Default select example" name="offence" value=<?php echo $old_offence;?>>
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