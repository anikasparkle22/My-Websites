<?php

$title = 'Plant Database';
$plant_database_class = 'active_page';
$show_form = True;

if (is_user_logged_in()) {

  // FORM 2 FILTERING AND SORTING
  $form2_valid = False;
  $filter_feedback_class= 'hidden';
  $sort_feedback_class= 'hidden';

  // GET FILTER VALUES
  $fecp = !empty($_GET['fexploratory-constructive-play']);
  $fesp = !empty($_GET['fexploratory-sensory-play']);
  $fep  = !empty($_GET['fexpressive-play']);
  $fpp  = !empty($_GET['fphysical-play']);
  $fip  = !empty($_GET['fimaginative-play']);
  $frp  = !empty($_GET['frestorative-play']);
  $fbp  = !empty($_GET['fbio-play']);
  $fnss = !empty($_GET['fnooks']);
  $fvi  = !empty($_GET['fvisual-interest']);
  $fpwr = !empty($_GET['fplay-with-rules']);

  // STICKY VALUES
  $sticky_fecp = $fecp ? 'checked' : '';
  $sticky_fesp = $fesp ? 'checked' : '';
  $sticky_fep  = $fep  ? 'checked' : '';
  $sticky_fpp  = $fpp  ? 'checked' : '';
  $sticky_fip  = $fip  ? 'checked' : '';
  $sticky_frp  = $frp  ? 'checked' : '';
  $sticky_fbp  = $fbp  ? 'checked' : '';
  $sticky_fnss = $fnss ? 'checked' : '';
  $sticky_fvi  = $fvi  ? 'checked' : '';
  $sticky_fpwr = $fpwr ? 'checked' : '';

  // HANDLE SORTING
  $sort_i = $_GET['sort_input'] ?? '';
  $asc_sort1 = ($sort_i === 'asc1');
  $asc_sort2 = ($sort_i === 'asc2');
  $asc_sort3 = ($sort_i === 'asc3');

  $stickyasc_sort1 = $asc_sort1 ? 'checked' : '';
  $stickyasc_sort2 = $asc_sort2 ? 'checked' : '';
  $stickyasc_sort3 = $asc_sort3 ? 'checked' : '';

  $ss = '';
  if (!empty($sort_i)) {
    $ss = "Database successfully sorted";
  }

  // VALIDATION FOR FILTER FORM
  if (isset($_GET['filter'])) {
    if (empty($fpwr) && empty($fvi) && empty($fnss) && empty($fecp) && empty($fesp)
        && empty($fep) && empty($fpp) && empty($fip) && empty($frp) && empty($fbp)
        && empty($sort_i)) {

        $filter_feedback_class = '';
        $sort_feedback_class = '';
    }
  }

  // FILTER & SORT SQL BUILD
  $fs = '';
  $selects = 'SELECT * FROM plant_data';
  $filter_array = [];
  $order = '';

  // SORTING
  if ($asc_sort1) $order = ' ORDER BY plant_id ASC';
  if ($asc_sort2) $order = ' ORDER BY plant_name ASC';
  if ($asc_sort3) $order = ' ORDER BY plant_genus ASC';

  // FILTERS
  if ($fecp) $filter_array[] = "(s_ecp = '1')";
  if ($fesp) $filter_array[] = "(s_esp = '1')";
  if ($fpp) $filter_array[] = "(s_pp = '1')";
  if ($frp) $filter_array[] = "(s_rp = '1')";
  if ($fip) $filter_array[] = "(s_ip = '1')";
  if ($fep) $filter_array[] = "(s_ep = '1')";
  if ($fbp) $filter_array[] = "(s_bp = '1')";
  if ($fvi) $filter_array[] = "(p_vi = '1')";
  if ($fpwr) $filter_array[] = "(s_pwr = '1')";
  if ($fnss) $filter_array[] = "(c_nss = '1')";

  $wheres = '';
  if (count($filter_array) > 0) {
    $wheres = ' WHERE ' . implode(' AND ', $filter_array);
    $fs = 'Database successfully filtered';
  }

  // DELETE PLANT
  if (isset($_GET['delete'])) {
      $delid = $_GET['delete'];

      exec_sql_query($db, 'DELETE FROM plant_data WHERE id = :id', [':id' => $delid]);
      exec_sql_query($db, 'DELETE FROM plant_tags WHERE plant_id = :id', [':id' => $delid]);

      @unlink("public/uploads/plant_data/" . $delid . ".jpg");
  }

  // FINAL QUERY
  $sql_query = $selects . $wheres . $order;
  $records = exec_sql_query($db, $sql_query)->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Playful Plants</title>
  <link rel="stylesheet" type="text/css" href="public/styles/site.css"/>
</head>

<body>
<?php include('includes/header.php'); ?>

<div class="content">

<?php if (is_user_logged_in()) { ?>

<div class="row">
  <div class="stack">

  <main class="form2">
      <h1 class="forms">Filter</h1>
      <p class="confirm"><?php echo $fs; ?></p>
      <hr class="new1">

      <form id="request-form2" method="get" action="/browse-plants" novalidate>

      <div id="feedback-filter" class="feedback <?php echo $filter_feedback_class; ?>">
         Please select at least one item to filter the catalog by
      </div>

      <!-- FILTER CHECKBOXES -->
      <div class="label-input">
        <input type="checkbox" name="fexploratory-constructive-play" id="fexploratory-constructive-play" <?php echo $sticky_fecp; ?> />
        <label for="fexploratory-constructive-play">Supports Exploratory Constructive Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fexploratory-sensory-play" id="fexploratory-sensory-play" <?php echo $sticky_fesp; ?> />
        <label for="fexploratory-sensory-play">Supports Exploratory Sensory Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fphysical-play" id="fphysical-play" <?php echo $sticky_fpp; ?> />
        <label for="fphysical-play">Supports Physical Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fimaginative-play" id="fimaginative-play" <?php echo $sticky_fip; ?> />
        <label for="fimaginative-play">Supports Imaginative Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="frestorative-play" id="frestorative-play" <?php echo $sticky_frp; ?> />
        <label for="frestorative-play">Supports Restorative Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fexpressive-play" id="fexpressive-play" <?php echo $sticky_fep; ?> />
        <label for="fexpressive-play">Supports Expressive Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fbio-play" id="fbio-play" <?php echo $sticky_fbp; ?> />
        <label for="fbio-play">Supports Bio Play</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fplay-with-rules" id="fplay-with-rules" <?php echo $sticky_fpwr; ?> />
        <label for="fplay-with-rules">Supports Play with Rules</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fvisual-interest" id="fvisual-interest" <?php echo $sticky_fvi; ?> />
        <label for="fvisual-interest">Provides Visual Interest</label>
      </div>

      <div class="label-input">
        <input type="checkbox" name="fnooks" id="fnooks" <?php echo $sticky_fnss; ?> />
        <label for="fnooks">Creates Nooks or Secret Spaces</label>
      </div>

      <!-- SORT OPTIONS -->
      <h1 class="forms" id="sort-head">Sort</h1>
      <p class="confirm"><?php echo $ss; ?></p>
      <hr class="new1">

      <p id="sort_feedback" class="feedback <?php echo $sort_feedback_class; ?>">
        Please select an option to sort the catalog by
      </p>

      <div>
        <input type="radio" id="asc1" name="sort_input" value="asc1" <?php echo $stickyasc_sort1; ?> />
        <label for="asc1">Plant ID in Alphabetical Order</label>
      </div>

      <div>
        <input type="radio" id="asc2" name="sort_input" value="asc2" <?php echo $stickyasc_sort2; ?> />
        <label for="asc2">Plant Name in Alphabetical Order</label>
      </div>

      <div>
        <input type="radio" id="asc3" name="sort_input" value="asc3" <?php echo $stickyasc_sort3; ?> />
        <label for="asc3">Plant Genus in Alphabetical Order</label>
      </div>

      <div class="align-right">
        <input id="request-submit" type="submit" name="filter" value="Submit" />
      </div>

      </form>
  </main>
</div>

<!-- PLANT DATA DISPLAY -->
<main class="plant-data">
  <h1 class="pdc">Plant Data Catalog
    <a href="/add-plant">
      <button class="add">
        <h3>Add Plant Form</h3>
      </button>
    </a>
  </h1>

  <div class="plants">
    <ul>

    <?php foreach ($records as $record) {
      $name = htmlspecialchars($record['plant_name']);
      $genus = htmlspecialchars($record['plant_genus']);
      $id = htmlspecialchars($record['plant_id']);
    ?>

      <div class="tile-header">
        <h2>
          <a href="/browse-plants/plant-page?<?php echo http_build_query(['plant_id' => $id]); ?>">
            <?php echo $name; ?>
          </a>
        </h2>
      </div>

      <div class="tile-attrib">
        <li><p>Plant genus: <?php echo $genus; ?></p></li>
        <li><p>Plant id: <?php echo $id; ?></p></li>

        <li>
          <?php
            if ($record["p_vi"] == 1) echo "Provides visual interest";
            else echo "Does not provide visual interest";
          ?>
        </li>

        <li><p>Supports:
          <?php
            $plays = [];
            if ($record["s_ecp"]) $plays[] = "exploratory constructive play";
            if ($record["s_esp"]) $plays[] = "exploratory sensory play";
            if ($record["s_pp"])  $plays[] = "physical play";
            if ($record["s_ip"])  $plays[] = "imaginative play";
            if ($record["s_rp"])  $plays[] = "restorative play";
            if ($record["s_ep"])  $plays[] = "expressive play";
            if ($record["s_pwr"]) $plays[] = "play with rules";
            if ($record["s_bp"])  $plays[] = "bio play";

            echo implode(", ", $plays);
          ?>
        </p></li>

        <li>
          <?php
            if ($record["c_nss"] == 1) echo "Creates nooks or secret spaces";
            else echo "Does not create nooks or secret spaces";
          ?>
        </li>

      </div>

      <div class="form4">

        <!-- DELETE -->
        <form class="delete" method="get" action="/browse-plants"
              onclick="return confirm('Are you sure you want to delete <?php echo $name; ?>?')"
              novalidate>
          <button value="<?php echo htmlspecialchars($record['id']); ?>" name="delete" class="end" type="submit">
            <img src="/public/images/deleteicon.png" alt="delete icon" />
          </button>
        </form>

        <!-- EDIT -->
        <form class="edit" method="get" action="/browse-plants/edit" novalidate>
          <input type="hidden" name="plant" value="<?php echo $id; ?>" />
          <button class="end" type="submit">
            <img src="/public/images/editicon.jpg" alt="edit icon" />
          </button>
        </form>

      </div>

      <hr>

    <?php } ?>

    </ul>
  </div>
</main>

</div>

<?php } else { ?>

<!-- NOT LOGGED IN SECTION -->
<div class="content">
  <h2>This page is only for administrators, please login</h2>
  <?php echo_login_form('/browse-plants', $session_messages); ?>
</div>

<?php } ?>

</body>
</html>
