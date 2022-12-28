<?php
$connection = new PDO("mysql:host=localhost;dbname=website", "website", "QGj^LR%eH*cugytR9HFJLs5FAzPG3mL@vDp@kb", [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
]);
