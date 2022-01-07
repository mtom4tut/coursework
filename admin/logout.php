<?php
session_start();

unset($_SESSION['admin']); // удаление сессии

header("Location: authorization.php"); // переадресация
exit();
