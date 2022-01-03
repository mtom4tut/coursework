<?php
session_start();

unset($_SESSION['user']); // удаление сессии

header("Location: index.php"); // переадресация
exit();
