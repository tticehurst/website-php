<?php
session_start();

include_once(__DIR__ . "/../includes/signinCheck.php");
include_once(__DIR__ . "/../elements/header/header.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/styles.css">

  <title>Homepage</title>
</head>

<body>
  <div id="container">
    <header-custom></header-custom>
    <div id="content">
      <h1>Work in Progress</h1>
    </div>
    <footer-custom></footer-custom>
  </div>

  <script src="../elements/header/headerLink.js"></script>
  <script src="../elements/footer/footer.js"></script>
</body>

</html>