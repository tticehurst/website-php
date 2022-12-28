<?php
$f = function ($level) {
  include_once(__DIR__ . "/signinCheck.php");
  $g = include_once(__DIR__ . "/get_access.php");

  $userLevel = $g($_SESSION["username"]);

  if ($userLevel < $level) {
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], "https") === 0 ? "https://" : "http://";
    $host = $_SERVER["HTTP_HOST"];
    $pages = "$protocol$host/pages";

    echo "
        <link rel='stylesheet' href='../css/styles.css'>
        <link rel='stylesheet' href='../../css/styles.css'>

        <div class='flex-column flex-align-centre'>
          <h1>You do not have access for this page</h1>
          <img style='margin-bottom: 35px; width:790px' src='https://c.tenor.com/hb-d1AZJNR4AAAAC/knocked-down-denied.gif'/>
          <button><a href='$pages/index.php'>Home</a></button>
        </div>
    ";
    die();
  }
};

return $f;
