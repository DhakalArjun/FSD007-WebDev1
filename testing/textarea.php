<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Document</title>
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
  tinymce.init({
    selector: 'textarea[name=body]'
  });
  </script>
</head>

<body>
  <div id="centeredContent">
    <?php       
        //
        function printForm($title = "", $body = "")
        {
            $form = <<< END
            <form method="post">
            Title: <input name="title" type="text" value="$title"><br>
            <textarea name="body" cols="60" row="10">$body</textarea><br>
            <input type="submit" value="Post article">
            </form>
            END;
            echo $form;
        }

        if (isset($_POST["title"])) { // we're receving a submission
            $title = $_POST['title'];
            $body = $_POST['body'];

            // FIXME: sanitize body - 1) only allow certain HTML tags, 2) make sure it is valid html
            // WARNING: If you forget to sanitize the body bad things may happen such as JavaScript injection
            $body = strip_tags($body, "<p><ul><li><em><strong><i><b><ol><h3><h4><h5><span><pre>");
            $title = htmlentities($title);
            $errorList = [];
            if (strlen($title) < 2 || strlen($title) > 100) {
                $errorList[] = "Title must be 2-100 characters long";
                // $title = ""; // keep even if invalid
            }
            if (strlen($body) < 2 || strlen($body) > 10000) {
                $errorList[] = "Body must be 2-10000 characters long";
                // $title = ""; // keep even if invalid
            }
            //
            if ($errorList) { // STATE 2: submission with errors
                echo '<ul class="errorMessage">' . "\n";
                foreach ($errorList as $error) {
                    echo "<li>$error</li>\n";
                }
                echo "</ul>\n";
                printForm($title, $body);
            } else { // STATE 3: success
                // get current user id from $_SESSION
                $userId = 'arjun';
                // insert the record and inform user
                // $sql = sprintf(
                //     "INSERT INTO articles VALUES (NULL, '%s', NULL, '%s', '%s')",
                //     mysqli_real_escape_string($link, $userId),
                //     mysqli_real_escape_string($link, $title),
                //     mysqli_real_escape_string($link, $body)
                // );
                // if (!mysqli_query($link, $sql)) {
                //     die("Fatal error: failed to execute SQL query: " . mysqli_error($link));
                // }
                // $articleId = mysqli_insert_id($link);
                echo "<h3>Article added</h3>";
                echo '<p><a href="article.php?id=' . $userId . '">Click here to view it</a></p>';
            }
        } else { // STATE 1: first display
            printForm();
        }

        ?>
  </div>
</body>

</html>