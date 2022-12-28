<?php
session_start();
if (isset($_POST["pk"])) {
  header("Location: /pages/jobs/job_view.php?id=" . $_POST["pk"]);

  include_once(__DIR__ . "/../../../includes/db.php");

  print_r($_POST);

  $getColumnName = function ($data) {
    return $data["COLUMN_NAME"];
  };

  if (isset($_SESSION["signedIn"])) {
    $query = $connection->prepare("SELECT pk FROM jobs WHERE pk=?");
    $query->execute([$_POST["pk"]]);

    if ($query->rowCount() === 1) {
      $columnQuery = $connection->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'jobs'");
      $columnQuery->execute();

      $columnQueryResult = array_map($getColumnName, $columnQuery->fetchAll());

      if (in_array($_POST["field"], $columnQueryResult)) {
        $modifyQuery = $connection->prepare("UPDATE jobs SET " . $_POST["field"] . "=? WHERE pk=?");
        $modifyQuery->execute([$_POST["new_value"], $_POST["pk"]]);

        $_SESSION["message"] = "Job modified";
      }
    }
  }
} else {
  header("Location: /pages/jobs/index.php");
}
