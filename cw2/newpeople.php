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
    <title>People</title>
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
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">People</h1>
    <div class="container">
       <form method="post">
<div class="row justify-content-center align-items-center mt-4">
    <div class="col-auto">
        <input type="type" placeholder="Search name or lisence number" name="search" class="form-control">
        </div>
        <div class="col-auto">
        <button class="btn btn-secondary" name="submit">Search</button>
       </div>
       <div class="col-auto">
       <a class="btn btn-outline-dark" href="updatepeople.php" role="button">Add new people information</a>
       </div>
</div>
</form>
</div>

    <hr>
  
    <div class="container my-5">
      <table class="table table-sm table-bordered" style="text-align:center;">
<!--searching information code from https://www.youtube.com/watch?v=9ANd4KVPQtE&t=679s&ab_channel=StepbyStep-->
     <?php
    if(isset($_POST['submit'])){
       $search=$_POST['search'];
       $sql="Select * from `people` where People_name like '%$search%' or People_licence like '%$search%'";
       $result=mysqli_query($conn,$sql);
       if($result){
       if(mysqli_num_rows($result)>0){
         echo'<thead class="table-dark">
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Address</th>
        <th scope="col">Licence</th>
        <th scope="col">Action</th>
        </tr>
        </thead>';
        while($row=mysqli_fetch_assoc($result)){
        echo '<tbody>
        <tr>
        <td>'.$row['People_name'].'</td>
        <td>'.$row['People_address'].'</td>
        <td>'.$row['People_licence'].'</td>
        <td><button class="btn btn-outline-danger" onclick="confirmDelete(' . $row["People_ID"] . ')">Delete</button></td>
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

      <div class="container my-5">
      <table class="table table-sm table-bordered" style="text-align:center;">
      <!-- Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
        <?php  

        if (isset($_GET['del']) && $_GET['del'] != "") {
          $sql = "SELECT * FROM People WHERE People_ID=" . $_GET['del'];
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $name = $row['People_name'];
              $address = $row['People_address'];
              $licence = $row['People_licence'];
              $detail = "Deleted record: Name = $name, Address = $address, Licence = $licence";
              
              $ssql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
                          VALUES ('$_SESSION[name]', '$_SESSION[username_type]', 'People', 'Delete', '$detail', NOW())";
              

              mysqli_query($conn, $ssql);
              
              $sqlDelete = "DELETE FROM People WHERE People_ID=" . $_GET['del'];
              if (mysqli_query($conn, $sqlDelete)) {
              }
          } else {
              echo "Record not found!";
          }
      }

       // Professor's code login: lab-8-demo-code/ineractive-5.php
        {

      
        $sql = "SELECT * FROM People ORDER BY People_name;";
      
      
        $result = mysqli_query($conn, $sql);
        }

        
        echo "<p>".mysqli_num_rows($result)." rows</p>";
        
                                            
        if (mysqli_num_rows($result) > 0){
          echo'<thead class="table-dark">
          <tr>
          <th scope="col">Name</th>
          <th scope="col">Address</th>
          <th scope="col">Licence</th>
          <th scope="col">Action</th>
          </tr>
          </thead>';
          while($row=mysqli_fetch_assoc($result)){
          echo '<tbody>
          <tr>
          <td>'.$row['People_name'].'</td>
          <td>'.$row['People_address'].'</td>
          <td>'.$row['People_licence'].'</td>
          <td>
          <button class="btn btn-outline-danger" onclick="confirmDelete(' . $row["People_ID"] . ')">Delete</button>
          </td>
          </tbody>';
        }
      }else{ 
        {
            echo "Database is empty";
        }           
        
        mysqli_close($conn);}
      
      ?> 

      
      </div>
      </table>
    </div>
  
  </body>
</html>