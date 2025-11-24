
<body>

<?php
include 'system/header.php';
?>
<div id="main">
	<div id="wrapper">

<form action="system/upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:<br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</div>
</div>
</body>
</html>
