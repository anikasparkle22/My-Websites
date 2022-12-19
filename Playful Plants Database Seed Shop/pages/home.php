<?php
$title = 'Our Plant Listings';


$form1_valid = False;

//query plant datass
$plants = exec_sql_query(
  $db,
  "SELECT * FROM plant_data;"
)->fetchAll();

//make an array of all the tags.tname that exist presently for filters to display
$tagarr = exec_sql_query(
  $db,
  "SELECT tags.tname FROM tags",
)->fetchAll();

$form1_valid = False;
$filter_feedback_class= 'hidden';
$sort_feedback_class= 'hidden';
$tag_feedback_class= 'hidden';

$tag= $_GET['tag_input'];
$an= (bool)($_GET['An']?? NULL);
$pr= (bool)($_GET['Pr']?? NULL);
$nr= (bool)($_GET['Nr']?? NULL);
$fsu= (bool)($_GET['Fsu']?? NULL);
$fsh= (bool)($_GET['Fsh']?? NULL);
$psh= (bool)($_GET['Psh']?? NULL);

//filter sticky values
$sticky_an=  ($an ? 'checked' : '');
$sticky_pr= ($pr ? 'checked' : '');
$sticky_nr= ($nr ? 'checked' : '');
$sticky_psh=  ($psh ? 'checked' : '');
$sticky_fsu= ($fsu ? 'checked' : '');
$sticky_fsh= ($fsh ? 'checked' : '');
    foreach ($tagarr as $key => $value) {
      $sticky_value= ($tag == $value[0] ? 'checked' : '');
    }

if (isset($_GET['filter'])){
  if ($form_valid2) {
    $show_confirmation2 = True;
  } else {
    $sticky_ascsort = (empty($asc_sort) ? '' : 'checked');
    $sticky_pr = (empty($pr) ? '' : 'checked');
    $sticky_an = (empty($an) ? '' : 'checked');
    $sticky_nr = (empty($nr) ? '' : 'checked');
    $sticky_psh=  ($psh ? 'checked' : '');
    $sticky_fsu= ($fsu ? 'checked' : '');
    $sticky_fsh= ($fsh ? 'checked' : '');
    foreach ($tagarr as $key => $value) {
      $sticky_value= ($tag == $value[0] ? 'checked' : '');
      $break ='';
    }
  }



        //values
        $sort_i= '';
        $asc_sort2= ($sort_i == 'asc2');

        //sticky values
        $stickyasc_sort2= '';

        $sort_i = $_GET["sort_input"];
        $sort_valid = True;

        if (empty($sort_i)) {
          $sort_valid = False;
        }

        if ($sort_valid) {
          $ss = 'Database successfully sorted';
          $asc_sort2= ($sort_i == 'asc2');
          $stickyasc_sort2 = ($sort_i == 'asc2' ? 'checked' : '');
        }

        if (empty($tag) && empty($fsu) && empty($psh) && empty($fsh) && empty($an) && empty($nr) && empty($pr) && empty($sort_i)) {
          $form_valid2 = False;
          $filter_feedback_class = '';
          $sort_feedback_class = '';
      }
    }

    //filter and sort statements
        $fs= '';

    //queries
    $selects = 'SELECT * FROM plant_data';
    $wheres= '';
    $order= '';
    $filter_array= array();

    //sort statements
    if ($asc_sort2) {
      $order= ' ORDER BY plant_name ASC';
    }

        //filter array

        if ($tag) {
          //find corresponding tag from array
          $tag= strval($tag);
          $findidquery= 'SELECT id FROM tags WHERE tname = ' . '"'. $tag .'"';
          $records2 = exec_sql_query($db, $findidquery)->fetchAll();
          $tagid= $records2[0][0];
          $break= '';
          //find array of all values in plant_data that have the specific tag
          $ftagarr = exec_sql_query(
            $db,
            "SELECT
            plant_data.id AS 'plant_data.id',
            tags.id AS 'tags.id'
            FROM
            plant_data
          INNER JOIN plant_tags ON (plant_tags.plant_id == plant_data.id)
          INNER JOIN tags ON (plant_tags.tag_id == tags.id)
          WHERE plant_tags.tag_id =". $tagid . " ;",
          )->fetchAll();
          //since this is a double loop we would need two for loops
          foreach ($ftagarr as $outer) {
            foreach ($outer as $key => $inner) {
                if ($key == 0) {
                    $inner =strval($inner);
                    array_push($filter_array,  "(id ='". $inner. "')");
                    }
            }
          }
        }

        if ($an) {
          array_push($filter_array, "(pa = 'Annual')");
        }
        if ($pr) {
          array_push($filter_array, "(pa = 'Perennial')");
        }
        if ($nr) {
          array_push($filter_array, "(pa = 'Neither')");
        }
        if ($fsu) {
          array_push($filter_array, "(fsu = '1')");
        }
        if ($fsh) {
          array_push($filter_array, "(fsh = '1')");
        }
        if ($psh) {
          array_push($filter_array, "(psh = '1')");
        }

    //more than one filter
        if (count($filter_array) > 0) {
          $wheres = ' WHERE ' . implode(' OR ', $filter_array);
          $fs= 'Database successfully filtered';
        }
    // query
    $sql_query = $selects . $wheres. $order;
    $plants = exec_sql_query($db, $sql_query)->fetchAll();

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

