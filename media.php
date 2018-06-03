<?php
// Controller for BT media
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getMediaInfo() {
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.freedesktop.DBus.Properties.Get string:org.bluez.MediaPlayer1 string:Track", $output);
    $real_output = array();

    $onKey = True;
    foreach($output as $key => $item) {

        // Only get keys, skip values of this weird array
        if($onKey) {
            if (preg_match('/\"(.*?)\"/', $item, $m)) {

                unset($m2);

                // Get the value if we've matched a key
                preg_match('/\"(.*?)\"/', $output[$key+1], $m2);
                if(empty($m2)) {
                    preg_match('/([0-9]*)$/', utf8_encode($output[$key+1]), $m2);
                    //print_r($m2);
                    //print_r($output[$key+1]);
                }

                $real_output[$m[1]] = $m2[1];

                // Skip next value
                $onKey = False;
            }
        } else {
            $onKey = True;
        }
    }
    return json_encode($real_output);
}

switch ($_GET["command"]) {
    case "info":
    default:
        print(getMediaInfo());
        break;
}


?>