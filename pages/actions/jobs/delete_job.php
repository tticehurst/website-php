<?php

session_start();
header("Location: /pages/jobs/index.php");

include_once(__DIR__ . "/../../../includes/db.php");

if (isset($_SESSION["signedIn"])) {
  $query = $connection->prepare("DELETE FROM jobs WHERE pk=?");
  $query->execute([$_POST["pk"]]);

  if ($query->rowCount() === 1) {
    $_SESSION["message"] = "Job deleted";
  } else {
    $_SESSION["message"] = "Job does not exist";
  }
}
