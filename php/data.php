<form action="data.php" method="post">
  Username:
  <input name="username" type="text" />
  <input name="Submit" type="submit" value="Submit" />
</form>

<?php
  session_start();

  if (isset($_POST['Submit'])) {
    $_SESSION['cid'] = 111;
    echo $_SESSION['test'];
    header("Location: /php/test.php");
  } else {
    echo "No submit";
  }
?>