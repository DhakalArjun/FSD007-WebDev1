<?php
  require_once('db.php');
  $targetDir = "uploads/";
  $acceptableFileFormats = ['jpg', 'gif', 'png'];
 
  
  if(isset($_POST['submit'])){  //if submit button is clicked, 'submit' here -> name attribute of the button.   
    $passportNo = $_POST['passportNo']; // 'passportNo' here -> name attribute of input for passport number   
    $fileName = $_FILES['ImageToUpload']['name'];  

    // $fileType = $_FILES['ImageToUpload']['type'];   -> This gives image/jpeg      
    //$fileFormat = strtolower(end(explode('.',$fileName)));  //Notice: Only variables should be passed by reference in C:\xampp\htdocs\fsd07-php\day01hello\7addpassport.php on line 12
    $fileNameExplode = explode('.',$fileName);
    $fileExtention = end($fileNameExplode);
    $fileFormat = strtolower($fileExtention); 
   
    //$fileFormat = strtolower(end(explode('.',$fileName)));
    $targetFileName = $passportNo.".".$fileFormat;    
    $errors = [];

    // To check passport number condition : [a-zA-Z]{2}[0-9]{6}
    // if(!preg_match('/^(?=[A-Z]{2})(?=[0-9]{6})', $passportNo)){
    //   $errors[]="Passport number should have two uppercase letter followed by exactly 6 numbers.";
    // }


     //To check file format 
    if(!in_array($fileFormat,$acceptableFileFormats)){
      $errors[]="File format of image selected  is not allowed, please choose a JPG or GIF or PNG file.";
    }

    //To check file size: 
    $fileSize = $_FILES['ImageToUpload']['size'];  
    if($fileSize > 2097152){                        // 2 MB = 1048576 bytes * 2 = 2097125 bytes
        $errors[]='Sorry your file is too large, maximum file size is 2 MB';
    }

    // to check if file already exists
    if(file_exists( "uploads/".$targetFileName)){
      $errors[]='Sorry, file already exists.';      
    }

    if(!$errors){    
      move_uploaded_file($_FILES["ImageToUpload"]["tmp_name"],"uploads/".$targetFileName);

      //full path of the file uploaded      
      $fullPath = getcwd()."\uploads\\".$targetFileName;      
      //echo $fullPath ;

      $sqlStr = sprintf("INSERT INTO passports (passportNo, photoFilePath) VALUES ( '%s', '%s')",
      //Note: we don't need to use quotes for column names.
      mysqli_real_escape_string($con, $passportNo),
      mysqli_real_escape_string($con, $fullPath)     
      );
      // echo $sqlStr;

      $queryResult = mysqli_query($con, $sqlStr);
      if(!$queryResult){
        die("Fatal error: failed to execute SQL query: " . mysqli_error($con));
      }
      echo "File uploaded succesfully!! ";
    }else{
      echo "<p> Submission failed, error found: </p>\n";
      echo "<ul>";
      foreach($errors as $error){
        echo "<li>$error</li>";
      }
      echo "</ul>";    
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="containter-fluid align-items-center">
      <form class="container mt-3" action="7addpassport.php" method="post" enctype="multipart/form-data">
        <div class="mb-4 col-6">
          <label for="passportNumber" class="form-label">Passport Number</label>
          <input type="text" name="passportNo"class="form-control" id="passportNumber" />
          <span class="form-text">
            Passport number must be composed of two uppercase letters followed
            by 6 digits exactly.
          </span>
        </div>

        <div class="col-6">
          <label for="filePath" class="form-label">Upload ImageToUpload</label>
          <input type="file" name="ImageToUpload" class="form-control" id="filePath" />
          <span class="form-text">
            ImageToUploads uploaded must be: <br />
            <li>One of these formats: jpg, gif, png</li>
            <li>Width and height must be within 200-1000 pixels range</li>
            <li>Size not larger than 2MB</li>
          </span>
        </div>
        <button type="submit" name="submit" value="Upload Image" class="btn btn-primary mt-3">Submit</button>
      </form>
    </div>
  </body>
</html>

<!-- Note: (Some rules to follow for the HTML form to upload file)
- Make sure that the form uses method="post"
- The form also needs attribute: enctype="multipart/form-data". It specifies which content-type to use when submitting the form,
  without specifying this, the file upload will not work. 
- action ="7addpassport.php" -> Above html form sends data by calling php code on top of this file
-->