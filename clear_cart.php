<?php
session_start();
unset($_SESSION['cart']);
header("Location: profile.php#cart");
exit;