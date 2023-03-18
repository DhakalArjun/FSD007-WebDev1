<?php
require_once("db.php");


//print_r($_SESSION['blogUser']);
$blogUser =$_SESSION['blogUser']['userName'];

if(isset($_POST['create'])){
  $title=$_POST['title'];
  $body=$_POST['content'];
  $errors = [];


}else{
  printArticleForm();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article Add</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>


  <?php
    function printArticleForm($articleId="",$userId="", $creationTime="",$title="",$content="")
    { $articleForm = <<< LOGIN

      <h6 class="text-end mt-2 px-5 py-2 ">You are logged in as $userId. &nbsp;&nbsp;  <a href="">Logout</a></h6>
      <h3 class="text-center mt-1 title-form-header">$articleId</h3>
      <p class="text-center mt-1 title-form-header">$title</p>
      <div class="text-center mt-1 title-form-header">$content</div>

        <form class="container-fluid text-center form-as-container-article" action="" method="post" enctype="multipart/form-data">
          
          <!-- Add comment -->
          <div class="row g-3 mt-2 mb-2  d-flex justify-content-center">
            <div class="col-auto">
              <label for="IdAddComment" class="article-label">Content</label> <br>
              <!-- button and anchor tag to Register--> 
              <input type="submit" name="create" value="Add comment" class="btn btn-outline-primary mt-2 mb-2 create-button">   
            </div>
            <div class="col-auto">
            <textarea name="content" id="IdAddComment" class="form-control border border-dark" placeholder="This is content...." requried>$content</textarea>
            </div>
          </div>                 
                       
        </form>
      LOGIN;
      echo $articleForm;
    }
  ?>
</body>

</html>