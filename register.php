<?php
require_once "config.php";
$username=$password=$confirm_password="";
$username_err=$password_err=$confirm_password_err="";

if($_SERVER['REQUEST_METHOD']=="POST")
{
    //check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err="Username cannot be blank"; 
    }
    else{
        $sql="SELECT id from users WHERE username=?";
        $stmt=mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"s",$param_username);
            // set the value of param username
            $param_username=trim($_POST['username']);

            //Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                 mysqli_stmt_store_result($stmt);
                 if(mysqli_stmt_num_rows($stmt)==1){
                     $username_err="This username is already taken";
                 }
                 else{
                     $username=trim($_POST['username']);
                 }
            }
            else{
                echo 'something went wrong!';
            }
        }
        
    }
   mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err="Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])<5)){
    $password_err="Password cannot be less than 5 character";
}
else{
    $password= trim($_POST['password']);
}

// confirm password field
if(trim($_POST['password']) != trim($_POST['confirm_password'])){
    $password_err="Password should match";
}


// if there is no error  an insert data into databse
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
    $sql="INSERT INTO users(username,password) VALUES (?,?)";
    $stmt= mysqli_prepare($conn, $sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"ss",
        $param_username, $param_password);
        // set these parameters 
        $param_username= $username;
        $param_password= password_hash($password, PASSWORD_DEFAULT);

        // try to execute the query
        if(mysqli_stmt_execute($stmt)){
           header("Location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>






<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Php Login System!</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Php Login System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h3> Register here:</h3><hr>
    <form class="row g-3" method="post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Username</label>
    <input type="text"  name="username" class="form-control" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password"  name="password" class="form-control" id="inputPassword4">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name="confirm_password" id="inputPassword" placeholder="1234 Main St">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form></div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>