<body>

<?php
include 'system/header.php';
?>

<?php
    $mod_id = $_GET['ID'];
    $mod_type = strtolower($_GET['TYPE']);
    $msg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if (isset($_POST["CMD"]) && $_POST['CMD'] == 'SAVEPARAM')
        {
            foreach($_POST as $key => $input)
	        {
                if (str_starts_with($key, 'P|'))
                {
                    # all global parameters
                    $param = explode("|",$key);
                    if ($input == 'true')      { $input = true; }
                    elseif ($input == 'false') { $input = false; }
                    $config[$mod_type][$mod_id]['params'][$param[1]] = $input;
                }
                if (str_starts_with($key, 'EVT|'))
                {
                    if ($input == 'true')      { $input = true; }
                    elseif ($input == 'false') { $input = false; }
                    $param = explode("|",$key);
                    if (count($param) == 3) {
                        $config[$mod_type][$mod_id]['events'][$param[1]][$param[2]] = $input;
                    } elseif (count($param) == 4) {
                        $config[$mod_type][$mod_id]['events'][$param[1]][$param[2]][$param[3]] = $input;
                    }
                }
            }
            $consumer_templ = new ConsumerClass($config[$mod_type][$mod_id]['type']);
            $config[$mod_type][$mod_id]['params'] = array_merge($consumer_templ->getParams(),
                                                                $config[$mod_type][$mod_id]['params']);
            $result = save_config($config_file, $config); /**/
            if ($result == true) {
                $msg = "Konfiguration gespeichert";
                $msg_class = "message-success";
                service_restart();
            } else {
                $msg = "FEHLER: Konfiguration NICHT gespeichert";
                $msg_class = "message-error";
            }
        }
    }
    $mod_obj = $config[$mod_type][$mod_id];

    /*
    // TODO: Füge Button hinzu, um neue Events einzutragen
    $consumer_templ = new ConsumerClass($mod_obj['type']);
    $evt_used = array_keys($mod_obj['events']);
    $evt_left = array_diff_key(array_keys($consumer_templ->getEvents()), $evt_used);
    if (count($evt_left) > 0):
        <div class='btn'><a href='?PAGE=C_EVT_ADD&CID="<?=$mod_id ?>"'><img title='Event hinzufügen' src='system/img/iconmonstr-plus-square-lined.svg'></a></div>    
    endif;
     */
    ?>
    <div id="main">
	<div id="wrapper">
    <?php if ($mod_type == 'consumers'): ?>
        <h1>Empfänger <?=$mod_obj['name']?></h1>
    <?php elseif ($mod_type == 'producers'): ?>
        <h1>Überwacher <?=$mod_obj['name']?></h1>
    <?php endif; ?>
    
        <?php if ($msg != ''): ?>
            <label class='<?=$msg_class ?>'><?=$msg ?></label>
        <?php endif; ?>
    
        <form id="form" action="?PAGE=MOD&TYPE=<?=$_GET['TYPE']?>&ID=<?=$_GET['ID'] ?>" method="POST">
        
        <div id="params">
        <h2>Parameter</h2>
        
        <input type='hidden' name='CMD' value='SAVEPARAM'>
        <?php foreach($mod_obj['params'] as $key => $value): ?>
            <div class="param-list">
            <!--<label for="<?=$key ?>"><?=$key ?></label>-->
            <label><?=$key ?></label>
            <?php if (is_bool($value)): ?>
                <div class="radio2">
                    <table>
                    <tr>
                        <td>
                        <label for="true">yes</label>
                        <input type="radio" name="P|<?=$key?>" id="true" value="true" <?php echo($value ? 'checked="checked"' : ''); ?>>
                        </td>
                        <td>
                        <label for="false">no</label>
                        <input type="radio" name="P|<?=$key?>" id="false" value="false" <?php echo($value ? '' : 'checked="checked"'); ?>>
                        </td>
                        </tr>
                    </table>
                </div>

            <?php else: ?>
                <input type="text" name="P|<?=$key?>" value="<?=$value?>" />
            <?php endif; ?>
            </div>
            
            <hr>
            
        <?php endforeach; ?>
        </div>
            
        <div id="events">
        <h2>Events</h2>
        <?php if (isset($mod_obj['events'])): ?>
            <?php foreach ($mod_obj['events'] as $key => $val): ?>
                <?php if ($mod_type == 'consumers'): ?>
                <ul>
                    <li class='c1'><div class='btn'><img title='Event löschen (NOT IMPLEMENTED YET)' src='system/img/iconmonstr-trash-can-lined.svg'></a></div></li>
                    <li class='c2'><?=$key ?></li>    
              
                    <?php foreach ($val as $key2 => $value2): ?>
                        <div id="event-list">
                        <?php if (is_array($value2)): ?>
                            
                            <?php foreach ($value2 as $key3 => $value3): ?>
                                <label for="EVT|<?=$key.'|'.$key2.'|'.$key3 ?>"><?=$key2.':'.$key3 ?></label>
                                <input type="text" name="EVT|<?=$key.'|'.$key2.'|'.$key3 ?>" value="<?=$value3?>" />
                            <?php endforeach; ?>
                        <?php elseif (is_bool($value2)): ?>
    <label><?=$key2 ?></label>
    <div class="radio2">
        <table>
        <tr>
            <td>
            <label for="true">yes</label>
            <input type="radio" name="EVT|<?=$key.'|'.$key2 ?>" id="true" value="true" <?php echo($value2 ? 'checked="checked"' : ''); ?>>
            </td>
            <td>
            <label for="false">no</label>
            <input type="radio" name="EVT|<?=$key.'|'.$key2 ?>" id="false" value="false" <?php echo($value2 ? '' : 'checked="checked"'); ?>>
            </td>
            </tr>
        </table>
    </div>

                        <?php else: ?>  
                            <label for="EVT|<?=$key.'|'.$key2 ?>"><?=$key2 ?></label>
                            <input type="text" name="EVT|<?=$key.'|'.$key2 ?>" value="<?=$value2?>" />
                        <?php endif; ?>
                        </div>
                    <?php endforeach; ?> <!-- -->
                </ul>
                <?php elseif ($mod_type == 'producers'): ?>
                <ul>
                    <li class='c2'><?=$key ?></li>
                </ul>
                <?php endif ?>
            <?php endforeach; ?>
            
            
            <hr>
        <?php endif; ?>
        </div>
        <!--<div style="text-align:center"><input type="submit" value="SPEICHERN"></div>-->
        <div class='btn'><a href="#" onclick="document.getElementById('form').submit()" ><img title='Speichern' src='system/img/iconmonstr-save-14.svg' /></a></div>
        </form>
</div>		<!--  Wrapper -->
</div>		<!--  Main -->

</body>
</html>