<div class= "content">
<div class= "row">
  <div class= "stack">
  <main class= "form1">
      <h1 class= "forms"> Filter</h1>
      <p class= "confirm"> <?php echo $fs ?>
      <hr class= 'new1'>
    <form id="request-form1" method="get" action="/" novalidate>
    <div id="feedback-filter" class="feedback <?php echo $filter_feedback_class; ?>">Please select atleast one item to filter the catalog by</div>
    <h2 class= "forms"> Class: </h2>
        <?php foreach ($tagarr as $key => $value) { ?>
          <?php $value= $value[0]; ?>
                <div>
                    <input type="radio" id= <?php echo htmlspecialchars($value);?> name="tag_input" value= <?php echo htmlspecialchars($value);?> <?php echo htmlspecialchars($sticky_value);?>/>
                    <label for=<?php echo htmlspecialchars($value);?>> <?php echo htmlspecialchars($value);?> </label>
                  </div>
              <?php } ?>

      <h2 class= "forms"> Lifespan: </h2>
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
          <h2 class= "forms"> Sun Level: </h2>
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
          <h1 class= "forms" id="sort-head"> Sort</h1>
          <p class= "confirm"> <?php echo $ss ?>
          <hr class= 'new1'>
          <p id="sort_feedback" class="feedback <?php echo $sort_feedback_class; ?>">Please select an option to sort the catalog by</p>
              <div>
                <input type="radio" id="asc2" name="sort_input" value="asc2" <?php echo $stickyasc_sort2; ?> />
                <label for="asc2">Plant Name in Alphabetical Order </label>
              </div>
              <div>
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
          <?php
          foreach ($plants as $record) { ?>
            <li>
              <a href="/browse-plants/plant-page?<?php echo http_build_query(array('plant_id' => $record['plant_id'])); ?>">
                <img src="/public/uploads/plant_data/<?php echo $record['id'] . '.' . $record['file_ext']; ?>" alt="<?php echo htmlspecialchars($record['plant_name']); ?>" />
                <p><?php echo ucfirst($record['file_name']); ?></p>
              <h3 class= "center"> <?php echo htmlspecialchars($record['plant_name']); ?> </h3>
              <p class= "hidden"> <?php echo htmlspecialchars($record['plant_genus']); ?> </h3>
              </a>
            </li>
          <?php
          } ?>
        </ul>
    </section>
</div>
</div>

</body>

</html>
