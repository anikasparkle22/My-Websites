<?php

$title = 'Plant Info Page';

$plant_id = $_GET['plant_id'] ?? NULL;

if ($plant_id) {
  $records = exec_sql_query(
    $db,
    "SELECT * FROM plant_data WHERE plant_id = :plant_id;",
    array(':plant_id' => $plant_id)
  )->fetchAll();

  if (count($records) > 0) {
    $plant = $records[0];

    $page_title = $plant['plant_name'] . ' - Plant Page';
  } else {
    $page_title = 'Unknown Plant Page';
  }

  $sqlquery= exec_sql_query($db,
      "SELECT
      plant_data.plant_name AS 'plant_data.plant_name',
      tags.tname AS 'tags.tname'
      FROM
      plant_data
    INNER JOIN plant_tags ON (plant_tags.plant_id == plant_data.id)
    INNER JOIN tags ON (plant_tags.tag_id == tags.id)
    WHERE plant_data.plant_id = :plant_id;",
    array(':plant_id' => $plant_id)
  )->fetchAll();}
    $class = $sqlquery[0];
?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $page_title; ?> - INFO 2300</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all" />      <title>Playful Plants</title>
    </head>


    <body>
      <?php include('includes/header.php'); ?>
    <div class= "content">
      <main class="pcenter1">
        <h2 class= "pcenter" ><?php echo $title; ?></h2>
        <?php if ($plant) { ?>
          <img class= page src="/public/uploads/plant_data/<?php echo $plant['id'] . '.' . $plant['file_ext']; ?>" alt="<?php echo htmlspecialchars($plant['plant_name']); ?>" />
          <h3 class= "pcenter" >Plant Genus: <?php $genus=htmlspecialchars($plant['plant_genus']); echo($genus); ?></p>
          </h3>
          <h3 class= "pcenter" > Plant Class: <?php echo htmlspecialchars($class['tags.tname']);?> </h3>
          <h3 class= "pcenter" > Plant Lifespan:
            <?php
              $pa = $plant['pa'];
              if ($pa== 'Neither') {
                  echo 'Neither perennial or annual' ;}
              else { echo $pa;} ?>
          </h3>
          <h3 class= "pcenter"  > Plant Hardiness: <?php echo htmlspecialchars($plant['hardi'])?>
          <h3 class= "pcenter" > Works well in: <?php
                        $fsu= (int)$plant["fsu"];
                        $fsh= (int)$plant["fsh"];
                        $psh= (int)$plant["psh"];
                        if ($fsu==1) {
                          echo "full sun";
                          if ($fsh + $psh == 2){
                            echo ", " ;
                          }
                          if ($fsh + $psh == 1){
                            echo " and ";
                          }
                        }
                        if ($fsh==1) {
                          echo "full shade";
                          if ($psh == 1){
                            echo " and ";
                          }
                        }
                        if ($psh==1) {
                          echo "partial shade";
                        }?> </h3>
    </main>
        <?php
        } if (!$plant) { ?>

          <p>The plant you were looking for does not exist. Find the plant from the <a href="/browse-plants">plant listing</a>.</p>

        <?php
        } ?>
   </div>

    </body>

    </html>
