<?php
$title = 'Toxins Website';


$form1_valid = False;

//query toxins data
$toxins = exec_sql_query(
  $db,
  "SELECT * FROM Toxins1_Sheet1;"
)->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Toxins</title>
  <link rel="stylesheet" type="text/css" href="public/styles/site.php"/>
</head>


  <section class="gallery">
  <main class="toxins-data">
        <ul>
          <?php
          foreach ($toxins as $record) { ?>
            <li>
              <p class= "center"> <?php echo htmlspecialchars($record['COMPOUND']); ?> </p>
            </li>
          <?php
          } ?>
        </ul>
        </main>
    </section>
</div>
</div>

</body>

</html>
