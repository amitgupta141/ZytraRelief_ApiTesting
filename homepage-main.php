<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Page</title>
</head>
<body>

  <a href="./User/signup.php"><button type="button">Sign Up</button></a>
  <a href="./Partner/index.php"><button type="button">Partner Sign Up</button></a>

  <a href="./Login/mainlogin.php">
    <button type="button">
      <img height="20px" width="20px" src="./user.svg"><?php echo isset($_SESSION['userIcon']) ? $_SESSION['userIcon'] : 'Sign In'; ?>
    </button>
  </a>

</body>
</html>
