<?php
session_start();

$inc = include_once(__DIR__ . "/../../includes/access_check.php");
$inc(100);

include_once(__DIR__ . "/../../includes/signinCheck.php");
include_once(__DIR__ . "/../../elements/header/header.php");
$getJobs = include_once(__DIR__ . "/../../includes/get_jobs.php");

if (isset($_GET["filter"])) {
  $jobs = $getJobs($_GET["filter"]);
} else {
  $jobs = $getJobs("None");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../css/styles.css">

  <title>Homepage</title>
</head>

<body>
  <div id="container">
    <header-custom></header-custom>

    <div id="content">
      <div class="flex-column flex-align-centre gap-huge" id="job-todo">
        <div>
          <div class="flex-column flex-align-centre">
            <h1>
              Jobs
              <?php if (isset($_GET["filter"]) && strtolower($_GET["filter"]) !== "none" && in_array(strtolower($_GET["filter"]), $validFilters, true)) { ?>
                - <?= $_GET["filter"] ?>
              <?php } ?>
            </h1>

            <form method="GET">
              <label for="filter">Select filter:</label>
              <select name="filter" onchange="this.form.submit()">
                <option selected disabled>Please select an option</option>
                <option>None</option>
                <option>Assigned</option>
                <option>Not assigned</option>
              </select>
            </form>
          </div>

          <div class="flex-row flex-justify-centre centre-margin gap-large">
            <table id="jobs-table">
              <?php foreach ($jobs as $jobArr) { ?>
                <form method="GET" action="./job_view.php">
                  <fieldset>
                    <legend>Job: <strong><?= $jobArr["job"] ?></strong></legend>
                    <div id="jobs-table-info" class="flex-column flex-align-centre gap-small_medium">
                      <span>Cost: <?= $jobArr["cost"] ?></span>
                      <span>Times completed: <?= $jobArr["times_completed"] ?></span>
                      <span>Assigned to: <?= $jobArr["assigned_to"] ?></span>
                      <span><b>Total cost: <?= $jobArr["times_completed"] * $jobArr["cost"] ?></b></span>

                      <input type="hidden" value=<?= $jobArr["pk"] ?> name="id">
                      <button type="submit">View job</button>
                    </div>
                  </fieldset>
                </form>
              <?php } ?>
            </table>
          </div>

        </div>
      </div>
    </div>

    <footer-custom></footer-custom>
  </div>

  <script src="../../elements/header/headerLink.js"></script>
  <script src="../../elements/footer/footer.js"></script>
</body>

</html>