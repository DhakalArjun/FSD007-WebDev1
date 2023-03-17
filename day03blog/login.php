<?php
require_once("db.php");

if(isset($_POST['login'])){
  $username = $_POST['userName'];
  $password= $_POST['password'];

  $sqlStr = sprintf("SELECT * FROM users WHERE userName='%s'", mysqli_real_escape_string($con, $username));  
  $result = mysqli_query($con, $sqlStr);
  //print_r($result);

  if(!$result){
    die("SQL Query Failed: " .mysqli_errno($con));
  }
  $userDetails = mysqli_fetch_assoc($result);
  //print_r($userDetails);
  $caseLoginSuccessful = ($userDetails !=null)&&($userDetails['userPassword']===$password);

  if(!$caseLoginSuccessful){    
    printLoginForm();
    echo '<h6 class="error-msg">Invalid username or password</h6>';
  } else {

    unset($userDetails['password']); //for security reason erase password element from associative array of user details
    $_SESSION['blogUser'] = $userDetails; // declaring a session variable to store user detail except password
    echo '<div class="success-div"><h4 class="success-para">Login Successful</h4><br><a href="articleadd.php" class="continue-link btn btn-outline-primary">Click here to continue</a></div>';    
  }
}else{
  printLoginForm();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/styles.css" />   
  </head>
  <body>
  <?php
    function printLoginForm()
    { $loginForm = <<< LOGIN
      <h3 class="text-center mt-5 mb-5">User login</h3>
        <form class="container text-center border border-dark form-as-container-login" action="login.php" method="post" enctype="multipart/form-data">
          <!-- username -->
          <div class="row g-3 mt-2 mb-2 d-flex justify-content-center">
            <div class="col-auto">
              <label for="IdUserName" class="col-form-label">Username</label>
            </div>
            <div class="col-auto">
              <input type="text" name="userName" id="IdUserName" class="form-control" required>
            </div>
          </div>
          <!-- password -->
          <div class="row g-3 mt-2 mb-2  d-flex justify-content-center">
            <div class="col-auto">
              <label for="IdPassword" class="col-form-label">Password</label>
            </div>
            <div class="col-auto">
              <input type="password" name="password" id="IdPassword" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>
          </div>
          <!-- button and anchor tag to Register--> 
              <input type="submit" name="login" value="Login" class="btn btn-outline-primary mt-2 mb-2">                      
              <p><a href="register.php">No account? Register here</a></p>          
        </form>
      LOGIN;
      echo $loginForm;
    }
  ?> 
  </body>
</html>