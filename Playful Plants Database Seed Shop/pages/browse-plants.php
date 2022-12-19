<?php


$title = 'Plant Database';
$plant_database_class = 'active_page';
$show_form = True;

if (is_user_logged_in()) {


  //form 2 fitering and sorting

    $form2_valid = False;
    $filter_feedback_class= 'hidden';
    $sort_feedback_class= 'hidden';

    $fecp = (bool)($_GET['fexploratory-constructive-play']?? NULL);
    $fesp = (bool)($_GET['fexploratory-sensory-play']?? NULL);
    $fep = (bool)($_GET['fexpressive-play']?? NULL);
    $fpp = (bool)($_GET['fphysical-play']?? NULL);
    $fip = (bool)($_GET['fimaginative-play']?? NULL);
    $frp = (bool)($_GET['frestorative-play'])?? NULL;
    $fbp= (bool)($_GET['fbio-play']?? NULL);
    $fnss= (bool)($_GET['fnooks']?? NULL);
    $fvi= (bool)($_GET['fvisual-interest']?? NULL);
    $fpwr= (bool)($_GET['fplay-with-rules']?? NULL);

  //filter sticky values
    $sticky_fecp=  ($fecp ? 'checked' : '');
    $sticky_fesp= ($fesp ? 'checked' : '');
    $sticky_fep= ($fep ? 'checked' : '');
    $sticky_fpp= ($fpp ? 'checked' : '');
    $sticky_fip= ($fip ? 'checked' : '');
    $sticky_frp= ($frp ? 'checked' : '');
    $sticky_fbp= ($fbp ? 'checked' : '');
    $sticky_fnss= ($fnss ? 'checked' : '');
    $sticky_fvi= ($fvi ? 'checked' : '');
    $sticky_fpwr= ($fpwr ? 'checked' : '');

    if (isset($_GET['filter'])){
        if ($form_valid2) {
          $show_confirmation2 = True;
        } else {
          $sticky_ascsort = (empty($asc_sort) ? '' : 'checked');
          $sticky_fecp = (empty($fecp) ? '' : 'checked');
          $sticky_fesp = (empty($fesp) ? '' : 'checked');
          $sticky_fpp = (empty($fpp) ? '' : 'checked');
          $sticky_frp = (empty($frp) ? '' : 'checked');
          $sticky_fip = (empty($fip) ? '' : 'checked');
          $sticky_fep = (empty($fep) ? '' : 'checked');
          $sticky_fbp = (empty($fbp) ? '' : 'checked');
          $sticky_fvi = (empty($fvi) ? '' : 'checked');
          $sticky_fpwr = (empty($fpwr) ? '' : 'checked');
          $sticky_fnss = (empty($fnss) ? '' : 'checked');
        }

        //values
        $sort_i= '';
        $asc_sort1= ($sort_i == 'asc1');
        $asc_sort2= ($sort_i == 'asc2');
        $asc_sort3= ($sort_i == 'asc3');

        //sticky values
        $stickyasc_sort1 = '';
        $stickyasc_sort2= '';
        $stickyasc_sort3= '';

        $sort_i = $_GET["sort_input"];
        $sort_valid = True;

        if (empty($sort_i)) {
          $sort_valid = False;
        }

        if ($sort_valid) {
          $ss= "Database successfully sorted";
          $asc_sort1= ($sort_i == 'asc1');
          $asc_sort2= ($sort_i == 'asc2');
          $asc_sort3= ($sort_i == 'asc3');
          $stickyasc_sort1 = ($sort_i == 'asc1' ? 'checked' : '');
          $stickyasc_sort2 = ($sort_i == 'asc2' ? 'checked' : '');
          $stickyasc_sort3 = ($sort_i == 'asc3' ? 'checked' : '');
        }

        if (empty($fpwr) && empty($fvi) && empty($fnss) && empty($fecp) && empty($fesp) && empty($fep) && empty($fpp) && empty($fip) && empty($frp) && empty($fbp) && empty($fvi) && empty($fnss) && empty($sort_i)) {
          $form_valid2 = False;
          $filter_feedback_class = '';
          $sort_feedback_class = '';
      }
    }

    //filter confirm
    $fs= '';

    // query pieces
    $selects = 'SELECT * FROM plant_data';
    $wheres= '';
    $order= '';
    $filter_array= array();
    $fstate_array= array();
    //order array
    if ($asc_sort1) {
      $order= ' ORDER BY plant_id ASC';
    }

    if ($asc_sort2) {
      $order= ' ORDER BY plant_name ASC';
    }

    if ($asc_sort3) {
      $order= ' ORDER BY plant_genus ASC';
    }

    //filter array
    if ($fecp) {
      array_push($filter_array, "(s_ecp = '1')");
      //array_push($fstate_array, "Exploratory Constructive Play");
    }
    if ($fesp) {
      array_push($filter_array, "(s_esp = '1')");
      //array_push($fstate_array, "Exploratory Sensory Play");
    }
    if ($fpp) {
      array_push($filter_array, "(s_pp = '1')");
      //array_push($fstate_array, "Physical Play");
    }
    if ($frp) {
      array_push($filter_array, "(s_rp = '1')");
      //array_push($fstate_array, "Restorative Play");
    }
    if ($fip) {
      array_push($filter_array, "(s_ip = '1')");
      //array_push($fstate_array, "Imaginative Play");
    }
    if ($fep) {
      array_push($filter_array, "(s_ep = '1')");
      //array_push($fstate_array, "Expressive Play");
    }
    if ($fbp) {
      array_push($filter_array, "(s_bp = '1')");
      //array_push($fstate_array, "Bio Play");
    }
    if ($fvi) {
      array_push($filter_array, "(p_vi = '1')");
      //array_push($fstate_array, "Visual Interest");
    }
    if ($fpwr) {
      array_push($filter_array, "(s_pwr = '1')");
      //array_push($fstate_array, "Play with Rules");
    }
    if ($fnss) {
      array_push($filter_array, "(c_nss = '1')");
      //array_push($fstate_array, "Creates Nooks/Secret Spaces");
    }

    if (count($filter_array) > 0) {
      $wheres = ' WHERE ' . implode(' AND ', $filter_array);
      $fs= 'Database successfully filtered';
    }

    if (isset($_GET['delete'])){
      // deletion query
      //delete plant_tags and entries
      $delid= $_GET['delete'];
      $delete_query= 'DELETE FROM plant_data WHERE id ='. $delid;
      $delete_query2= 'DELETE FROM plant_tags WHERE plant_id ='. $delid;
      unlink( "public/uploads/plant_data/".$delid.".jpg" );
      $records = exec_sql_query($db, $delete_query)->fetchAll();
      $records2 = exec_sql_query($db, $delete_query2)->fetchAll();}




    //query all
    $sql_query = $selects . $wheres. $order;
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
<div class= "content">
<?php if (is_user_logged_in()) { ?>
<div class= "row">
  <div class= "stack">
  <form class="search" action="/browse-plants" method="get" novalidate>
  <main class= "form2">
      <h1 class= "forms"> Filter</h1>
      <p class= "confirm"> <?php echo $fs ?>
      <hr class= 'new1'>
    <form id="request-form2" method="get" action="/browse-plants" novalidate>
    <div id="feedback-filter" class="feedback <?php echo $filter_feedback_class; ?>">Please select atleast one item to filter the catalog by</div>
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
          <div class="form-group label-input" role="group" aria-labelledby="sort-head">
          <h1 class= "forms" id="sort-head"> Sort</h1>
          <p class= "confirm"> <?php echo $ss ?>
          <hr class= 'new1'>
          <p id="sort_feedback" class="feedback <?php echo $sort_feedback_class; ?>">Please select an option to sort the catalog by</p>
            <div>
              <div>
                <input type="radio" id="asc1" name="sort_input" value="asc1" <?php echo $stickyasc_sort1; ?> />
                <label for="asc1">Plant ID in Alphabetical Order </label>
              </div>
              <div>
                <input type="radio" id="asc2" name="sort_input" value="asc2" <?php echo $stickyasc_sort2; ?> />
                <label for="asc2">Plant Name in Alphabetical Order </label>
              </div>
              <div>
                <input type="radio" id="asc3" name="sort_input" value="asc3" <?php echo $stickyasc_sort3; ?> />
                <label for="asc3">Plant Genus in Alphabetical Order</label>
              </div>
        </div>
          <div class="align-right">
            <input id="request-submit" type="submit" name="filter" value="Submit" />
          </div>
        </form>
      </main>
  </div>

  <main class="plant-data">
  <h1 class= pdc> Plant Data Catalog
  <a href= "/add-plant">
  <button class="add" name= "add plant information" label="add plant information" >
    <h3>Add Plant Form</h3>
    </button>
  <a>
  </h1>
  <div class="plants">
        <ul>
          <?php
          foreach ($records as $record) { ?>
              <div class="tile-header" >
              <h2>
              <?php  $name=htmlspecialchars($record['plant_name']); ?>
              <a href="/browse-plants/plant-page?<?php echo http_build_query(array('plant_id' => $record['plant_id'])); ?>" aria-label= plant-page> <?php echo($name); ?> </h2> </a>
              </div>
              <div class= "tile-attrib">
                  <li> <p>Plant genus: <?php $genus=htmlspecialchars($record['plant_genus']); echo($genus); ?></p> </li>
                  <li> <p>Plant id: <?php $id=htmlspecialchars($record['plant_id']); echo($id);?></h3> </p> </li>
                  <li> <?php
                        $vi= (int)$record["p_vi"];
                        if ($vi==0) {
                          echo "Does not provide visual interest";
                        }
                        if ($vi==1) {
                          echo "Provides visual interest";
                        }
                        ?>
                  </li>
                  <li> <p>Supports: <?php
                          $yes1 = (int)$record["s_ecp"];
                          $yes2 = (int)$record["s_esp"];
                          $yes3 = (int)$record["s_pp"];
                          $yes4 = (int)$record["s_ip"];
                          $yes5 = (int)$record["s_rp"];
                          $yes6 = (int)$record["s_ep"];
                          $yes7 = (int)$record["s_pwr"];
                          $yes8 = (int)$record["s_bp"];
                          if ($yes1== 1) {
                            echo "exploratory constructive play";
                            if ($yes2 + $yes3 + $yes4 + $yes5 + $yes6 +$yes7 +$yes8 != 0){
                              echo ", " ;
                            }
                            if ($yes2 + $yes3 + $yes4 + $yes5 + $yes6 +$yes7 +$yes8 == 1){
                              echo "and ";
                            }
                          }
                          if ($yes2 == 1) {
                            echo "exploratory sensory play";
                            if ( $yes3 + $yes4 + $yes5 + $yes6 +$yes7 +$yes8 != 0){
                              echo ", " ;
                            }
                            if ( $yes3 + $yes4 + $yes5 + $yes6 +$yes7 +$yes8 == 1){
                              echo "and ";
                            }
                          }
                          if ($yes3==1) {
                            echo "physical play";
                            if ($yes4 + $yes5 + $yes6 +$yes7 +$yes8 != 0){
                              echo ", " ;
                            }
                            if ($yes4 + $yes5 + $yes6 +$yes7 +$yes8 == 1){
                              echo "and ";
                            }
                          }
                          if ($yes4==1) {
                            echo "imaginative play";
                            if ($yes5 + $yes6 +$yes7 +$yes8 != 0){
                              echo ", " ;
                            }
                            if ($yes5 + $yes6 +$yes7 +$yes8 == 1){
                              echo "and ";
                            }
                          }
                          if ($yes5==1) {
                            echo "restorative play";
                            if ($yes6 +$yes7 +$yes8 != 0){
                              echo ", " ;
                            }
                            if ($yes6 +$yes7 +$yes8 == 1){
                              echo "and ";
                            }
                          }
                          if ($yes6==1) {
                            echo "expressive play";
                            if ($yes7 +$yes8 != 0){
                              echo ", " ;
                            }
                            if ($yes7 +$yes8 == 1){
                              echo "and ";
                            }
                          }

                          if ($yes7==1) {
                            echo "play with rules";
                            if ($yes8 != 0){
                              echo ", " ;
                            }
                            if ($yes8 == 1){
                              echo "and ";
                            }
                          }

                          if ($yes8==1) {
                            echo "bio play";
                          }
                         ?> </p> </li>
                  <li> <?php
                        $nss= (int)$record["c_nss"];
                        if ($nss==0) {
                          echo "Does not create nooks or secret spaces";
                        }
                        if ($nss==1) {
                          echo "Creates nooks or secret spaces";
                        }
                        ?>
              </div>
             <div class= 'form4'>
              <form class="delete" method="get" action="/browse-plants" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($name)?>?')" novalidate>
              <button value="<?php echo htmlspecialchars($record['id']) ?>" class="end" type="submit" name= "delete" aria-label="delete <?php echo htmlspecialchars($name);?>?" title="delete <?php echo htmlspecialchars($name);?>?">
               <img src="/public/images/deleteicon.png" alt="delete icon" />
               </button>
               </form>


               <form class="edit" method="get" action="/browse-plants/edit" novalidate>
              <input type="hidden" name="plant" value="<?php echo htmlspecialchars($record['plant_id']); ?>" />
               <button class="end" type="submit" aria-label="edit <?php echo htmlspecialchars($name); ?>?" title="edit <?php echo htmlspecialchars($name); ?>?">
                        <img src="/public/images/editicon.jpg" alt="edit icon" />
                      </button>
                </button>
                </form>
             </div>
            <hr>
          <?php } ?>
          </ul>
    </main>
</div>
      </section>

  </div>
 </div>
</body>
<?php } ?>
<?php if (is_user_logged_in()==False) { ?>
  <div class= "content">
    <h2> This page is only for administrators, please login</h2>
    <?php
      echo_login_form('/browse-plants', $session_messages);
      ?>
</div>
<?php } ?>
</html>
