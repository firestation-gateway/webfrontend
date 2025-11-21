<!DOCTYPE html>
<html lang="de">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta charset="utf-8" />
<meta name="robots" content="noindex,nofollow" />
<title>Firestation GW Configuration</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="system/css/main.css">
<script src="system/js/main.js"></script>
</head>
<?php 

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include "system/templates/consumerClass.php";
include "system/common/functions.php";

if (file_exists("config.yaml")) {
  $config_file = "config.yaml";  
} else {
  $config_file = "../config.yaml";
}

$config = load_config($config_file);
$config_generated = false;
if ($config == false) {
  $config = get_initial_config();
  $config_generated = true;
  save_config($config_file, $config);
}
?>

<!-- Side navigation -->
<nav class="sidenav">
  <ul>
    <li><a href="/">Home</a></li>
    <?php foreach($config['consumers'] as $indx => $consumer): ?>
      <li><a href="?PAGE=MOD&TYPE=CONSUMERS&ID=<?=$indx ?>"><?=$consumer['name'] ?></a></li>
    <?php endforeach; ?>
    <?php foreach($config['producers'] as $indx => $producer): ?>
      <li><a href="?PAGE=MOD&TYPE=PRODUCERS&ID=<?=$indx ?>"><?=$producer['name'] ?></a></li>
    <?php endforeach; ?>
    <li><a href="?PAGE=LOGS">Logs</a></li>
  </ul>
</nav>

<!-- Page content -->
<?php

if ($config_generated):
    echo ("<h2>Neue Konfigurationsdatei wurde erzeugt!</h2>");
    echo ("Pfad: ".$config_file."<br>");
endif;

if( isset($_GET['PAGE']) ):
    if( $_GET['PAGE'] == "MOD"):
        include "system/module.php";
    elseif( $_GET["PAGE"] == "LOGS"):
        include "system/logs.php";
    else:
        include "system/home.php";
    endif;
else:
    include "system/home.php";
endif;
?>
