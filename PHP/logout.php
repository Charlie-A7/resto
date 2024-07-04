<?php
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/Webproject/PHP/index.php");
exit();
?>