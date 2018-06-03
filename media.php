<?php
// Controller for BT media

$output = array();
exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.freedesktop.DBus.Properties.Get string:org.bluez.MediaPlayer1 string:Track", $output);
print_r(json_encode(implode($output, " ")));

?>