<?php

require_once 'database.php';

/*
function get_coments_first($db) {
      $sql = "SELECT * FROM coments  ORDER BY date DESC";
      $result = mysqli_query($db, $sql);
            echo '<pre>';
            //var_dump($result);
            //echo '</pre>';
      $coments = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $coments;
}
$coments_first = get_coments_first($link);
print_r($coments_first);
*/

function get_coments($db) {
    $sql = "SELECT * FROM `coments` LEFT JOIN `users` ON `coments`.`user_id` = `users`.`user_id` ORDER BY date DESC";
    $result = mysqli_query($db, $sql);
    //echo '<pre>';
    //var_dump($result);
    $coments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //print_r($coments);
    return $coments;
}
$coments = get_coments($link);


