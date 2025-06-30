<?php
session_start();
?>
<html>

  <head>
    <title>Admin user</title>
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
 <h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">Admin User</h1>

 <form method="post">
  <div class="row justify-content-center align-items-center">
    <div class="col-auto">
       Username: <input type="text" placeholder="username" name="username" class="form-control mb-2 mr-2">
    </div>
    <div class="col-auto">
       Password: <input type="text" placeholder="password" name="password" class="form-control mb-2 mr-2">
    </div>
    <div class="col-auto">
       <input type="submit" value="Add" class="btn btn-primary mb-2">
    </div>
  </div>
 </form>

    <hr>

    <div class="container my-5">
            <table class="table table-sm table-bordered" style="text-align:center;">
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
    <!-- Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
      <?php  
      $servername = "mariadb";
      $username = "root";
      $password = "rootpwd";
      $dbname = "coursework2"; 

      $conn = mysqli_connect($servername, $username, $password, $dbname);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      } 
        
        
                                                 
        if (isset($_POST['username']) && $_POST['username'] != "" && 
        isset($_POST['password']) && $_POST['password'] != "") { 
    
        $username_check = $_POST['username'];
    
        
        $username_check_sql = "SELECT of_id FROM username WHERE username = '$username_check'";
        $username_result = mysqli_query($conn, $username_check_sql);
    
        if (mysqli_num_rows($username_result) > 0) {
            
            echo "Username already exists.";
        } else {
            
            $sql = "INSERT INTO username (username, password) VALUES ('".$_POST['username']."','".$_POST['password']."');";
            echo "sql=" . $sql . "<br/>";
    
            
            if (mysqli_query($conn, $sql)) {
                $username_id = mysqli_insert_id($conn);
    
                
                $query = "SELECT username, password, username_type FROM username WHERE of_id = '$username_id'";
                $result = mysqli_query($conn, $query);
    
                if ($row = mysqli_fetch_assoc($result)) {
                    $username = $row['username'];
                    $password = $row['password'];
                    $type = $row['username_type'];
    
                    
                    $detail = "Insert record: Username = $username, Password = $password, Type = $type";
    
    
                    $ssql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
                             VALUES ('$_SESSION[name]', '$_SESSION[username_type]', 'adminuser', 'Insert', '$detail', NOW())";
                    mysqli_query($conn, $ssql);
                }
            }
        }
    }
    
          
        
       // Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
        if (isset($_GET['del']) && $_GET['del'] != "") {
          $sql = "SELECT * FROM username WHERE of_id=" . $_GET['del'];
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $username = $row['username'];
              $password = $row['password'];
              $type = $row['username_type'];  
              $detail = "Deleted record: Username = $username, Password = $password, Type = $type";
              
              $ssql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
                          VALUES ('$_SESSION[name]', '$_SESSION[username_type]', 'adminuser', 'Delete', '$detail', NOW())";
              

              mysqli_query($conn, $ssql);
              
              $sqlDelete = "DELETE FROM username WHERE of_id=" . $_GET['del'];
              if (mysqli_query($conn, $sqlDelete)) {
              }
          } else {
              echo "Record not found!";
          }
      }

        
        
        
        //Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
        $sql = "SELECT * FROM username ORDER BY username;";
      
        
        $result = mysqli_query($conn, $sql);
        
        
        
        echo "<p>".mysqli_num_rows($result)." rows</p>";
        
                                      
        if (mysqli_num_rows($result) > 0) 
        {
          echo'<thead class="table-dark">
          <tr>
          <th scope="col">Username</th>
          <th scope="col">Password</th>
          <th scope="col">Type</th>
          <th scope="col">Action</th>
          </tr>
          </thead>';
          while($row=mysqli_fetch_assoc($result)){
          echo '<tbody>
          <tr>
          <td>'.$row['username'].'</td>
          <td>'.$row['password'].'</td>
          <td>'.$row['username_type'].'</td>
          <td>
          <a href="adminedituser.php?id=' . $row['of_id'] . '" class="btn btn-outline-info">Edit</a>
          <button class="btn btn-outline-danger" onclick="confirmDelete(' . $row["of_id"] . ')">Delete</button>
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
  
  </body>
</html>