<?php
session_start();
include_once(__DIR__ . "/../../includes/db.php");
header("Location: /pages/account_management.php");

$query = $connection->prepare("SELECT username,access_level,locked FROM accounts WHERE BINARY username=?");
$query->execute([$_POST["username"]]);

if ($query->rowCount() == 1) {
  $savedDetails = $query->fetchAll()[0];

  $_SESSION["returnedData"] = $savedDetails;
} else {
  $_SESSION["message"] = "User does not exist";
}
