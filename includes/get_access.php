<?php
$getAccessFunction = function ($username) {
  include(__DIR__ . "/db.php");

  $query = $connection->prepare("SELECT access_level FROM accounts WHERE BINARY username=?");
  $query->execute([$username]);

  if ($query->rowCount() == 1) {
    $savedDetails = $query->fetchAll();
    $userLevel = $savedDetails[0]["access_level"];

    return $userLevel;
  } else {
    return 0;
  }
};

return $getAccessFunction;
