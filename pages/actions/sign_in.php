<?php
session_start();
header("Location: /pages/account.php");

include_once(__DIR__ . "/../../includes/db.php");

if (!isset($_SESSION["signedIn"])) {
  $query = $connection->prepare("SELECT username,password FROM accounts WHERE BINARY username=?");
  $query->execute([$_POST["username"]]);

  if ($query->rowCount() == 1) {
    $savedDetails = $query->fetchAll();
    if (password_verify($_POST["password"], $savedDetails[0]["password"])) {
      session_regenerate_id();

      $_SESSION["username"] = $_POST["username"];
      $_SESSION["signedIn"] = true;

      $_SESSION["message"] = "Signed in";
    } else {
      $_SESSION["message"] = "Incorrect password";
    }
  } else {
    $_SESSION["message"] = "Account does not exist";
  }
} else {
  $_SESSION["message"] = "Already signed in";
}
