<?php
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/resto/PHP/index.php");
exit();
?>