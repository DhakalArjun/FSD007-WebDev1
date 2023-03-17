<?php
require_once("db.php");

//print_r($_SESSION['blogUser']);
$blogUser =$_SESSION['blogUser']['userName'];

printCreateNewArticleForm($blogUser);


?>











<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article Add</title>
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
    function printCreateNewArticleForm($blogUser)
    { $loginForm = <<< LOGIN

      <h6 class="text-end mt-2 px-5 py-2 ">You are logged in as $blogUser. &nbsp;&nbsp;  <a href="">Logout</a></h6>
      <h3 class="text-center mt-1 title-form-header">Create new article</h3>


        <form class="container-fluid text-center form-as-container-article" action="login.php" method="post" enctype="multipart/form-data">
          <!-- Title -->
          <div class="row g-3 mt-2 mb-2 d-flex justify-content-center">
            <div class="col-auto">
              <label for="IdTitle" class="article-label">Title</label>
            </div>
            <div class="col-auto">
              <input type="text" name="title" id="IdTitle" class="form-control border border-dark" placeholder="This is title....">
            </div>
          </div>
          <!-- content -->
          <div class="row g-3 mt-2 mb-2  d-flex justify-content-center">
            <div class="col-auto">
              <label for="Idcontent" class="article-label">Content</label>
            </div>
            <div class="col-auto">
            <textarea name="content" id="IdContent" class="form-control border border-dark" placeholder="This is content...." requried></textarea>
            </div>
          </div>
          <!-- button and anchor tag to Register--> 
              <input type="submit" name="create" value="create" class="btn btn-outline-primary mt-2 mb-2 create-button">                
                       
        </form>
      LOGIN;
      echo $loginForm;
    }
  ?> 











  
</body>
</html>