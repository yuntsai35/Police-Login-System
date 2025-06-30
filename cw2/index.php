<?php

session_start();


//User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI
// and index of css are from User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI

$servername = "mariadb";
      $username = "root";
      $password = "rootpwd";
      $dbname = "coursework2"; 

      $conn = mysqli_connect($servername, $username, $password, $dbname);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      } 

if(isset($_POST['submit'])){
    $name=($_POST['name']);
    $pass=($_POST['password']);
     
    $select="SELECT * FROM username WHERE username ='$name' && password='$pass'";
    $result= mysqli_query($conn,$select);
    if(mysqli_num_rows($result)>0){
     
       $row= mysqli_fetch_array($result);
       $_SESSION['of_id'] = $row['of_id'];
       $_SESSION['name'] = $row['username'];
       $_SESSION['password'] = $row['password'];
       $_SESSION['username_type'] = $row['username_type'];

        header('location:login.php');

    }else{
        $error[]='Incorrect username or password!';
    }
};
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>

    <!---custom css file-->
    <link rel="stylesheet" href="index.css">

</head>
<body>
    <div class="form-container">
       <form action="" method="post">
        <h1>Police Traffic System Login</h1>
        <?php
        if (isset($error)){
            foreach($error as $error){
                echo'<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>
        <br><label for="">User Name</label>
        <input type="text" name="name" required placeholder="Enter your name"><br>
        <label for="">Password</label>
        <input type="text" name="password" required placeholder="Enter your password"><br>
        <input type="submit" name="submit" value="login now" class="form-btn"> 
    
    </form> 
    </div>
    
</body>
</html>