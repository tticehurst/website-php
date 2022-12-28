<?php
$getAccessF = function ($username) {
  include(__DIR__ . "/db.php");

  $query = $connection->prepare("SELECT locked FROM accounts WHERE BINARY username=?");
  $query->execute([$username]);

  if ($query->rowCount() == 1) {
    $savedDetails = $query->fetchAll();
    $userLevel = $savedDetails[0]["locked"];

    return $userLevel;
  } else {
    return 0;
  }
};

return $getAccessF;
