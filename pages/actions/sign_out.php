<?php
session_start();
header("Location: /pages/account.php");

if (isset($_SESSION["signedIn"])) {
  unset($_SESSION["signedIn"], $_SESSION["username"]);
  $_SESSION["message"] = "Signed out";
}
