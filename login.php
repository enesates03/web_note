<?php

session_start();
if(isset($_SESSION['mail'])){
  header("location: index.php");
}

$mailnotfound=false;
$passnotmatched=false;

if ($_SERVER["REQUEST_METHOD"]=="POST"){
  include 'parts/dbconnect.php';
  $mail=$_POST["mail"];
  $password=$_POST["pass"];

  $sql="SELECT * FROM wn_userdata where mail='$mail'";
  $result=mysqli_query($conn,$sql);
  $num=mysqli_num_rows($result);

  if($num==1){
    while($row=mysqli_fetch_assoc($result)){
      if(password_verify($password,$row['pass'])){
        session_start();
        $_SESSION['loggedin']=true;
        $_SESSION['mail']=$mail;
        header("location: index.php");
      } else{
        $passnotmatched=true;
      }
    }
  } else{
    $mailnotfound=true;
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <link rel="stylesheet" href="theme.css">

  <title>Login Page</title>
</head>

<body>
  <?php include "parts/navbar.php";
  if($mailnotfound){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Mail not found!</strong> We don\'t recognized you, Please signup.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if($passnotmatched){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Password not matched.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  ?>
  <div class="container my-3">
  <form action="login.php" method="post">
  <h1>Login Here</h1>
  <hr>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="pass" name="pass" required>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
  </div>

  <hr>
  <div class="container" id="signupbtn">
  <button type="button" class="btn btn-outline-success"
   onclick="document.location='signup.php'">Create New Account</button>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
    crossorigin="anonymous"></script>
</body>

</html>