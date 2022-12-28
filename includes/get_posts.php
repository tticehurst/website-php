<?php

$getPosts = function ($amount, $all) {
  include(__DIR__ . "/db.php");

  if ($all) {
    $query = $connection->prepare("(SELECT * FROM blog) ORDER BY pk DESC");
    $query->execute();

    if ($query->rowCount() > 0) {
      $all = $query->fetchAll();

      return $all;
    } else {
      return array();
    }
  } else {
    $query = $connection->prepare("(SELECT * FROM blog) ORDER BY pk DESC LIMIT ?");
    $query->execute([$amount]);

    if ($query->rowCount() > 0) {
      $all = $query->fetchAll();

      return $all;
    } else {
      return array();
    }
  }
};

return $getPosts;
