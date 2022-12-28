<?php
session_start();
header("Location: /pages/account_management.php");

include_once(__DIR__ . "/../../includes/db.php");


$query = $connection->prepare("SELECT username FROM accounts WHERE username=?");
$query->execute([$_POST["username"]]);

if ($query->rowCount() === 0) {
  $userPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $query = $connection->prepare("INSERT INTO accounts(pk,username,password) VALUES(0,?,?)");
  $query->execute([$_POST["username"], $userPassword]);

  $_SESSION["message"] = "Account created";
} else {
  $_SESSION["message"] = "Account already exists";
  die("Account already exists");
};
