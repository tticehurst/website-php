<?php
$validFilters = array(
  "assigned",
  "not assigned",
  "none"
);

$getJobs = function ($filter = null) {
  include(__DIR__ . "/db.php");
  $filter = strtolower($filter);

  if ($filter === "assigned") {
    $query = $connection->prepare("SELECT * FROM jobs WHERE assigned_to=?");
    $query->execute([$_SESSION["username"]]);
  } else if ($filter === "not assigned") {
    $query = $connection->prepare("SELECT * FROM jobs WHERE assigned_to=?");
    $query->execute(["nobody"]);
  } else {
    $query = $connection->prepare("SELECT * FROM jobs");
    $query->execute();
  }


  if ($query->rowCount() > 0) {
    $allJobs = $query->fetchAll();

    return $allJobs;
  } else {
    return array();
  }
};

return $getJobs;
