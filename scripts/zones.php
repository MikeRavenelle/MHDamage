<?php
/**
 * Created by PhpStorm.
 * User: mikeravenelle
 * Date: 8/19/14
 * Time: 10:45 AM
 */

$file = "../monsters/".$_POST['monster'].".mh";
$zoneData = file($file);
$zones = [];
foreach($zoneData as $zone) {
    $zone = array_map('trim', explode(" ", $zone));
    $zone[0] = str_replace("-"," ",$zone[0]);
    array_push($zones,$zone[0]);
}
echo json_encode($zones);