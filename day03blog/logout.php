<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>
    <div id="centeredContent">
        <?php
        // session_reset();
        unset($_SESSION['blogUser']);
        ?>
        <p>You've been logged out. <a href="index.php">Click to continue</a></p>
    </div>
</body>

</html>