
<?php //FORM 1

if (is_user_logged_in()) {

// feedback messages
$id_feedback_class = 'hidden';
$name_feedback_class = 'hidden';
$genus_feedback_class = 'hidden';
$attribute_feedback_class = 'hidden';
$img_feedback_class='hidden';
$hardi_feedback_class= 'hidden';
$class_feedback_class= 'hidden';
$ls_feedback_class= 'hidden';
$source_feedback_class= 'hidden';
$sun_feedback_class= 'hidden';
define("MAX_FILE_SIZE", 1000000);

$content= 'content';
$confirmation= 'hidden';


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
$nss= '';
$vi= '';
$pwr= '';
$source=NULL;
$filename = NULL;
$ext = NULL;
$hardi='';
$class='';
$life='';
$pr='';
$npr='';
$an='';
$fsu='';
$fsh='';
$psh='';


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
$sticky_nss='';
$sticky_vi='';
$sticky_pwr='';
$sticky_source='';
$sticky_hardi='';
$sticky_class='';
$sticky_pr='';
$sticky_npr='';
$sticky_an='';
$sticky_fsu='';
$sticky_fsh='';
$sticky_psh='';



//files
  if (isset($_POST['submit'])){
      $upload = $_FILES['jpg_file'];
      $source= $_POST['source'];
      if ($upload['error'] == UPLOAD_ERR_OK) {
      $filename = basename($upload['name']);
      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));}
        $id = $_POST['id'];
        $name = $_POST['name'];
        $genus = $_POST['genus'];
        $source = $_POST['source'];
        $hardi = $_POST['hardi'];
        $class= strtolower($_POST['class']);
        $ecp = (bool)($_POST['exploratory-constructive-play']?? NULL);
        $esp = (bool)($_POST['exploratory-sensory-play']?? NULL);
        $ep = (bool)($_POST['expressive-play']?? NULL);
        $pp = (bool)($_POST['physical-play']?? NULL);
        $ip = (bool)($_POST['imaginative-play']?? NULL);
        $rp = (bool)($_POST['restorative-play']?? NULL);
        $bp= (bool)($_POST['bio-play']?? NULL);
        $nss= (bool)($_POST['nooks']?? NULL);
        $vi= (bool)($_POST['visual-interest']?? NULL);
        $pwr= (bool)($_POST['play-with-rules']?? NULL);
        $life = $_POST['life'];
        $fsu=(bool)($_POST['fsu']?? NULL);
        $fsh=(bool)($_POST['fsh']?? NULL);
        $psh=(bool)($_POST['psh']?? NULL);
        $form1_valid = True;

        //life
        $life_exists = True;

        if (empty($life)) {
          $life_exists = False;
        }

        if ($life) {
          $pr= ($life == 'pr');
          $npr= ($life == 'npr');
          $an= ($life == 'an');
          $sticky_pr = ($life == 'pr' ? 'checked' : '');
          $sticky_an = ($life == 'an' ? 'checked' : '');
          $sticky_npr = ($life == 'nprs' ? 'checked' : ''); }

        //sun levels
        if ($fsu) {
        $fsu= 1 ;
        }
        else {
            $fsu= 0 ;
        }

        if ($psh) {
            $psh= 1 ;
            }
            else {
                $psh= 0 ;
            }

        if ($fsh) {
        $fsh= 1 ;
        }
        else {
            $fsh= 0 ;
        }

        //attributess

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

        if ($pwr) {
        $pwr= 1 ;
        }
        else {
            $pwr= 0 ;
        }


        //  form invalid if

        if (empty($pwr) && empty($vi) && empty($nss) && empty($ecp) && empty($esp) && empty($ep) && empty($pp) && empty($ip) && empty($rp) && empty($bp)) {
        $form1_valid = False;
        $attribute_feedback_class = '';
        }

        if (empty($id)) {
        $form1_valid = False;
        $id_feedback_class = '';
        }

        if (empty($ext) || $ext != 'jpg') {
          $form1_valid = False;
          $img_feedback_class = '';
          }

        if (empty($source)) {
            $form1_valid = False;
            $source_feedback_class = '';
        }

        if (empty($hardi)) {
            $form1_valid = False;
            $hardi_feedback_class = '';
        }

        if (empty($class)) {
            $form1_valid = False;
            $class_feedback_class = '';
        }


        if (empty($psh) && empty($fsh)&&empty($fsu)) {
            $form1_valid = False;
            $sun_feedback_class = '';
        }

        if (empty($life)) {
            $form1_valid = False;
            $ls_feedback_class = '';
        }

        if (empty($name)) {
        $form1_valid = False;
        $name_feedback_class = '';
        }

        if (empty($genus)) {
        $form1_valid = False;
        $genus_feedback_class = '';
        }

        if ($form1_valid) {
        $show_confirmation1 = True;
        $result = exec_sql_query(
            $db,
            "INSERT INTO plant_data(plant_id, plant_name, plant_genus, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep,s_pwr, s_bp, p_vi, c_nss, file_ext, hardi, source, pa, psh, fsu, fsh) VALUES (:id, :name, :genus, :ecp, :esp, :pp, :ip, :rp, :ep, :pwr, :bp, :vi, :nss, :file_ext, :hardi, :source, :pa, :psh, :fsu, :fsh);",
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
            ':nss' => $nss,
            ':hardi' => $hardi,
            ':file_ext' => $ext,
            ':source' => $source,
            ':pa' => $life,
            ':psh' => $psh,
            ':fsu' => $fsu,
            ':fsh' => $fsh
            )
        );
        $everythingdone = False;
        }

        if ($result) {
            $class= strtolower($class);
            $id = $db->lastInsertId('id');
            $filename = 'public/uploads/plant_data/' . $id . '.' . $ext;
            move_uploaded_file($upload["tmp_name"], $filename);
            $tagid= 0;
              //add existing tag
            $tagarr = exec_sql_query(
              $db,
              "SELECT tags.tname FROM tags",
            )->fetchAll();
            foreach ($tagarr as $index => $value)
              if ($tagarr[$index][0]== $class) {
                  $tagid= intval($index) + 1;

          }
            if ($tagid!=0){
              $tags= exec_sql_query(
                  $db,
                  "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
                  array(
                      ':plant_id' => $id,
                      ':tag_id' => $tagid
                  ));
            }
            //add new tag
            //new tag added case
            //find number of tags w max(id)
            $maxquery = exec_sql_query(
              $db,
              "SELECT MAX(id) FROM tags;",
            )->fetchAll();
            //make maxid the next value
            $maxid = intval($maxquery[0][0])+1;
            //enter new tag
            if ($tagid== 0) {
                    $tags2= exec_sql_query(
                      $db,
                      "INSERT INTO tags (id, tname) VALUES (:id, :tname);",
                      array(
                          ':id' => $maxid,
                          ':tname' => $class
                      ));
                      $tags3= exec_sql_query(
                        $db,
                        "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
                        array(
                            ':plant_id' => $id,
                            ':tag_id' => $maxid
                        ));
                      }
          $everythingdone= TRUE;

        } else {
        $img_feedback_class = '';
        $sticky_source = $source;
        $sticky_ecp = (empty($ecp) ? '' : 'checked');
        $sticky_esp = (empty($esp) ? '' : 'checked');
        $sticky_pp = (empty($pp) ? '' : 'checked');
        $sticky_rp = (empty($rp) ? '' : 'checked');
        $sticky_ip = (empty($ip) ? '' : 'checked');
        $sticky_ep = (empty($ep) ? '' : 'checked');
        $sticky_bp = (empty($bp) ? '' : 'checked');
        $sticky_vi = (empty($vi) ? '' : 'checked');
        $sticky_pwr = (empty($pwr) ? '' : 'checked');
        $sticky_nss = (empty($nss) ? '' : 'checked');
        $sticky_npr = ($life == 'Neither' ? 'checked' : '');
        $sticky_pr = ($life == 'Perennial' ? 'checked' : '');
        $sticky_an = ($life == 'Annual' ? 'checked' : '');
        $sticky_fsh = (empty($fsh) ? '' : 'checked');
        $sticky_fsu = (empty($fsu) ? '' : 'checked');
        $sticky_psh = (empty($psh) ? '' : 'checked');
        $sticky_name = $name;
        $sticky_genus = $genus;
        $sticky_class = $class;
        $sticky_hardi = $hardi;
        $sticky_id = $id;
        }
      }

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
<?php if (is_user_logged_in()) { ?>
<div class= <?php echo $content; ?>>
<?php if ($everythingdone== $False) { ?>
<main class= "form1">
<main class="pcenter2">
    <h1 class="forms"> Add Plant Data</h1>
    <hr class= 'new1'>
    <form id="request-form1" method="post" action="/add-plant" enctype="multipart/form-data" novalidate>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
          <div id="feedback-img" class="feedback <?php echo $img_feedback_class; ?>">Please enter a valid JPG image</div>
          <div class="label-input">
            <label for="upload-file">JPG File:</label>
            <input id="upload-file" type="file" name="jpg_file" accept=".jpg,image/jpg+xml" />
          </div>
          <div class="label-input">
          <div id="feedback-source" class="feedback <?php echo $source_feedback_class; ?>">Please enter a valid Plant Source</div>
          <label for="upload-source">Source:</label>
          <input id='upload-source' type="source" name="source" class="input" value="<?php echo htmlspecialchars($sticky_source); ?>" />
        </div>
          <div class="label1-input">
          <div id="feedback-id" class="feedback <?php echo $id_feedback_class; ?>">Please enter a valid Plant ID</div>
            <label for="request-id">Plant ID:</label>
            <input type="id" name="id" id="request-id" class= 'input' value="<?php echo htmlspecialchars($sticky_id); ?>" />
          </div>
          <div class="label1-input">
          <div id="feedback-name" class="feedback <?php echo $name_feedback_class; ?>">Please enter a valid Plant Name</div>
            <label for="request-name">Plant Name:</label>
            <input type="name" name="name" id="request-name" class= 'input' value="<?php echo htmlspecialchars($sticky_name); ?>" />
          </div>
          <div class="label1-input">
          <div id="feedback-genus" class="feedback <?php echo $genus_feedback_class; ?>">Please enter a valid Plant Genus, Species</div>
            <label for="request-genus">Plant Genus, Species:</label>
            <input type="genus" name="genus" id="request-genus" class= 'input' value="<?php echo htmlspecialchars($sticky_genus); ?>" />
          </div>
          <div class="label1-input">
          <div id="feedback-hardi" class="feedback <?php echo $hardi_feedback_class; ?>">Please enter a valid Plant Hardiness</div>
            <label for="request-hardi">Plant Hardiness:</label>
            <input type="hardi" name="hardi" id="request-hardi" class= 'input' value="<?php echo htmlspecialchars($sticky_hardi); ?>" />
          </div>
          <div class="label1-input">
          <div id="feedback-class" class="feedback <?php echo $class_feedback_class; ?>">Please enter a valid Plant Class</div>
            <label for="request-class">Plant Class:</label>
            <input type="class" name="class" id="request-class" class= 'input' value="<?php echo htmlspecialchars($sticky_class); ?>" />
          </div>
          <div class="label-input">
          <div id="feedback-attribute" class="feedback <?php echo $attribute_feedback_class; ?>">Please select at least one Plant Attribute.</div>
          <p> Plant Attributes: </p>
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
          </div>
          <div class="label-input">
            <input type="checkbox" name="nooks" id="nooks" <?php echo $sticky_nss; ?> />
            <label for="nooks">Creates Nooks or Secret Spaces</label>
          </div>
          <div id="feedback-life" class="feedback <?php echo $ls_feedback_class; ?>">Please select a lifespan.</div>
          <p> Plant Lifespan: </p>
          <div class="label-input">
            <input type="radio" id="prinput" value="Perennial" name="life" <?php echo $sticky_pr; ?> />
            <label for="life">Perennial</label>
          </div>
          <div class="label-input">
            <input type="radio" id="aninput" value="Annual" name="life"<?php echo $sticky_an; ?> />
            <label for="life">Annual</label>
          </div>
          <div class="label-input">
            <input type="radio" id="nprinput" value="Neither" name="life"<?php echo $sticky_npr; ?> />
            <label for="life">Neither Perennial or Annual</label>
          </div>
          <div id="feedback-sun" class="feedback <?php echo $sun_feedback_class; ?>">Please select atleast one sun level.</div>
          <p> Plant Sun Level: </p>
          <div class="label-input">
            <input type="checkbox" name="fsu" id="fsu" <?php echo $sticky_fsu; ?> />
            <label for="fsu">Full Sun</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="fsh" id="fsh" <?php echo $sticky_fsh; ?> />
            <label for="fsu">Full Shade</label>
          </div>
          <div class="label-input">
            <input type="checkbox" name="psh" id="psh" <?php echo $sticky_psh; ?> />
            <label for="psh">Partial Shade</label>
          </div>
          <div class="align-right">
            <input id="request-submit" type="submit" name="submit" value="Submit" />
          </div>
        </form>
      </main>
</main>
<?php } ?>
<?php if ($everythingdone) { ?>
    <div class=<?php echo $content?>> <p> Your plant data for <?php echo htmlspecialchars($name) ?> has been added <p> </div>
    <?php } ?>
</div>
</html>
<?php } ?>
<?php if (is_user_logged_in()==False) { ?>
  <div class= "content">
    <h2> This page is only for administrators, please login</h2>
    <?php
      echo_login_form('/browse-plants', $session_messages);
      ?>
</div>
<?php } ?>
</body>
</html>
