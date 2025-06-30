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
    <title>user</title>
    <!--How to Make Login Form in PHP and MySQL: https://youtu.be/JDn6OAMnJwQ?si=WiMfIIUuSG4Djzef-->
    <style>
        
        
        * {
            font-family: sans-serif;
            box-sizing: border-box;
        }
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;    
            
            padding: 20px;
        }

        form {
        width: 500px;
        border: 2px solid #ccc;
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        text-align: center;
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
          <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

<h1 style="font-family:fantasy;text-align:center; font-size: 1.5cm;" class="mt-3">User</h1>

<div class="form-container">
<form>
    <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
        <label for="username" style="font-weight: bolder;">User Name:</label>
        <span><?php echo $_SESSION['name']; ?></span>
    </div>

   
    <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
        <label for="password" style="font-weight: bolder;">Password:</label>
        <span><?php echo $_SESSION['password']; ?></span>
    </div>

    
    <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
        <label for="username_type" style="font-weight: bolder;">User Type:</label>
        <span><?php echo $_SESSION['username_type']; ?></span>
    </div>

    <a href="edituser.php?id=<?php echo $_SESSION['of_id']; ?>"
        class="btn btn-outline-info" style="font-size: 16px;">Edit</a>
</form>

    </div>
  
  </body>
</html>