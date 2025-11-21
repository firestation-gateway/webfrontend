<?php

function load_config($file)
{
    $result = yaml_parse_file($file);
    return $result;
}

function save_config($file, $cfg)
{
    return yaml_emit_file($file, $cfg,  YAML_UTF8_ENCODING);
}

function get_initial_config(): array
{
    # TODO: make this more dynamically for new params or modules
    return array (
            'producers' => 
            array (
                0 => 
                array ( 
                    'name' => 'Genius',
                    'type' => 'genius',
                    'events' => 
                    array (
                        'genius_alarm' => NULL,
                        'genius_selftest' => NULL,
                        'genius_idle' => NULL,
                    ),
                    'params' =>
                    array (
                        'line' => 22,
                    ),
                ),
            ),
            'consumers' => 
            array ( 
                0 => 
                array ( 
                    'name' => 'Tetracontrol', 
                    'type' => 'tetracontrol', 
                    'params' => 
                    array ( 
                        'testmode' => true, 
                        'token' => 'TETRACONTROL-TOKEN', 
                        'url' => 'http://',
                    ),
                    'events' => 
                    array ( 
                        'genius_alarm' => 
                        array ( 
                            'type' => '', 
                            'dest' => '', 
                            'text' => '',
                        ),
                        'genius_selftest' => 
                        array ( 
                            'type' => '', 
                            'dest' => '', 
                            'text' => '',
                        ),
                        'genius_idle' => 
                        array ( 
                            'type' => '',
                            'dest' => '',
                            'text' => '',
                        ),
                    ),
                ),
                1 => 
                array ( 
                    'name' => 'Connect', 
                    'type' => 'connect', 
                    'params' => 
                    array ( 
                        'testmode' => true, 
                        'token' => 'FEUERSOFTWARE-TOKEN',
                        'url' => 'https://connectapi.feuersoftware.com',
                    ),
                    'events' => 
                    array ( 
                        'genius_alarm' => 
                        array ( 
                            'ric' => '',
                            'keyword' => '',
                            'facts' => '',
                            'address' =>
                            array (
                                'street' => '',
                                'housenumber' => '',
                                'zipcode'=> '',
                                'city' => '',
                            ),
                        ),
                    ),
                ),
            ),
        );
}

function service_restart() 
{
    $output = shell_exec("sudo /usr/bin/systemctl restart firestation-gateway");
    echo("<h1>".$output."</h1>");
}
function service_log() 
{
    $output = shell_exec("sudo journalctl -u firestation-gateway -n 20 --no-pager");
    return $output;
}
?>