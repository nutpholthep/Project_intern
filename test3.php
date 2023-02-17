<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$page = 'home';
include('nav.php');
?>

<nav>
  <ul>
    <li class="<?php if ($page == 'home') { echo 'active'; } ?>"><a href="home.php">Home</a></li>
    <li class="<?php if ($page == 'about') { echo 'active'; } ?>"><a href="about.php">About</a></li>
    <li class="<?php if ($page == 'contact') { echo 'active'; } ?>"><a href="contact.php">Contact</a></li>
  </ul>
</nav>

</body>
</html>