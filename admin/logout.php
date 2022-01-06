<?php
session_start();

unset($_SESSION['admin']); // удаление сессии

header("Location: index.php"); // переадресация
exit();
