<?php
session_start();
if(!isset($_SESSION["antartica"])){
  header("Location: salir.php");
}
?>
