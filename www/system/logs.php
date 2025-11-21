
<body>

<?php
include 'system/header.php';
?>
<meta http-equiv="refresh" content="5; url="<?php echo $_SERVER['PHP_SELF']; ?>" />
    <div id="main">
	
        <h2>Backend Logoutput</h2>

        <pre><?php print_r(service_log()); ?></pre>
        
        
    </div>
</body>
</html>
