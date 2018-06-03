<?php
// Controller for BT media

$output = array();
exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.freedesktop.DBus.Properties.Get string:org.bluez.MediaPlayer1 string:Track", $output);
print_r($output);
$real_output = array();

foreach($output as $key => $item) {
    if(strpos($item, "string") !== false ) {
        $item_parse = explode($item, " ");
        $real_output[$output[$key+1]] = $real_output[$item[2]]
    }
}

print_r($real_output);

?>