<?php
/**
 * Created by PhpStorm.
 * User: mikeravenelle
 * Date: 8/19/14
 * Time: 1:41 PM
 */
$returnData = array();
$returnData['elements'] = array();
$returnData['weapons'] = array();
$returnData['sharpness'] = array();
$returnData['monsters'] = array();
$returnData['quests'] = array();

$file = "../other/elements.mh";
$importData = file($file);
foreach($importData as $data) {
    $data = array_map('trim', explode(",", $data));
    array_push($returnData['elements'],$data[0]);
}

$dir = "../weapons";
$weapons = preg_grep('/^([^.])/', scandir($dir));
unset($weapons[0]);
unset($weapons[1]);
foreach ($weapons as $weapon) {
    $withoutExt = preg_replace('/\\.[^.\\s]{2,}$/', '', $weapon);
    array_push($returnData['weapons'], $withoutExt);
}

$file = "../other/sharpness.mh";
$importData = file($file);
foreach($importData as $data) {
    $data = array_map('trim', explode(" ", $data));
    array_push($returnData['sharpness'],$data[0]);
}

$dir = "../monsters";
$monsters = preg_grep('/^([^.])/', scandir($dir));
unset($monsters[0]);
unset($monsters[1]);
foreach ($monsters as $monster) {
    $withoutExt = preg_replace('/\\.[^.\\s]{2,}$/', '', $monster);
    array_push($returnData['monsters'], $withoutExt);
}

$file = "../other/quests.mh";
$importData = file($file);
foreach($importData as $data) {
    $data = array_map('trim', explode(",", $data));
    array_push($returnData['quests'],$data[0]);
}

echo json_encode($returnData);