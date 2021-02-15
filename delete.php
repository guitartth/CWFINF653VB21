<?php
require('database.php');

$itemNum = filter_input(INPUT_POST, 'itemNum', FILTER_VALIDATE_INT);


if ($itemNum) {
    $query = 'DELETE FROM todoitems
                WHERE ItemNum = :itemNum';
    $statement = $db->prepare($query);
    $statement->bindValue(':itemNum', $itemNum);
    $success = $statement->execute();
    $statement->closeCursor();
    header("location:index.php");
}

$deleted = true;

include('index.php');
?>