<?php

session_start();
session_unset();
session_destroy();

$url = dirname(dirname($_SERVER['PHP_SELF']));
header("Location: ". $url );

?>