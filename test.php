<?php 
$tn = "7777777770";
$listdata = [];
$i = 0;
if(isset($_COOKIE['TrackData'])) {
    $listdata = json_decode($_COOKIE['TrackData'], true);
    for($i = 0; $i < count($listdata['data']); $i++) {
        if($listdata['data'][$i]['trackingNumber'] == $tn) {
            array_splice($listdata['data'], $i, 1);
        }
    }
    var_dump($listdata);
}
?>