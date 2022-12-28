<?php
session_start();

include_once(__DIR__ . "/../elements/header/header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/styles.css">

  <title>Account</title>
</head>

<body>
  <div id="container">
    <header-custom></header-custom>
    <div id="content">
      <div class="flex-column flex-align-centre">
        <?php if (!isset($_SESSION["signedIn"])) { ?>
          <h1>Please sign in to continue</h1>

          <div>
            <h5>Sign in</h5>
            <form method="post" action="actions/sign_in.php" autocomplete="off">
              <span class="fas fa-user"></span>
              <input name="username" required minlength="3" maxlength="255" />

              <span class="fas fa-lock"></span>
              <input name="password" type="password" required minlength="5" maxlength="255" autocomplete="off" />

              <button type="submit">Sign in</button>
            </form>
          </div>
        <?php } else { ?>
          <h1>You are already signed in</h1>
        <?php } ?>
      </div>
    </div>

    <footer-custom></footer-custom>
  </div>

  <script src="../elements/header/headerLink.js"></script>
  <script src="../elements/footer/footer.js"></script>
</body>

</html>