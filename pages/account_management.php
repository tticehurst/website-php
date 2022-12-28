<?php
session_start();

if (!isset($_SESSION["signedIn"])) {
  header("Location: /pages/index.php");
  die();
}

include_once(__DIR__ . "/../elements/header/header.php");
include_once(__DIR__ . "/../includes/db.php");
include_once(__DIR__ . "/../includes/get_accounts.php");

$getAccessLevel = include(__DIR__ . "/../includes/get_access.php");
$userLevel = $getAccessLevel($_SESSION["username"]);

$modifyAccountLevel = 105;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/styles.css">

  <title>Account management</title>
</head>

<body>
  <div id="container">
    <header-custom></header-custom>
    <div id="content">
      <?php if ($userLevel >= $modifyAccountLevel) { ?>
        <div class="flex-column flex-align-centre">
          <fieldset>
            <legend>Modify user</legend>

            <form action="actions/user_search.php" method="POST">
              <input name="username" required autocomplete="off">
              <button type="submit">Find user</button>
            </form>

            <?php if (isset($_SESSION["returnedData"])) { ?>
              <table>
                <tr>
                  <?php
                  foreach ($_SESSION["returnedData"] as $key => $value) {
                    echo "<th>$key</th>";
                  }
                  ?>
                </tr>
                <tr>
                  <?php
                  foreach ($_SESSION["returnedData"] as $value) {
                    echo "<td>$value</td>";
                  }
                  ?>
                </tr>
              </table>

              <div class="flex-column flex-align-centre">
                <h4>Modify user</h4>
                <form method="POST" action="actions/modify_account.php" class="flex-column flex-align-centre">
                  <input type="hidden" name="username" value=<?= $_SESSION["returnedData"]["username"]; ?>>
                  <div>
                    <label for="accessLevel">Access level:</label>
                    <input class="input-small margin-bottom-small" name="accessLevel" type="number" min=0 max=255 placeholder="0" autocomplete="off">
                  </div>

                  <?php if ($userLevel >= 255) { ?>
                    <div>
                      <label for="locked">Locked:</label>
                      <input class="input-small margin-bottom-small" name="locked" type="number" min=0 max=1 placeholder="0" autocomplete="off">
                    </div>
                  <?php } ?>

                  <br />
                  <button type="submit">Modify user</button>
                </form>
              </div>
          </fieldset>
        <?php }
            unset($_SESSION["returnedData"]);
        ?>
        </div>


        <?php if ($userLevel >= 200) { ?>
          <div class="flex-column flex-align-centre" style="margin-top: 25px;">
            <form method="post" action="actions/create_account.php" autocomplete="off">
              <fieldset>
                <legend>Create account</legend>


                <span class="fas fa-user"></span>
                <input name="username" required minlength="3" maxlength="255" />

                <span class="fas fa-lock"></span>
                <input name="password" type="password" required minlength="5" maxlength="255" autocomplete="off" />

                <button type="submit">Create account</button>
              </fieldset>
            </form>
          </div>

          <div class="flex-column flex-align-centre" style="margin-bottom: 15px;">
            <fieldset>
              <legend>Accounts</legend>

              <div>
                <?php if (isset($_GET["getAccounts"])) {
                  $accounts = $getAccounts();
                ?>
                  <div class="flex-column">
                    <?php foreach ($accounts as $account) { ?>
                      <div id="accountItem" class="flex-row">
                        <form method="POST" action="./actions/delete_account.php">
                          <?php echo "<span>" . $account["username"] . "</span>"; ?>
                          <button type="submit">Delete</button>
                        </form>
                      </div>
                    <?php } ?>
                  </div>
                <?php } ?>

              </div>

              <form method="GET" style="text-align: center">
                <input type="hidden" name="getAccounts">
                <button type="submit" style="margin-top: 20px;">Get accounts</button>
              </form>
            </fieldset>
          </div>
        <?php } ?>
      <?php } ?>

      <div class="flex-column flex-align-centre">
        <form method="POST" action="./actions/reset_password.php">
          <fieldset>
            <legend>Reset password</legend>

            <input type="hidden" name="username" value=<?= $_SESSION["username"] ?>>
            <input type="password" name="newPassword" minlength="5" maxlength="255" autocomplete="off" required>

            <button type="submit">Reset password</button>
          </fieldset>
        </form>
      </div>
    </div>
    <footer-custom></footer-custom>
  </div>

  <script src="../elements/header/headerLink.js"></script>
  <script src="../elements/footer/footer.js"></script>
</body>

</html>