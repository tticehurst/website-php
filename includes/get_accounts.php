<?php
$getAccounts = function () {
  include("../includes/db.php");

  $query = $connection->prepare("(SELECT username FROM accounts) ORDER BY pk DESC");
  $query->execute();

  if ($query->rowCount() >= 1) {
    $all = $query->fetchAll();

    return $all;
  }
};

return $getAccounts;
