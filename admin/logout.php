<?php
require_once "includes/includepath.php";
unset($_SESSION['MYPR_adm_id']);
unset($_SESSION['MYPR_adm_username']);
unset($_SESSION['MYPR_adm_type']);
header("location:".URLAD."login");
?>