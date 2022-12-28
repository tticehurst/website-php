<?php
session_start();

$inc = include_once(__DIR__ . "/../includes/access_check.php");
$inc(255);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/styles.css">

  <title>Document</title>
</head>

<body>
  <h1>Test page</h1>
</body>

</html>