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
<!--Bootstriap CSS all for card-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_page</title>
    <style>
.button {
           display: grid;
           place-items: center;
        }
  
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body style="background-color:#92a8d1;">
<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">Welcome, <?php echo $_SESSION['username_type']; ?> <?php echo $_SESSION['name']; ?>!</h1>
<div class="button">
<a href="logout.php" class="btn btn-outline-danger">Logout</a>
</div>
<hr>
<div class="row row-cols-1 row-cols-md-3 g-4 mx-4">
  <div class="col">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">About User Edit</h5>
        <p class="card-text">This is for verifying your username, password, and user type. You can also change your password.</p>
        <a href="newuser.php" class="btn btn-primary">Edit</a>  
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Searching Information</h5>
        <p class="card-text">This area allows you to search, add, delete, and edit traffic information. </p>
        <a href="newpeople.php" class="btn btn-primary">searching</a>
      </div>
    </div>
  </div>
  <!--user and admin login system: https://blog.mackliu.com/archives/356-->
<?php
  if ($_SESSION['username_type'] == 'admin') {
?>
    <div class="col">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Administrator</h5>
          <p class="card-text">This is for manages users, adds fine amounts and points, and maintains history.</p>
          <a href="adminuser.php" class="btn btn-primary">Edit or View</a>
        </div>
      </div>
    </div>
<?php
  }
?>
  
</div>
</body>
</html>