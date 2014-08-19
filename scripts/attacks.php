<?php
/**
 * Created by PhpStorm.
 * User: mikeravenelle
 * Date: 8/19/14
 * Time: 10:45 AM
 */

$file = "../weapons/".$_POST['type'].".mh";
$weaponData = file($file);
$attacks = [];
foreach($weaponData as $weapon) {
    $weapon = array_map('trim', explode(",", $weapon));
    array_push($attacks,$weapon[0]);
}
echo json_encode($attacks);