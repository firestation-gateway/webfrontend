<?php

include_once "common/functions.php";

if (!empty($_FILES)) {
    echo "<pre>\r\n";
    echo htmlspecialchars(print_r($_FILES, 1));
    echo "</pre>\r\n";

    $cfg = load_config($_FILES["fileToUpload"]["tmp_name"]);
    if ($cfg == false) {
        echo "Ungültige Datei";
    } else {
        save_config("/tmp/foobar.yaml", $cfg);
    }

}

?> 