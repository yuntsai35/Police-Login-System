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
       if (isset($_GET['del']) && $_GET['del'] != "") { 
        $incident_id = $_GET['del'];
    
        
        $post_user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Incident_name FROM Incident WHERE incident_ID = ".$_GET['del'].";"))["Incident_name"];
        
        
        if ($_SESSION["name"] == $post_user || $_SESSION["username_type"] == "admin") {   
      
            
            $incident_query = "SELECT * FROM Incident WHERE Incident_ID = $incident_id";
            $incident_result = mysqli_query($conn, $incident_query);
        
            if ($incident_result && mysqli_num_rows($incident_result) > 0) {
                $incident_row = mysqli_fetch_assoc($incident_result);
        
        
                $people_id = $incident_row['People_ID'];
                $vehicle_id = $incident_row['Vehicle_ID'];
                $offence_id = $incident_row['Offence_ID'];
        
                $people_query = "SELECT People_licence FROM People WHERE People_ID = $people_id";
                $vehicle_query = "SELECT Vehicle_plate FROM Vehicle WHERE Vehicle_ID = $vehicle_id";
                $offence_query = "SELECT Offence_description FROM Offence WHERE Offence_ID = $offence_id";
                
                $people_result = mysqli_query($conn, $people_query);
                $vehicle_result = mysqli_query($conn, $vehicle_query);
                $offence_result = mysqli_query($conn, $offence_query);
        

                if ($people_result && mysqli_num_rows($people_result) > 0 &&
                    $vehicle_result && mysqli_num_rows($vehicle_result) > 0 &&
                    $offence_result && mysqli_num_rows($offence_result) > 0) {
        
                    $people_row = mysqli_fetch_assoc($people_result);
                    $vehicle_row = mysqli_fetch_assoc($vehicle_result);
                    $offence_row = mysqli_fetch_assoc($offence_result);
        
                    $plate = $vehicle_row['Vehicle_plate'];
                    $licence = $people_row['People_licence'];
                    $description = $offence_row['Offence_description'];
                    $date = $incident_row['Incident_Date'];
                    $report = $incident_row['Incident_Report'];
        
                    
                    $detail = "Deleted record: Date= $date, Plate= $plate, Licence= $licence, Report= $report, Description= $description";
        
                  
                    $history_sql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
                                    VALUES ('" . $_SESSION['name'] . "', '" . $_SESSION['username_type'] . "', 'Incident', 'Delete', '$detail', NOW())";
                    mysqli_query($conn, $history_sql);
        
                    
                    $sqlOffenceDelete = "DELETE FROM Fines WHERE Incident_ID = $incident_id";
                    if (!mysqli_query($conn, $sqlOffenceDelete)) {
                      $error[] =  'Failed to delete related Fines: ' . mysqli_error($conn);
                        exit;
                    }
        
                    
                    $sqlDelete = "DELETE FROM Incident WHERE Incident_ID = $incident_id";
                    if (mysqli_query($conn, $sqlDelete)) {
                       $error[] = 'Deleted successfully!';
                    } else {
                      $error[] =  'Failed to delete Incident: ' . mysqli_error($conn);
                    }
                }
            } 
        } else {
            $error[]= "You do not have permission to delete this record.";
        }
      }
?>


<html>

  <head>
    <!-- Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
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
</style>
    <title>Incident</title>
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
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">Incident</h1>
    <div class="container">
       <form method="post">
<div class="row justify-content-center align-items-center mt-4">
    <div class="col-auto">
        <input type="type" placeholder="Search Vehicle or Driver Licence" name="search" class="form-control">
        </div>
        <div class="col-auto">
        <button class="btn btn-secondary" name="submit">Search</button>
       </div>
       <div class="col-auto">
       <a class="btn btn-outline-dark" href="updateincident.php" role="button">Add new incident information</a>
       </div>
</div>
</form>
</div>

<hr>
    <!-- Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
    <script>
        function confirmDelete(ID) 
        {
           var conf = confirm("Are you sure?"); 
           if (conf == true) 
           {
              delParam="?del="+ID; 
              this.document.location.href=delParam; 
           }
        } 
    </script>

