<?php
$title = 'Our Plant Listings';

// Initial queries
$plants = exec_sql_query(
  $db,
  "SELECT * FROM plant_data;"
)->fetchAll();

$tagarr = exec_sql_query(
  $db,
  "SELECT tname FROM tags"
)->fetchAll();

$form1_valid = False;
$filter_feedback_class = 'hidden';
$sort_feedback_class = 'hidden';
$tag_feedback_class = 'hidden';

// Read GET inputs safely
$tag = $_GET['tag_input'] ?? null;
$an  = !empty($_GET['An']);
$pr  = !empty($_GET['Pr']);
$nr  = !empty($_GET['Nr']);
$fsu = !empty($_GET['Fsu']);
$fsh = !empty($_GET['Fsh']);
$psh = !empty($_GET['Psh']);

$sort_i = $_GET['sort_input'] ?? '';
$asc_sort2 = ($sort_i === 'asc2');

// Sticky checkboxes
$sticky_an  = $an  ? 'checked' : '';
$sticky_pr  = $pr  ? 'checked' : '';
$sticky_nr  = $nr  ? 'checked' : '';
$sticky_fsu = $fsu ? 'checked' : '';
$sticky_fsh = $fsh ? 'checked' : '';
$sticky_psh = $psh ? 'checked' : '';

$stickyasc_sort2 = $asc_sort2 ? 'checked' : '';

$ss = ''; // sort success message
$fs = ''; // filter success message

// Sticky for tag radio buttons
$tag_sticky_list = [];
foreach ($tagarr as $value) {
  $tag_name = $value['tname'];
  $tag_sticky_list[$tag_name] = ($tag === $tag_name ? 'checked' : '');
}

if (isset($_GET['filter'])) {

    if (empty($tag) && !$an && !$pr && !$nr && !$fsu && !$fsh && !$psh && empty($sort_i)) {
        $filter_feedback_class = '';
        $sort_feedback_class = '';
    }

    if (!empty($sort_i)) {
        $ss = 'Database successfully sorted';
    }
}

// ----------- FILTER + SORT SQL BUILDING -------------
$selects = 'SELECT * FROM plant_data';
$wheres = [];
$order = '';
$params = [];

// Filter by tag (plants that HAVE this tag)
if ($tag) {
    $wheres[] = "id IN (
        SELECT plant_id
        FROM plant_tags
        WHERE tag_id = (SELECT id FROM tags WHERE tname = :tag)
    )";
    $params[':tag'] = $tag;
    $fs = "Database successfully filtered";
}

// Lifespan filters (OR within lifespan group, AND with other groups)
$pa_values = [];
if ($an) { $pa_values[] = 'Annual'; }
if ($pr) { $pa_values[] = 'Perennial'; }
if ($nr) { $pa_values[] = 'Neither'; }

if (!empty($pa_values)) {
    $placeholders = [];
    foreach ($pa_values as $idx => $val) {
        $ph = ':pa' . $idx;
        $placeholders[] = $ph;
        $params[$ph] = $val;
    }
    $wheres[] = 'pa IN (' . implode(', ', $placeholders) . ')';
    $fs = "Database successfully filtered";
}

// Sun filters (OR within sun group, AND with other groups)
$sun_clauses = [];
if ($fsu) { $sun_clauses[] = "fsu = '1'"; }
if ($fsh) { $sun_clauses[] = "fsh = '1'"; }
if ($psh) { $sun_clauses[] = "psh = '1'"; }

if (!empty($sun_clauses)) {
    $wheres[] = '(' . implode(' OR ', $sun_clauses) . ')';
    $fs = "Database successfully filtered";
}

// Combine filters
$where_sql = '';
if (!empty($wheres)) {
    // AND between groups: tag AND lifespan AND sun
    $where_sql = ' WHERE ' . implode(' AND ', $wheres);
}

// Sorting
if ($asc_sort2) {
    $order = " ORDER BY plant_name ASC";
}

