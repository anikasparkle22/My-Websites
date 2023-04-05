<?php
header("Content-type: text/css");
$toxins = exec_sql_query(
    $db,
    "SELECT * FROM Toxins1_Sheet1;"
  )->fetchAll();

#get the values
$new_array= [];
$n=0;
foreach ($toxins as $toxin) {
$los= (float) $toxin['Limit_of_Safety_g_g'];
$s1= (float) $toxin['Simulated_1_g_g'];
$s2= (float) $toxin['Simulated_2_g_g'];
#get a random number that stands for the difference in percentage from the los
$diff= (float) ($los - (($s1+$s2)/2));
if($los != 0){
$diff= $diff/ $los;
}
$balance= 53 * $diff;
$value = 206- $balance;
$value= intval($value);
array_push($new_array, $value);
#^above represents the green-yellow threshold value
}
#for threshold
$new_array2= [];
foreach ($toxins as $toxin) {
$weight= (float) $toxin['Molecular_Weight_g_mol'];
$opacity= (float) $weight/700;
if ($opacity >1) {
  $opacity = 1;
}
array_push($new_array2, $opacity);
}
$n=1;
?>

<?php foreach ($toxins as $key => $toxin) { ?>
li:nth-child(<?=$key+1?>){
  margin-top: 60px;
  margin-left: 60px;
  width: 104px;
  height: 60px;
  border-color: rgb(<?=$new_array[$key]?>, 206, 66, <?=$new_array2[$key]?>);
  background-color: rgb(<?=$new_array[$key]?>, 206, 66, <?=$new_array2[$key]?>);
  position: relative;
  display: inline-block;
}
<?php }?>

<?php foreach ($toxins as $key => $toxin) { ?>
li:nth-child(<?=$key+1?>):before {
  content: " ";
  width: 0; height: 0;
  border-bottom: 30px solid;
  border-color: inherit;
  border-left: 52px solid transparent;
  border-right: 52px solid transparent;
  position: absolute;
  top: -30px;
}

<?php }?>

<?php foreach ($toxins as $key => $toxin) { ?>
li:nth-child(<?=$key+1?>):after {
  content: "";
  width: 0;
  position: absolute;
  bottom: -30px;
  border-top: 30px solid;
  border-color: inherit;
  border-left: 52px solid transparent;
  border-right: 52px solid transparent;
}

<?php }?>

p {
  font-size: 12px;
  text-align: center;
}

body {
  background: white;
}

ul {
  list-style-type: none;
  padding: 0;
}

@media (prefers-color-scheme: dark) {
  body {
    background: black;
  }
  p{
    color: white;
  }
