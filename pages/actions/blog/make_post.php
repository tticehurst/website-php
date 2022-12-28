<?php

session_start();
header("Location: /pages/blog/index.php");

include_once(__DIR__ . "/../../../includes/db.php");

if (isset($_SESSION["signedIn"])) {
  $creator = $_SESSION["username"];

  $title = $_POST["post_title"];
  $content = $_POST["post_content"];

  $query = $connection->prepare("INSERT INTO blog VALUES(0,?,?,?)");
  $query->execute([$creator, $title, $content]);

  $_SESSION["message"] = "Post added!";
}
