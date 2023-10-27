<?php
  session_start();
    
  if (isset($_SESSION['cid'])) {
    echo $_SESSION['cid'];
  } else {
    echo "No session";
  }

  unset($_SESSION['test']);
?>