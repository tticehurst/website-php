<?php
$getAccessLevel = include(__DIR__ . "/../../includes/get_access.php");

if (isset($_SESSION["username"])) {
  $userLevel = $getAccessLevel($_SESSION["username"]);
} else {
  $userLevel = 0;
}

?>

<script>
  class Header extends HTMLElement {
    connectedCallback() {
      let pages = `${window.location.protocol}//${window.location.host}/pages`;
      this.innerHTML = `
      <header>
        <!--
        <div id="christmas">
          <div id="christmas-lights"></div>
        </div>
        -->

        <link rel="shortcut icon" href="../../images/favicon.png" />
          <div class="flex-column flex-align-centre margin-bottom-micro" style="gap: 10px;">
            <?php if (isset($_SESSION["signedIn"])) { ?>
              <div>
                <span class="fas fa-handshake"></span>
                <span>Hello, <?= $_SESSION["username"] ?></span>
              </div>
            <?php } ?>
            <?php if (isset($_SESSION["message"])) { ?>
              <span id="header-message"> > <?= $_SESSION["message"] ?> < </span>
            <?php }
            unset($_SESSION["message"]) ?>
          </div>

        <nav class="flex-row flex-justify-centre" id="nav">
          <div id="header-buttons">
            <?php if (isset($_SESSION["signedIn"])) { ?>
              <header-link link="${pages}/index" text="Home"></header-link>
              <header-link link="${pages}/blog/index" text="Blog"></header-link>
               <header-link link="${pages}/account_management" text="Account management"></header-link>

              <?php if ($userLevel >= 100) { ?>
                <header-link link="${pages}/jobs/index" text="Jobs"></header-link>
              <?php } ?>

              <header-link link="${pages}/actions/sign_out" text="Sign out"></header-link>
            <?php } ?>
          </div>
        </nav>
      </header>
      `;
    }
  }

  customElements.define("header-custom", Header);
</script>