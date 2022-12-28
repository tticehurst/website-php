<?php
session_start();
header("Location: /pages/account.php");

include_once(__DIR__ . "/../../includes/db.php");

if (isset($_SESSION["signedIn"]) && isset($_POST["newPassword"])) {
  if (strlen(trim($_POST["newPassword"])) <= 0) {
    $_SESSION["message"] = "Please specify a non-empty password";
  } else {
    $userPassword = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);

    $query = $connection->prepare("UPDATE accounts SET password=? WHERE BINARY username=?");
    $query->execute([$userPassword, $_SESSION["username"]]);

    $_SESSION["message"] = "Password changed";
    unset($_SESSION["signedIn"], $_SESSION["username"]);
  }
}
