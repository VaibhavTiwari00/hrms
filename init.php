<?php

// ------------------------------- Include Files -------------------------------//


include_once "config.php";
include_once "includes/route.inc.php";
include_once "includes/session.php";
include_once "includes/functions.php";
include_once "includes/main_function.php";






// Include ui DIR PATH

$include_ui_path = APPPATH . "/includes/";


define("HEADER", $include_ui_path . "header.php");
define("HEAD_TOP", $include_ui_path . "head-main.php");
define("HEAD", $include_ui_path . "head.php");
define("FOOTER", $include_ui_path . "footer.php");
define("SCRIPT", $include_ui_path . "script.php");
define("SIDEBAR", $include_ui_path . "sidebar.php");
define("MENU", $include_ui_path . "menu.php");