<div class="align-items-center text-center w-75 ">
    <?php
        if (isset($error)){
            foreach($error as $error){
                echo'<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>
</div>

    <div class="container my-5">
            <table class="table table-sm table-bordered" style="text-align:center;">
      <!--searching information code from https://www.youtube.com/watch?v=9ANd4KVPQtE&t=679s&ab_channel=StepbyStep-->
                <?php
    if(isset($_POST['submit'])){
    $search=$_POST['search'];
    $sql="SELECT Incident.Incident_ID, Vehicle.Vehicle_plate,People.People_licence, Incident.Incident_Date,Incident.Incident_Report, Offence.Offence_description, Offence.Offence_ID,People.People_name FROM Incident JOIN People 
    ON People.People_ID = Incident.People_ID JOIN Vehicle ON Vehicle.Vehicle_ID = Incident.Vehicle_ID JOIN Offence ON Offence.Offence_ID = Incident.Offence_ID WHERE Vehicle_plate like '%$search%' or People_licence like '%$search%'";
    $result=mysqli_query($conn,$sql);
    if($result){
    if(mysqli_num_rows($result)>0){
       echo'<thead class="table-dark">
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Name</th>
          <th scope="col">Vehicle Plate</th>
          <th scope="col">Licence</th>
          <th scope="col">Report</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
        </thead>';
        while($row=mysqli_fetch_assoc($result)){
        echo '<tbody>
        <tr>
        <td>'.$row['Incident_Date'].'</td>
        <td>'.$row['People_name'].'</td>
        <td>'.$row['Vehicle_plate'].'</td>
        <td>'.$row['People_licence'].'</td>
        <td>'.$row['Incident_Report'].'</td>
        <td>'.$row['Offence_description'].'</td>
        <td>
        <a href="editincident.php?id=' . $row['Incident_ID'] . '" class="btn btn-outline-info">Edit</a>
        <button class="btn btn-outline-danger" onclick="confirmDelete(' . $row["Incident_ID"] . ')">Delete</button></td>
        </tr>
        </tbody>';
        }
    }else{
        echo '<h2 class=text-danger>Data not found</h2>';
    }
    }
}
?>
          </table>
        </div>
    
        <div class="container my-5">
        <table class="table table-sm table-bordered" style="text-align:center;">
      
      <!-- Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
      <?php 

        {

               
        
        $sql="SELECT 
        Incident.Incident_ID, 
        Vehicle.Vehicle_plate,
        People.People_name,
        People.People_licence, 
        Incident.Incident_Date,
        Incident.Incident_Report, 
        Offence.Offence_description, 
        Offence.Offence_ID
        FROM Incident JOIN People 
        ON People.People_ID = Incident.People_ID JOIN Vehicle ON Vehicle.Vehicle_ID = Incident.Vehicle_ID JOIN Offence ON Offence.Offence_ID = Incident.Offence_ID";
      

        
        $result = mysqli_query($conn, $sql);
        }

        
        echo "<p>".mysqli_num_rows($result)." rows</p>";
        
                                               
        if (mysqli_num_rows($result) > 0){
          echo'<thead class="table-dark">
          <tr>
          <th scope="col">Date</th>
          <th scope="col">Name</th>
          <th scope="col">Vehicle Plate</th>
          <th scope="col">Licence</th>
          <th scope="col">Report</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
          </tr>
          </thead>';
          while($row=mysqli_fetch_assoc($result)){
          echo '<tbody>
          <tr>
          <td>'.$row['Incident_Date'].'</td>
          <td>'.$row['People_name'].'</td>
          <td>'.$row['Vehicle_plate'].'</td>
          <td>'.$row['People_licence'].'</td>
          <td>'.$row['Incident_Report'].'</td>
          <td>'.$row['Offence_description'].'</td>
          <td>
          <a href="editincident.php?id=' . $row['Incident_ID'] . '" class="btn btn-outline-info">Edit</a>
          <button class="btn btn-outline-danger" onclick="confirmDelete(' . $row["Incident_ID"] . ')">Delete</button>
          </td>
          </tbody>';
        }
      }else{ 
        {
            echo "Database is empty";
        }           
        
        mysqli_close($conn);}
      
      ?> 


</table>
        </div>


      </div>
  
  </body>
</html>