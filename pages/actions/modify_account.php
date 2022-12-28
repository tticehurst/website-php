<?php
session_start();
header("Location: /pages/account_management.php");
include_once(__DIR__ . "/../../includes/db.php");

$getUserLevel = include_once(__DIR__ . "/../../includes/get_access.php");
$getUserLocked = include_once(__DIR__ . "/../../includes/get_locked.php");

$userLevel = $getUserLevel($_SESSION["username"]);

$userLocked = $getUserLocked($_POST["username"]);
$modifiedAccountLevel = $getUserLevel($_POST["username"]);

$valueChanged = false;

if ($_POST["username"] === $_SESSION["username"] && $userLevel < 255) {
  $_SESSION["message"] = "You may not modify your own user";
  die();
}


$sentValues = array(
  "accessLevel" =>  array("level" => 0, "value" => $modifiedAccountLevel),
  "locked" => array("level" => 200, "value" => $userLocked)
);


foreach ($_POST as $property => $value) {
  if (strlen($value) > 0 && $value !== $_POST["username"]) {
    if ($userLevel >= $sentValues[$property]["level"]) {
      $sentValues[$property]["value"] = $value;
      $valueChanged = true;
    }
  }
}

if ($_POST["accessLevel"] > $userLevel) {
  $_SESSION["message"] = "You may not raise an access level above your own";
} elseif ($modifiedAccountLevel > $userLevel) {
  $_SESSION["message"] = "You may not modify a user with a higher access level than your own";
} elseif (!$valueChanged) {
  $_SESSION["message"] = "User not modified";
} else {
  $query = $connection->prepare("SELECT locked FROM accounts WHERE BINARY username=?");
  $query->execute([$_POST["username"]]);

  $isLocked = $query->fetchAll()[0]["locked"];

  if ($isLocked && $userLevel < 255) {
    $_SESSION["message"] = "This user is locked";
  } else {
    $query = $connection->prepare("UPDATE accounts SET access_level = ?,locked=? WHERE BINARY username=?");
    $params = array($sentValues["accessLevel"]["value"], $sentValues["locked"]["value"], $_POST["username"]);

    $query->execute($params);

    $_SESSION["message"] = "User modified";
  }
}
