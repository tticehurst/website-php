<?php
session_start();

$inc = include_once(__DIR__ . "/../../includes/access_check.php");
$inc(255);

include_once(__DIR__ . "/../../vendor/parsedown.php");
include_once(__DIR__ . "/../../includes/signinCheck.php");
include_once(__DIR__ . "/../../elements/header/header.php");

$getPosts = include_once(__DIR__ . "/../../includes/get_posts.php");

$posts = $getPosts(5, false);
$parsedown = new Parsedown();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/../css/styles.css">

  <title>Blog</title>
</head>

<body>
  <div id="container">
    <header-custom></header-custom>
    <div id="content">
      <div class="flex-row flex-justify-centre gap-huge">

        <div class="flex-column flex-align-centre">
          <h2>Make a post</h2>
          <form class="flex-column flex-align-centre gap-small" method="POST" action="../actions/blog/make_post.php">
            <div class="flex-row gap-large flex-align-centre">
              <label for="post_title">Post title</label>
              <input type="text" name="post_title" minlength="5" maxlength="45" required>
            </div>

            <textarea required maxlength="20000" minlength="5" rows="13" cols="60" placeholder="Post content here" style="font-size: 0.95em;" name="post_content"></textarea>

            <button type="submit">Make post</button>
          </form>
        </div>

        <div class="flex-column flex-justify-centre">
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

            <?php if (count($posts) > 0) { ?>
              <button onclick="location.href='all_posts.php'">View all</button>
            <?php } ?>
          <?php } ?>
        </div>
      </div>

    </div>
    <footer-custom></footer-custom>
  </div>

  <script src="/../../elements/header/headerLink.js"></script>
  <script src="/../../elements/footer/footer.js"></script>

  <script src="/../../elements/blog/post.js"></script>
</body>

</html>