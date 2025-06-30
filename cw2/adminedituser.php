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
//Professor's code login: lab-8-demo-code/ineractive-5.php for insert and delete-->
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

      $id=$_GET['id'];

      $sql="SELECT username, password, username_type
      FROM username WHERE of_id='$id'";

      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_assoc($result);
      
      $username=$row['username'];
      $password=$row['password'];
      $type=$row['username_type'];


if (isset($_POST['name']) && $_POST['name'] != "" && 
    isset($_POST['password']) && $_POST['password'] != "" && 
    isset($_POST['type']) && $_POST['type'] != "") {  

      $new_name=($_POST['name']);
      $new_password=($_POST['password']);
      $new_type=($_POST['type']);

        $sql = "UPDATE username
        SET username = '$new_name', password = '$new_password', username_type = '$new_type'  WHERE of_id = '$id'";
        $result = mysqli_query($conn, $sql); 
        
        $detail = "changed password: old Username=$username, Password = $password, Type=$type change to New Username=$new_name, Password = $new_password, Type=$new_type";
              
        $ssql = "INSERT INTO history(username, type, `database`, action, detail, timestamp) 
                    VALUES ('$_SESSION[name]', '$_SESSION[username_type]', 'adminuser', 'Edit', '$detail', NOW())";

          $result = mysqli_query($conn, $ssql); 
             header("Location:adminuser.php");
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
    User Name: <input type="text" placeholder="Enter Name" name="name" class="form-control w-25" value=<?php echo $username;?>><br>
       Password: <input type="text" placeholder="Enter Password" name="password" class="form-control w-25" value=<?php echo $password;?>><br>
      User Type:
    <select class="form-select w-25" aria-label="Default select example" name="type" value=<?php echo $offence;?>>
        <option selected>Choose an option</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <br>
       <input type="submit" value="update" class="btn btn-primary mb-2">
</div>
</div>
</form>
      </body>
      </html>