// Final query
$sql_query = $selects . $where_sql . $order;
$plants = exec_sql_query($db, $sql_query, $params)->fetchAll();

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
<div class="row">
  <div class="stack">
  <main class="form1">
      <h1 class="forms">Filter</h1>
      <p class="confirm"><?php echo $fs; ?></p>
      <hr class="new1">

    <form id="request-form1" method="get" action="/" novalidate>
    <div id="feedback-filter" class="feedback <?php echo $filter_feedback_class; ?>">Please select at least one item to filter the catalog by</div>

    <h2 class="forms">Class:</h2>
    <?php foreach ($tagarr as $item) {
        $value = $item['tname']; ?>
        <div>
            <input type="radio"
                   id="<?php echo htmlspecialchars($value); ?>"
                   name="tag_input"
                   value="<?php echo htmlspecialchars($value); ?>"
                   <?php echo $tag_sticky_list[$value]; ?> />
            <label for="<?php echo htmlspecialchars($value); ?>">
              <?php echo htmlspecialchars($value); ?>
            </label>
        </div>
    <?php } ?>

    <h2 class="forms">Lifespan:</h2>
      <div class="label-input">
        <input type="checkbox" name="An" id="An" value="An" <?php echo $sticky_an; ?> />
        <label for="An">Annual</label>
      </div>
      <div class="label-input">
        <input type="checkbox" name="Pr" id="Pr" value="Pr" <?php echo $sticky_pr; ?> />
        <label for="Pr">Perennial</label>
      </div>
      <div class="label-input">
        <input type="checkbox" name="Nr" id="Nr" value="Nr" <?php echo $sticky_nr; ?> />
        <label for="Nr">Neither Perennial or Annual</label>
      </div>

    <h2 class="forms">Sun Level:</h2>
      <div class="label-input">
        <input type="checkbox" name="Fsh" id="Fsh" value="Fsh" <?php echo $sticky_fsh; ?> />
        <label for="Fsh">Full Shade</label>
      </div>
      <div class="label-input">
        <input type="checkbox" name="Fsu" id="Fsu" value="Fsu" <?php echo $sticky_fsu; ?> />
        <label for="Fsu">Full Sun</label>
      </div>
      <div class="label-input">
        <input type="checkbox" name="Psh" id="Psh" value="Psh" <?php echo $sticky_psh; ?> />
        <label for="Psh">Partial Shade</label>
      </div>

      <div class="form-group label-input" role="group" aria-labelledby="sort-head">
      <h1 class="forms" id="sort-head">Sort</h1>
      <p class="confirm"><?php echo $ss; ?></p>
      <hr class="new1">
      <p id="sort_feedback" class="feedback <?php echo $sort_feedback_class; ?>">Please select an option to sort the catalog by</p>

          <div>
            <input type="radio" id="asc2" name="sort_input" value="asc2" <?php echo $stickyasc_sort2; ?> />
            <label for="asc2">Plant Name in Alphabetical Order</label>
          </div>

      <div class="align-right">
        <input id="request-submit" type="submit" name="filter" value="Submit" />
      </div>
    </form>
  </main>
</div>

<section class="gallery">
<main class="plant-data">
    <h2 class="ab"><?php echo $title; ?></h2>

    <ul>
      <?php foreach ($plants as $record) { ?>
        <li>
          <a href="/browse-plants/plant-page?<?php echo http_build_query(array('plant_id' => $record['plant_id'])); ?>">
            <img src="/public/uploads/plant_data/<?php echo $record['id'] . '.' . $record['file_ext']; ?>"
                 alt="<?php echo htmlspecialchars($record['plant_name']); ?>" />

            <p><?php echo ucfirst($record['file_name'] ?? ''); ?></p>

            <h3 class="center"><?php echo htmlspecialchars($record['plant_name']); ?></h3>
            <p class="hidden"><?php echo htmlspecialchars($record['plant_genus']); ?></p>
          </a>
        </li>
      <?php } ?>
    </ul>
</main>
</section>

</div>
</div>

</body>
</html>
