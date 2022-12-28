<?php
session_start();

include_once(__DIR__ . "/../../includes/signinCheck.php");
include_once(__DIR__ . "/../../elements/header/header.php");
include_once(__DIR__ . "/../../includes/get_access.php");

include(__DIR__ . "/../../includes/db.php");

$userLevel = $getAccessFunction($_SESSION["username"]);

if (!isset($_GET["id"])) {
  $error = "Please provide a valid post id";
} else {
  $query = $connection->prepare("SELECT job,cost,times_completed,assigned_to FROM jobs WHERE pk=?");
  $query->execute([$_GET["id"]]);

  if ($query->rowCount() === 0) {
    $error = "Job does not exist";
  } else {
    $result = $query->fetchAll()[0];
  }
}



if (isset($_POST["field"])) {
  $query = $connection->prepare("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name='jobs' AND column_name=?");
  $query->execute([$_POST["field"]]);

  $raw_type = $query->fetchAll()[0]["DATA_TYPE"];

  try {
    $data_type = match ($raw_type) {
      "decimal", "int" => "number",
      "varchar" => "text"
    };
  } catch (UnhandledMatchError) {
    echo "Type '" . $raw_type . "' not implemented!";
    die();
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../css/styles.css">


  <script src="../../elements/header/headerLink.js"></script>
  <script src="../../elements/footer/footer.js"></script>
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

        <div id="job-content" class="flex-column flex-justify-centre centre-margin gap-large">
          <div>
            <h1><?= $result["job"] ?></h1>
            <ul>
              <?php foreach ($result as $jobIndex => $jobValue) { ?>
                <li><?= str_replace("_", " ", $jobIndex) ?>: <?= $jobValue ?></li>
              <?php } ?>

              <li><b>Total cost: <?= $result["times_completed"] * $result["cost"] ?></b></li>
            </ul>
          </div>

          <div>
            <h2>Modify job</h3>
              <div>
                <form method="POST">
                  <label for="field">Field to modify:</label>
                  <select name="field" onchange="this.form.submit()">
                    <option disabled selected>Please select an option</option>
                    <?php foreach ($result as $jobIndex => $jobValue) { ?>
                      <?php if ($jobIndex == $_POST["field"]) { ?>
                        <option selected name=<?= $jobIndex ?>><?= $jobIndex ?></option>
                      <?php } else { ?>
                        <option name=<?= $jobIndex ?>><?= $jobIndex ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </form>

                <?php if (isset($_POST["field"])) { ?>
                  <form method="POST" class="flex-column" action="../actions/jobs/edit_job.php">
                    <div class="flex-row">
                      <label for="set_value">Set '<?php echo (str_replace("_", " ", $_POST["field"])) ?>' value to:</label>
                      <input hidden value=<?= $_POST["field"] ?> name="field">
                      <input hidden value=<?= $_GET["id"] ?> name="pk">

                      <input name="new_value" type=<?= $data_type ?> id="set_value" step="0.01">
                    </div>

                    <button type=" submit" style="align-self: center; margin-top: 10px;">Modify job</button>
                  </form>
                <?php } ?>
              </div>


              <?php if ($userLevel >= 100) { ?>
                <form method="POST" action="../actions/jobs/delete_job.php">
                  <input hidden name="pk" value=<?= $_GET["id"] ?>>
                  <button type="submit">Delete job</button>
                </form>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <footer-custom></footer-custom>
  </div>
</body>

</html>