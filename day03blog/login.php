<?php
require_once("db.php");



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
    <link href="css/styles.css" rel="stylesheet"/>
  </head>
  <body>    
    <h3 class="text-center mt-5 mb-5">User login</h3>
      <form class="container text-center border border-dark form-as-container" action="login.php" method="post" enctype="multipart/form-data">
        <!-- username -->
        <div class="row g-3 mt-2 mb-2 d-flex justify-content-center">
          <div class="col-auto">
            <label for="IdUserName" class="col-form-label">Username</label>
          </div>
          <div class="col-auto">
            <input type="text" name="userName" id="IdUserName" class="form-control">
          </div>
        </div>
        <!-- password -->
        <div class="row g-3 mt-2 mb-2  d-flex justify-content-center">
          <div class="col-auto">
            <label for="IdPassword" class="col-form-label">Password</label>
          </div>
          <div class="col-auto">
            <input type="password" id="IdPassword" class="form-control" aria-describedby="passwordHelpInline">
          </div>
        </div>
        <!-- button and anchor tag to Register--> 
            <input type="submit" name="login" value="Login" class="btn btn-outline-dark mt-2 mb-2">                      
            <p><a href="#">No account? Register here</a></p>          
      </form> 
  </body>
</html>