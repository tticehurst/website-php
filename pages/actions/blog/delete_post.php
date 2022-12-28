<?php

session_start();
header("Location: /pages/blog/index.php");

include_once(__DIR__ . "/../../../includes/db.php");
include_once(__DIR__ . "/../../../includes/get_access.php");

$userLevel = $getAccessFunction($_SESSION["username"]);

if (isset($_SESSION["signedIn"])) {
  $deleteQuery = null;

  if ($userLevel < 255) {
    $deleteQuery = $connection->prepare("DELETE FROM blog WHERE pk=? AND post_owner=?");

    $deleteQuery->execute([$_POST["id"], $_SESSION["username"]]);
  } else {
    $deleteQuery = $connection->prepare("DELETE FROM blog WHERE pk=?");

    $deleteQuery->execute([$_POST["id"]]);
  }

  if ($deleteQuery->rowCount() === 1) {
    $_SESSION["message"] = "Post deleted";
  } else {
    $_SESSION["message"] = "You do not own this post, or it does not exist";
  }
}
