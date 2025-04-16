<?php
  $username = $_GET['username'];
  $password = $_GET['password'];
  require("scripts/function.php");
  require("scripts/verify.php");
  
  // Just output the newchat flag
  echo get("newchat");
?>