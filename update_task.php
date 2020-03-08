<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script

$taskman = new Task();

$TaskId = "";
$taskname = ""; 
$taskname = ""; 
$taskdesc = ""; 
$tmode = "";

if(isset($_POST['TaskId'])){
    $TaskId = $_POST['TaskId'];
}

if(isset($_POST['InputTaskName'])){
    $taskname = $_POST['InputTaskName'];
}

if(isset($_POST['InputTaskDescription'])){    
    $taskdesc = $_POST['InputTaskDescription'];
}

if(isset($_POST['mode'])){
    $tmode = $_POST['mode'];
}

if($tmode == "new" or $tmode == "edit"){
    $taskman->save($tmode, $taskname, $taskdesc, $TaskId);
}

if($tmode == "del"){
    $taskman->Delete($TaskId);
}

?>