<?php
session_start() ;
$location = "Location: ".$_SESSION["baseurl"]."/login.php";
echo $location;
session_destroy();
header($location);
?>