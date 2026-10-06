<?php
require_once __DIR__ . '/config/auth.php';
logoutUser();
header('Location: /ams/index.php');
exit;
