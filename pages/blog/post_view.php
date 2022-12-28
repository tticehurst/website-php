<?php
session_start();
$inc = include_once(__DIR__ . "/../../includes/access_check.php");
$inc(255);

include_once(__DIR__ . "/../../vendor/parsedown.php");

include_once(__DIR__ . "/../../includes/signinCheck.php");
include_once(__DIR__ . "/../../elements/header/header.php");
include_once(__DIR__ . "/../../includes/get_access.php");

$userLevel = $getAccessFunction($_SESSION["username"]);

include(__DIR__ . "/../../includes/db.php");


if (!isset($_GET["id"])) {
  $error = "Please provide a valid post id";
} else {
  $query = $connection->prepare("SELECT pk,post_title,post_content,post_owner FROM blog WHERE pk=?");
  $query->execute([$_GET["id"]]);

  if ($query->rowCount() === 0) {
    $error = "Post does not exist";
  } else {
    $result = $query->fetchAll()[0];
    $parsedown = new Parsedown();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/../../css/styles.css">

  <script src="/../../elements/header/headerLink.js"></script>
  <script src="/../../elements/footer/footer.js"></script>
</head>

<body>
  <div id="container">
    <header-custom></header-custom>
    <div id="content">
      <div class="flex-row flex-justify-centre flex-align-centre">
        <?php if (isset($error)) {
          echo "<h1>$error</h1>";
          die();
        } ?>

        <div id="blog-post-content" class="flex-column flex-justify-centre centre-margin">
          <h1><?= $result["post_title"] ?></h1>
          <?php
          ?>

          <?= $parsedown->text($result["post_content"]) ?>

          <?php if ($_SESSION["username"] === $result["post_owner"]) { ?>
            <div id="post-edit" style="margin-top:50px;">
              <h1>Edit post</h1>
              <form class="flex-column flex-align-centre gap-small" method="POST" action="../actions/blog/edit_post.php">
                <div class="flex-row gap-large flex-align-centre">
                  <input type="hidden" value=<?= $_GET["id"] ?> name="id">
                  <label for="post_title">Post title</label>
                  <input type="text" name="post_title" minlength="5" maxlength="45" placeholder="Optional">
                </div>

                <textarea required maxlength="20000" minlength="5" rows="13" cols="60" placeholder="Post content here (required)" style="font-size: 0.95em;" name="post_content"><?= $result["post_content"] ?></textarea>

                <button type="submit">Edit post</button>
              </form>
            </div>
          <?php } ?>

          <?php if ($_SESSION["username"] === $result["post_owner"] || $userLevel === 255) { ?>
            <div style="margin-top:5px;">
              <form method="POST" action="../actions/blog/delete_post.php" class="flex-row flex-justify-centre">
                <input type="hidden" value=<?= $_GET["id"] ?> name="id">
                <button type="submit">Delete post</button>
              </form>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <footer-custom></footer-custom>
  </div>
</body>

</html>