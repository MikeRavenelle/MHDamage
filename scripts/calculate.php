<?php
/**
 * Created by PhpStorm.
 * User: mikeravenelle
 * Date: 8/18/14
 * Time: 3:31 PM
 */

$attackDamage = $_POST['attackDamage'];
$elementDamage = $_POST['elementDamage'];
$attackType = trim(preg_replace('/\s\s+/', ' ', $_POST['attack']));
$totalDamage['raw'] = 0;
$totalDamage['element'] = 0;

$file = "../weapons/" . $_POST['weapon'] . ".mh";
$weaponData = file($file);
$attack = [];

foreach ($weaponData as $weaponAttack) {
    $weaponAttack = array_map('trim', explode(",", $weaponAttack));
    if ($weaponAttack[0] == $attackType) {
        for ($i = 1; $i < count($weaponAttack); ++$i) {
            array_push($attack, $weaponAttack[$i]);
        }
    }
}

$file = "../other/class.mh";
$classData = file($file);
$weaponClass = 0;

foreach ($classData as $class) {
    $class = array_map('trim', explode(",", $class));
    if ($class[0] == $_POST['weapon']) {
        $cutting = $class[1];
        $impact = $class[2];
        $weaponClass = $class[3];
        $extra = $class[4];
    }
}

$file = "../other/sharpness.mh";
$sharpnessData = file($file);

foreach ($sharpnessData as $sharp) {
    $sharp = array_map('trim', explode(" ", $sharp));
    if ($sharp[0] == $_POST['sharpness']) {
        $attackModifier = $sharp[1];
        $elementModifer = $sharp[2];
    }
}

$file = "../monsters/" . $_POST['monster'] . ".mh";
$monsterData = file($file);
$hitZone = str_replace(" ","-",$_POST['zone']);
foreach ($monsterData as $monster) {
    $monsterZones = array_map('trim', explode(" ", $monster));
    if ($monsterZones[0] == $hitZone) {

        if ($cutting == true && $impact == true) {

            if ($monsterZones[1] > $monsterZones[2]) {
                $impact = false;
            } else {
                $cutting = false;
            }
        }

        if ($cutting == true)
            $rawHitzone = $monsterZones[1];
        if ($impact == true)
            $rawHitzone = $monsterZones[2];

        switch ($_POST['elementType']) {

            case "Fire":
                $elementHitzone = $monsterZones[3];
                break;
            case "Water":
                $elementHitzone = $monsterZones[4];
                break;
            case "Thunder":
                $elementHitzone = $monsterZones[5];
                break;
            case "Ice":
                $elementHitzone = $monsterZones[6];
                break;
            case "Dragon":
                $elementHitzone = $monsterZones[7];
                break;
            case "None":
                $elementHitzone = 0;

        }

        $stagger = $monsterZones[8];
        $elementHitzone = $elementHitzone/100;
        $rawHitzone = $rawHitzone/100;
    }

}

foreach ($attack as $type) {
    $totalDamage['raw'] += floor(($attackDamage * $type * $attackModifier * $rawHitzone * $extra) / $weaponClass);
    $totalDamage['element'] += floor(($elementDamage * $elementModifer * $elementHitzone * $extra) / 10);
}

echo json_encode($totalDamage);

