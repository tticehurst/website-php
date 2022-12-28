<?php
if (!isset($_SESSION["signedIn"]) || !isset($_SESSION)) {
  header("Location: /pages/account.php");
  die();
}
