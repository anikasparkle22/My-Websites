<?php

$db = open_sqlite_db('db/site.sqlite');

$title = 'Plant Database';
$plant_database_class = 'active_page';

// initial page state
$show_form = True;
$form1_valid = False;

//FORM 1

// feedback message CSS classes
$id_feedback_class = 'hidden';
$name_feedback_class = 'hidden';
$genus_feedback_class = 'hidden';
$attribute_feedback_class = 'hidden';

//confirmation message
$confirm1= 'hidden';


// Add Data values
$id='';
$name = '';
$genus= '';
$ecp = '';
$esp = '';
$ep = '';
$pp = '';
$ip = '';
$rp = '';
$bp= '';
$cs = '';
$nss= '';
$vi= '';
$lpp= '';
$pwr= '';

// Add Data sticky values
$sticky_id='';
$sticky_name='';
$sticky_genus='';
$sticky_ecp= '';
$sticky_esp= '';
$sticky_ep='';
$sticky_pp='';
$sticky_ip='';
$sticky_rp='';
$sticky_bp='';
$sticky_cs='';
$sticky_nss='';
$sticky_vi='';
$sticky_lppp='';
$sticky_pwr='';

//Did the user submit the form 1?
  if (isset($_POST['submit'])){
    // Get HTTP request user data from Add Data Form
    $id = $_POST['id']; // untrusted
    $name = $_POST['name']; // untrusted
    $genus = $_POST['genus']; // untrusted
    $ecp = (bool)($_POST['exploratory-constructive-play']?? NULL); // untrusted
    $esp = (bool)($_POST['exploratory-sensory-play']?? NULL); // untrusted
    $ep = (bool)($_POST['expressive-play']?? NULL); // untrusted
    $pp = (bool)($_POST['physical-play']?? NULL); // untrusted
    $ip = (bool)($_POST['imaginative-play']?? NULL); // untrusted
    $rp = (bool)($_POST['restorative-play']?? NULL); // untrusted
    $bp= (bool)($_POST['bio-play']?? NULL);
    $cs = (bool)($_POST['climb-swing']?? NULL);
    $nss= (bool)($_POST['nooks']?? NULL);
    $vi= (bool)($_POST['visual-interest']?? NULL);
    $lppp= (bool)($_POST['play-props']?? NULL);
    $pwr= (bool)($_POST['play-with-rules']?? NULL);
    $form1_valid = True;

        //set as either a 0 or 1
    if ($ecp) {
      $ecp= 1 ;
    }
      else {
        $ecp= 0 ;
    }

    if ($esp) {
      $esp= 1 ;
    }
      else {
        $esp= 0 ;
    }

    if ($ep) {
      $ep= 1 ;
    }
      else {
        $ep= 0 ;
    }

    if ($pp) {
      $pp= 1 ;
    }
      else {
        $pp= 0 ;
    }

    if ($ip) {
      $ip= 1 ;
    }
      else {
        $ip= 0 ;
    }

    if ($rp) {
      $rp= 1 ;
    }
      else {
        $rp= 0 ;
    }

    if ($bp) {
      $bp= 1 ;
    }
      else {
        $bp= 0 ;
    }

    if ($cs) {
      $cs= 1 ;
    }
      else {
        $cs= 0 ;
    }

    if ($nss) {
      $nss= 1 ;
    }
      else {
        $nss= 0 ;
    }

    if ($vi) {
      $vi= 1 ;
    }
      else {
        $vi= 0 ;
    }

    if ($lppp) {
      $lppp= 1 ;
    }
      else {
        $lppp= 0 ;
    }

    if ($pwr) {
      $pwr= 1 ;
    }
      else {
        $pwr= 0 ;
    }


    // Was at least one check box, checked?
    if (empty($pwr) && empty($lppp) && empty($vi) && empty($nss) && empty($cs)&& empty($ecp) && empty($esp) && empty($ep) && empty($pp) && empty($ip) && empty($rp) && empty($bp)) {
      $form1_valid = False;
      $attribute_feedback_class = '';
    }

    if (empty($id)) {
      $form1_valid = False;
      $id_feedback_class = '';
    }

    // Name is required. Is it empty?
    if (empty($name)) {
      $form1_valid = False;
      $name_feedback_class = '';
    }

    if (empty($genus)) {
      $form1_valid = False;
      $genus_feedback_class = '';
    }

    if ($form1_valid) {
      // form is valid, hide form, show confirmation page
      $show_confirmation1 = True;
      // insert new record into database
      $result = exec_sql_query(
        $db,
        "INSERT INTO plant_data(plant_id, plant_name, plant_genus, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep,s_pwr, s_bp, p_vi, p_lppp, o_cs, c_nss) VALUES (:id, :name, :genus, :ecp, :esp, :pp, :ip, :rp, :ep, :pwr, :bp, :vi, :lppp, :cs, :nss);",
        array(
          ':id' => $id,
          ':name' => $name,
          ':genus' => $genus,
          ':ecp' => $ecp,
          ':esp' => $esp,
          ':pp' => $pp,
          ':ip' => $ip,
          ':rp' => $rp,
          ':ep' => $ep,
          ':pwr' => $pwr,
          ':bp' => $bp,
          ':vi' => $vi,
          ':lppp' => $lppp,
          ':cs' => $cs,
          ':nss' => $nss,
        )
      );

      // did the insert into the database succeed?
      if ($result) {
        // record inserted!
        $record_inserted = True;
        $confirm1= '';
      }

    } else {
      // form is invalid, set sticky values
      $sticky_ecp = (empty($ecp) ? '' : 'checked');
      $sticky_esp = (empty($esp) ? '' : 'checked');
      $sticky_pp = (empty($pp) ? '' : 'checked');
      $sticky_rp = (empty($rp) ? '' : 'checked');
      $sticky_ip = (empty($ip) ? '' : 'checked');
      $sticky_ep = (empty($ep) ? '' : 'checked');
      $sticky_bp = (empty($bp) ? '' : 'checked');
      $sticky_vi = (empty($vi) ? '' : 'checked');
      $sticky_pwr = (empty($pwr) ? '' : 'checked');
      $sticky_cs = (empty($cs) ? '' : 'checked');
      $sticky_lppp = (empty($lppp) ? '' : 'checked');
      $sticky_nss = (empty($nss) ? '' : 'checked');
      $sticky_name = $name; // tainted
      $sticky_genus = $genus;
      $sticky_id = $id;
    }
  }

  //FORM 2-  Fitering and Sorting

    $form2_valid = False;
    $filter_feedback_class= 'hidden';
    $sort_feedback_class= 'hidden';

    // Get HTTP request user data from Filter Form (untrusted values)
    $fecp = (bool)($_GET['fexploratory-constructive-play']?? NULL);
    $fesp = (bool)($_GET['fexploratory-sensory-play']?? NULL);
    $fep = (bool)($_GET['fexpressive-play']?? NULL);
    $fpp = (bool)($_GET['fphysical-play']?? NULL);
    $fip = (bool)($_GET['fimaginative-play']?? NULL);
    $frp = (bool)($_GET['frestorative-play'])?? NULL;
    $fbp= (bool)($_GET['fbio-play']?? NULL);
    $fcs = (bool)($_GET['fclimb-swing']?? NULL);
    $fnss= (bool)($_GET['fnooks']?? NULL);
    $fvi= (bool)($_GET['fvisual-interest']?? NULL);
    $flppp= (bool)($_GET['fplay-props']?? NULL);
    $fpwr= (bool)($_GET['fplay-with-rules']?? NULL);

  //Filter sticky values
    $sticky_fecp=  ($fecp ? 'checked' : '');
    $sticky_fesp= ($fesp ? 'checked' : '');
    $sticky_fep= ($fep ? 'checked' : '');
    $sticky_fpp= ($fpp ? 'checked' : '');
    $sticky_fip= ($fip ? 'checked' : '');
    $sticky_frp= ($frp ? 'checked' : '');
    $sticky_fbp= ($fbp ? 'checked' : '');
    $sticky_fcs= ($fcs ? 'checked' : '');
    $sticky_fnss= ($fnss ? 'checked' : '');
    $sticky_fvi= ($fvi ? 'checked' : '');
    $sticky_flppp= ($flppp ? 'checked' : '');
    $sticky_fpwr= ($fpwr ? 'checked' : '');

    if (isset($_GET['filter'])){

        //if valid then show confirmation and execute db
        if ($form_valid2) {
          $show_confirmation2 = True;
        //else hold sticky values
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
          $sticky_fcs = (empty($fcs) ? '' : 'checked');
          $sticky_flppp = (empty($flppp) ? '' : 'checked');
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

        // Get HTTP request user data
        $sort_i = $_GET["sort_input"]; // untrusted
        // Assume form is valid
        $sort_valid = True;

        // bouquet is required. Is it empty?
        if (empty($sort_i)) {
          $sort_valid = False;
        }

        if ($sort_valid) {
          $show_confirmation = True;
          $asc_sort1= ($sort_i == 'asc1');
          $asc_sort2= ($sort_i == 'asc2');
          $asc_sort3= ($sort_i == 'asc3');
          $stickyasc_sort1 = ($sort_i == 'asc1' ? 'checked' : '');
          $stickyasc_sort2 = ($sort_i == 'asc2' ? 'checked' : '');
          $stickyasc_sort3 = ($sort_i == 'asc3' ? 'checked' : '');
        }

        //check if entire form empty and show feedback only then
        if (empty($asc_sort) && empty($fpwr) && empty($flppp) && empty($fvi) && empty($fnss) && empty($fcs)&& empty($fecp) && empty($fesp) && empty($fep) && empty($fpp) && empty($fip) && empty($frp) && empty($fbp) && empty($sort_i)) {
          $form_valid2 = False;
          $filter_feedback_class = '';
          $sort_feedback_class = '';
      }
    }

    //filter and sort statements
    $fs= '';
    $ss= '';

    // query pieces
    $selects = 'SELECT * FROM plant_data';
    $wheres= '';
    $order= '';
    $filter_array= array();
    $fstate_array= array();
    //order array
    if ($asc_sort1) {
      $order= ' ORDER BY plant_id ASC';
      $ss = 'Database sorted by: Alphabetical Order of Plant ID';
    }

    if ($asc_sort2) {
      $order= ' ORDER BY plant_name ASC';
      $ss = 'Database sorted by: Alphabetical Order of Plant Name';
    }

    if ($asc_sort3) {
      $order= ' ORDER BY plant_genus ASC';
      $ss = 'Database sorted by: Alphabetical Order of Plant Genus';
    }

    //filter array
    if ($fecp) {
      array_push($filter_array, "(s_ecp = '1')");
      array_push($fstate_array, "Exploratory Constructive Play");
    }
    if ($fesp) {
      array_push($filter_array, "(s_esp = '1')");
      array_push($fstate_array, "Exploratory Sensory Play");
    }
    if ($fpp) {
      array_push($filter_array, "(s_pp = '1')");
      array_push($fstate_array, "Physical Play");
    }
    if ($frp) {
      array_push($filter_array, "(s_rp = '1')");
      array_push($fstate_array, "Restorative Play");
    }
    if ($fip) {
      array_push($filter_array, "(s_ip = '1')");
      array_push($fstate_array, "Imaginative Play");
    }
    if ($fep) {
      array_push($filter_array, "(s_ep = '1')");
      array_push($fstate_array, "Expressive Play");
    }
    if ($fbp) {
      array_push($filter_array, "(s_bp = '1')");
      array_push($fstate_array, "Bio Play");
    }
    if ($fvi) {
      array_push($filter_array, "(p_vi = '1')");
      array_push($fstate_array, "Visual Interest");
    }
    if ($fpwr) {
      array_push($filter_array, "(s_pwr = '1')");
      array_push($fstate_array, "Play with Rules");
    }
    if ($fcs) {
      array_push($filter_array, "(o_cs = '1')");
      array_push($fstate_array, "Climbing/Swinging Opportunities");
    }
    if ($flppp) {
      array_push($filter_array, "(p_lppp = '1')");
      array_push($fstate_array, "Provides Loose Parts");
    }
    if ($fnss) {
      array_push($filter_array, "(c_nss = '1')");
      array_push($fstate_array, "Creates Nooks/Secret Spaces");
    }

    //more than one filter case
    if (count($filter_array) > 0) {
      $wheres = ' WHERE ' . implode(' AND ', $filter_array);
      $fs= 'Database filtered by: '. implode (', ', $fstate_array);
    }

    // build the final query
    $sql_query = $selects . $wheres. $order;
    // query grades table with built query
    $records = exec_sql_query($db, $sql_query)->fetchAll();

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
<main class="plant data">
  <h1> Plant Data Catalog </h1>
  <p class= 'a1'> <?php echo $ss ?> </p>   <p class= 'a2'> <?php echo $fs?> </p>
  <table>
    <tr>
    <th class="column_plant_name">Plant ID</th>
    <th class="column_plant_name">Plant Name</th>
        <th class="column_plant_genus">Plant Genus, Species</th>
        <th class="column_s_ecp">Supports Exploratory Constructive Play?</th>
        <th class="column_s_esp">Supports Exploratory Sensory Play?</th>
        <th class="column_s_pp">Supports Physical Play?</th>
        <th class="column_s_ip">Supports Imaginative Play?</th>
        <th class="column_s_rp">Supports Restorative Play?</th>
        <th class="column_s_ep">Supports Expressive Play?</th>
        <th class="column_s_pwr">Supports Play with Rules?</th>
        <th class="column_s_bp">Supports Bio Play?</th>
        <th class="column_s_vi">Provides Visual Interest?</th>
        <th class="column_p_lpppp">Provides Lose Parts/Play Props?</th>
        <th class="column_o_cs">Supports Climbing and Swinging?</th>
        <th class="column_c_nss">Creates Nooks or Secret Spaces?</th>

    </tr>
    <?php
     // write a table row for each record
     foreach ($records as $record) { ?>
      <tr>
          <td><?php echo htmlspecialchars($record["plant_id"]); ?></td>
          <td><?php echo htmlspecialchars($record["plant_name"]); ?></td>
          <td><?php echo htmlspecialchars($record["plant_genus"]); ?></td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_ecp"];
                  if ($yes== 1) {
                    echo "✓";
                  }
            ?>
            </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_esp"];
                  if ($yes == 1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_pp"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_ip"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_rp"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_ep"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_pwr"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["s_bp"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["p_vi"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["p_lppp"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["o_cs"];
                  if ($yes==1) {
                    echo "✓";
                  }
            ?>
          </td>
          <td> <?php
                // display numerical value as check
                $yes = (int)$record["c_nss"];
                  if ($yes==1) {
                    echo "✓";
                  }
             ?>
          </td>
      </tr>
      <?php } ?>
    </table>
    </main>

    <div class= 'row' >
    <main class= "form1">
    <h2 class="forms"> Add Plant Data to the Catalog </h2>
    <form id="request-form1" method="post" action="/browse-plants" novalidate>
          <div class="label1-input">
            <label for="request-id">Plant ID:</label>
            <div id="feedback-id" class="feedback <?php echo $id_feedback_class; ?>">Please enter a valid Plant ID</div>
            <input type="id" name="id" id="request-id" class= 'input' value="<?php echo htmlspecialchars($sticky_id); ?>" />
          </div>
          <div class="label1-input">
            <label for="request-name">Plant Name:</label>
            <div id="feedback-name" class="feedback <?php echo $name_feedback_class; ?>">Please enter a valid Plant Name</div>
            <input type="name" name="name" id="request-name" class= 'input' value="<?php echo htmlspecialchars($sticky_name); ?>" />
          </div>
          <div class="label1-input">
            <label for="request-genus">Plant Genus, Species:</label>
            <div id="feedback-genus" class="feedback <?php echo $genus_feedback_class; ?>">Please enter a valid Plant Genus, Species</div>
            <input type="genus" name="genus" id="request-genus" class= 'input' value="<?php echo htmlspecialchars($sticky_genus); ?>" />
          </div>
          <div class="label-input">
          <p> Plant Attributes: </p>
          <div id="feedback-attribute" class="feedback <?php echo $attribute_feedback_class; ?>">Please select at least one Plant Attribute.</div>
            <input type="checkbox" name="exploratory-constructive-play" id="exploratory-constructive-play" <?php echo $sticky_ecp; ?> />
            <label for="exploratory-constructive-play">Supports Exploratory Constructive Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="exploratory-sensory-play" id="exploratory-sensory-play" <?php echo $sticky_esp; ?> />
            <label for="exploratory-sensory-play">Supports Exploratory Sensory Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="physical-play" id="physical-play" <?php echo $sticky_pp; ?> />
            <label for="physical-play">Supports Physical Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="imaginative-play" id="imaginative-play" <?php echo $sticky_ip; ?> />
            <label for="imaginative-play">Supports Imaginative Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="restorative-play" id="restorative-play" <?php echo $sticky_rp; ?> />
            <label for="restorative-play">Supports Restorative Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="expressive-play" id="expressive-play" <?php echo $sticky_ep; ?> />
            <label for="expressive-play">Supports Expressive Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="bio-play" id="bio-play" <?php echo $sticky_bp; ?> />
            <label for="bio-play">Supports Bio Play</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="play-with-rules" id="play-with-rules" <?php echo $sticky_pwr; ?> />
            <label for="play-with-rules">Supports Play with Rules</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="visual-interest" id="visual-interest" <?php echo $sticky_vi; ?> />
            <label for="visual-interest">Provides Visual Interest</label>
            <div class="label-input">
            <input type="checkbox" name="play-props" id="play-props" <?php echo $sticky_lppp; ?> />
            <label for="play-props">Provides Loose Parts Play Props </label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="climb-swing" id="climb-swing" <?php echo $sticky_cs; ?> />
            <label for="climb-swing">Provides Opportunities for Climbing/Swinging </label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="nooks" id="nooks" <?php echo $sticky_nss; ?> />
            <label for="nooks">Creates Nooks or Secret Spaces</label>
          </div>
          <div class="align-right">
            <input id="request-submit" type="submit" name="submit" value="Submit" />
          </div>
        </form>
        <div id="confirmation1" class="confirm <?php echo $confirm1; ?>">Your plant data for <?php echo htmlspecialchars($name) ?> has been added</div>
      </main>

      <main class= "form2">
      <h2 class= "forms"> Filter the Catalog by</h2>
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
            <div class="label-input">
            <input type="checkbox" name="fplay-props" id="fplay-props" <?php echo $sticky_flppp; ?> />
            <label for="fplay-props">Provides Loose Parts Play Props </label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="fclimb-swing" id="fclimb-swing" <?php echo $sticky_fcs; ?> />
            <label for="fclimb-swing">Provides Opportunities for Climbing and Swinging </label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="fnooks" id="fnooks" <?php echo $sticky_fnss; ?> />
            <label for="fnooks">Creates Nooks or Secret Spaces</label>
          </div>
          <div class="form-group label-input" role="group" aria-labelledby="sort-head">
          <h2 class= "forms" id="sort-head"> Sort the Catalog by</h2>
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
      </section>

  </div>
 </div>
</body>

</html>
