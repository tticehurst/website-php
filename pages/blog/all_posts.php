<?php
session_start();
$inc = include_once(__DIR__ . "/../../includes/access_check.php");
$inc(255);

include_once(__DIR__ . "/../../vendor/parsedown.php");

include_once(__DIR__ . "/../../includes/signinCheck.php");
include_once(__DIR__ . "/../../elements/header/header.php");

$getPosts = include_once(__DIR__ . "/../../includes/get_posts.php");
$posts = $getPosts(0, true);



$parsedown = new Parsedown();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/../css/styles.css">
</head>

<body>
  <div id="container">
    <header-custom></header-custom>
    <div id="content">
      <div class="flex-column flex-justify-centre flex-align-centre">
        <?php if (count($posts) === 0) { ?>
          <h1>No posts exist</h1>
        <?php } else { ?>
          <?php foreach ($posts as $post) { ?>
            <div class="blog-post">
              <?php
              $content = preg_replace("/\s+/", "_", (substr($post["post_content"], 0, 50) . "..."));
              $title = preg_replace("/\s+/", "_", $post["post_title"]);
              $owner = preg_replace("/\s+/", "_", $post["post_owner"]);
              ?>

              <blog-post id=<?= $post["pk"] ?> creator=<?= $owner ?> title=<?= $title; ?> content=<?= strip_tags($parsedown->text($content)) ?> />
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <footer-custom></footer-custom>
  </div>

  <script src="/../../elements/header/headerLink.js"></script>
  <script src="/../../elements/footer/footer.js"></script>

  <script src="/../../elements/blog/post.js"></script>
</body>

</html>