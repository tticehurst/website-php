<?php

session_start();
header("Location: /pages/blog/index.php");

include_once(__DIR__ . "/../../../includes/db.php");

if (isset($_SESSION["signedIn"])) {
  $query = $connection->prepare("SELECT pk,post_title,post_content FROM blog WHERE pk=? AND post_owner=?");
  $query->execute([$_POST["id"], $_SESSION["username"]]);

  if ($query->rowCount() === 1) {
    $post = $query->fetchAll()[0];

    if (strlen($_POST["post_title"]) <= 0) {
      $title = $post["post_title"];
    } else {
      $title = $_POST["post_title"];
    }

    if (strlen(preg_replace("/\s+/", "", $_POST["post_content"])) <= 0) {
      $postContent = $post["post_content"];
    } else {
      $postContent = $_POST["post_content"];
    }

    $updateQuery = $connection->prepare("UPDATE blog SET post_content=?,post_title=? WHERE pk=?");
    $updateQuery->execute([$postContent, $title, $_POST["id"]]);

    $_SESSION["message"] = "Edit made";
  } else {
    $_SESSION["message"] = "You do not own a post by this id";
  }
}
