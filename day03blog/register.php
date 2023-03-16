<?php
require_once("db.php");

if(isset($_POST['register'])){
  $desiredUserId = $_POST["desiredUserName"];
  $userEmail = $_POST["emailAddress"]; 
  $password = $_POST["password"]; 
  $passwordRepeat = $_POST["passwordRepeat"];

  $errors =[];
  
  //check is user name start with any lowercase letter and between 4-20 characters long
  if(preg_match('/^[a-z][a-z0-9_]{3,19}$/', $desiredUserId) !==1){
    $errorList[] = "User name mus start with lowercase letters and be 4-20 characters in length";
  }
  else
  {
    $checkSqlStr = sprintf("SELECT * FROM users WHERE userName='%s'",
    mysqli_real_escape_string($con, $desiredUserId));
    $result = mysqli_query($con, $checkSqlStr); 

    if(!$result){
      die("Fatal error: failed to execute SQL query: " . mysqli_error($con));
    }
    $userRecord = mysqli_fetch_assoc($result);
    if ($userRecord){
      $errors[]="The user name " . $desiredUserId . " already exist !";
      $desiredUserId="";      
    }
  } 
  //Password must be at least 6 characters long and must contain at least one uppercase letter, one lower case letter, 
  //and one number or special character. It must not be longer than 100 characters. Passwords must match for the user to be created.
  //1. at least one lower case letter
  if(!mysqli_num_rows($result) and !preg_match('/[a-z]{1,}/',$password)){
    $errors[]="Password must containg at least one lower case letters";
  }
  //2. at least one upper case letter.
  if(!preg_match('/[A-Z]{1,}/',$password)){
    $errors[]="Password must containg at least one upper case letters";
  }
  //3. at least one number
  if(!preg_match('/[0-9]+/',$password)){
    $errors[]="Password must containg at least one number";
  }
  //4. at least one special character
  if(!preg_match('/[*@!#%&()^~{}]+/',$password)){
    $errors[]="Password must containg at least one special character";
  }
  //5. length of password must be within 6 to 100 character
  if(strlen($password)<6 || strlen($password)>100){
    $errors[]="Password must be at least 6 character long and not longer than 100 characters";
  }
  //6. Both passwords must match;
  if($password !== $passwordRepeat){
    $errors[]="Both passwords must match exactly";
  }
  //email address format check: ^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z]{2,})$
  if(preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z]{2,})$/',$userEmail) != 1){
    $errors[]="Please verify your email address, it didn't match standard format.";
    $userEmail="";
  }

  // if there is no error register
  if(!$errors){ 
    $sqlStr = sprintf("INSERT INTO users (userName, userEmail, userPassword) VALUES ('%s', '%s', '%s')",
    //Note: we don't need to use quotes for column names.
    mysqli_real_escape_string($con, $desiredUserId),
    mysqli_real_escape_string($con, $userEmail),
    mysqli_real_escape_string($con, $password)     
    );
    //echo $sqlStr;
    $queryResult = mysqli_query($con, $sqlStr);
    if(!$queryResult){
      die("Fatal error: failed to execute SQL query: " . mysqli_error($con));
    }
    displaySuccessMessage($desiredUserId);     
  }  
  else {
    //print form
    printRegisterForm($desiredUserId,$userEmail);
    // and display erorrs
    $errorHeader = "<p>Registration failed, error occured</p>";
    displayErrorHeader($errorHeader);
    foreach($errors as $error){          
    displayErrorMessage($error);
    }
  }
}
else
{
  printRegisterForm();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link href="css/styles.css" rel="stylesheet"/>
  </head>
  <body id="register-page">
    <?php
    function printRegisterForm($user="", $email="")
    {
      $registerForm = <<< REGFORM
    
      <h3 class="text-center mt-3 mb-3">New User registration</h3>
        <form class="container text-center border border-dark form-as-container" action="register.php" method="post" enctype="multipart/form-data">
          <!-- username -->
          <div class="row g-3 mt-2 mb-2 d-flex justify-content-center">
            <div class="col-auto label-wrapper">
              <label for="IdDesiredUserName" class="col-form-label">Desired username</label>
            </div>
            <div class="col-auto ">
              <input type="text" name="desiredUserName" id="IdDesiredUserName" class="form-control" value="$user" required>
            </div>            
          </div>
          <!-- username -->
          <div class="row g-3 mt-2 mb-2 d-flex justify-content-center">
            <div class="col-auto label-wrapper">
              <label for="Idemail" class="col-form-label">Your email</label>
            </div>
            <div class="col-auto ">
              <input type="text" name="emailAddress" id="Idemail" class="form-control" value="$email" required>
            </div>
          </div>
          <!-- password -->
          <div class="row g-3 mt-2 mb-2  d-flex justify-content-center">
            <div class="col-auto label-wrapper">
              <label for="IdPassword" class="col-form-label">Password</label>
            </div>
            <div class="col-auto ">
              <input type="password" name="password" id="IdPassword" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>
          </div>
          <!-- password repeat -->
          <div class="row g-3 mt-2 mb-2  d-flex justify-content-center">
            <div class="col-auto label-wrapper">
              <label for="IdPasswordRepeat" class="col-form-label">Password (repeat)</label>
            </div>
            <div class="col-auto">
              <input type="password" name="passwordRepeat"  id="IdPasswordRepeat" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>
          </div>
          <!-- button and anchor tag to Register--> 
              <input type="submit" name="register" value="Register !" class="btn btn-outline-dark mt-2 mb-2" >  
        </form> 
        <div class="row g-3 mt-2 mb-2 justify-content-center">
            <div class="col-auto ">
            <h6>Note: </h6>
            <li> User name must be 4 to 20 characters long.</li>
            <li> User name must only consist of lower case letters and numbers. </li>
            <li> Password must be at least 6 characters long </li>
            <li> Password must contain at least one uppercase letter, one lower <br> case letter, and one number or special character.</li> 
            <li> Password must not be longer than 100 characters </li> 
            </div>            
          </div>
      REGFORM;
      echo $registerForm;
    }  
    function displaySuccessMessage(){
      $successMsg = <<< MSG
        <div class="row g-3 mt-2 mb-2 justify-content-center">
        <form action="login.php" class="mb-4 col-auto">           
            <h4 class="success-message">You have successfully registered</h4> 
            <input type="submit" name="goToLogin" value="Go To Login Page" class="btn btn-primary mt-3">
          </form>             
        </div>        
      MSG;
      echo $successMsg;        
    }
    function displayErrorHeader($headerStr){                
      $headerStr = <<< HSTR
        <div class="row g-3 mt-2 mb-2 d-flex justify-content-center">                         
            <h4 class="error-tag bg-warning">$headerStr</h4> 
        </div>
        HSTR;
      echo $headerStr;               
    }    
    function displayErrorMessage($err){              
      $errorMsg = <<< MSG
        <div class="row g-3 d-flex justify-content-center">  
        <div class="col-auto bg-warning">                  
            <li class="error-li">$err</li>                            
        </div>
        </div>
      MSG;
      echo $errorMsg;               
    }
    ?>
    <script hrf=""></script>
  </body>
</html>