<?php
session_start();
?>
<?php  
      $servername = "mariadb";
      $username = "root";
      $password = "rootpwd";
      $dbname = "coursework2"; 

      $conn = mysqli_connect($servername, $username, $password, $dbname);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      } 
      ?>


<html>

  <head>
    <title>Admin Fines</title>
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
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">Admin Fines</h1>
    <div class="container">
       <form method="post">
<div class="row justify-content-center align-items-center mt-4">
    <div class="col-auto">
        <input type="type" placeholder="Search Name or Vehicle Plate" name="search" class="form-control">
        </div>
        <div class="col-auto">
        <button class="btn btn-secondary" name="submit">Search</button>
       </div>
</div>
</form>
</div>

    <hr>
    <div class="container my-5">
            <table class="table table-sm table-bordered" style="text-align:center;">
                <?php

      //searching function code from https://www.youtube.com/watch?v=9ANd4KVPQtE&t=679s&ab_channel=StepbyStep
if(isset($_POST['search'])){
    $search=$_POST['search'];
    $sql="SELECT 
        Fines.Fine_ID,
        People.People_name,
        Vehicle.Vehicle_plate,
        Fines.Fine_Amount, 
        Fines.Fine_Points, 
        Incident.Incident_Report, 
        Offence.Offence_description FROM Fines JOIN Incident ON Fines.incident_ID = Incident.Incident_ID JOIN Offence ON Incident.Offence_ID = Offence.Offence_ID JOIN People ON Incident.People_ID = People.People_ID JOIN Vehicle ON Incident.Vehicle_ID = Vehicle.Vehicle_ID
         where People_name like '%$search%' or Vehicle_plate like '%$search%'";
    $result=mysqli_query($conn,$sql);
    if($result){
    if(mysqli_num_rows($result)>0){
       echo'<thead class="table-dark">
        <tr>
        <th scope="col">Name</th>
          <th scope="col">Vehicle plate</th>
          <th scope="col">Incident Report</th>
          <th scope="col">Incident description</th>
          <th scope="col">Fine Amount</th>
          <th scope="col">Fine Points</th>
          <th scope="col">Action</th>
          </tr>
        </tr>
        </thead>';
        while($row=mysqli_fetch_assoc($result)){
        echo '<tbody>
        <tr>
       <td>'.$row['People_name'].'</td>
          <td>'.$row['Vehicle_plate'].'</td>
          <td>'.$row['Incident_Report'].'</td>
          <td>'.$row['Offence_description'].'</td>
          <td>'.$row['Fine_Amount'].'</td>
          <td>'.$row['Fine_Points'].'</td>
          <td>
          <a href="admineditfine.php?id=' . $row['Fine_ID'] . '" class="btn btn-outline-info">Edit</a></td>
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
  
        <!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI-->
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

    <div class="container my-5">
    <table class="table table-sm table-bordered" style="text-align:center;">
    
      <?php  
    
        if (isset($_GET['del']) && $_GET['del'] != "") {
          $sql = "DELETE FROM Fines WHERE Fine_ID=" . $_GET['del'];
          mysqli_query($conn, $sql);
        
        }
//Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
        {

               
        $sql="SELECT 
        Fines.Fine_ID,
        People.People_name,
        Vehicle.Vehicle_plate,
        Fines.Fine_Amount, 
        Fines.Fine_Points, 
        Incident.Incident_Report, 
        Offence.Offence_description FROM Fines JOIN Incident ON Fines.incident_ID = Incident.Incident_ID JOIN Offence ON Incident.Offence_ID = Offence.Offence_ID JOIN People ON Incident.People_ID = People.People_ID JOIN Vehicle ON Incident.Vehicle_ID = Vehicle.Vehicle_ID";
    
      
        $result = mysqli_query($conn, $sql);
        }

        
        echo "<p>".mysqli_num_rows($result)." rows</p>";
        
                                            
        if (mysqli_num_rows($result) > 0){
          echo'<thead class="table-dark">
          <tr>
          <th scope="col">Name</th>
          <th scope="col">Vehicle plate</th>
          <th scope="col">Incident Report</th>
          <th scope="col">Incident description</th>
          <th scope="col">Fine Amount</th>
          <th scope="col">Fine Points</th>
          <th scope="col">Action</th>
          </tr>
          </thead>';
          while($row=mysqli_fetch_assoc($result)){
          echo '<tbody>
          <tr>
          <td>'.$row['People_name'].'</td>
          <td>'.$row['Vehicle_plate'].'</td>
          <td>'.$row['Incident_Report'].'</td>
          <td>'.$row['Offence_description'].'</td>
          <td>'.$row['Fine_Amount'].'</td>
          <td>'.$row['Fine_Points'].'</td>
          <td>
          <a href="admineditfine.php?id=' . $row['Fine_ID'] . '" class="btn btn-outline-info">Edit</a>
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
  
  </body>
</html>