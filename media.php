<?php
// Controller for BT media

function getMediaInfo() {
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.freedesktop.DBus.Properties.Get string:org.bluez.MediaPlayer1 string:Track", $output);
    $media_object = array();

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
                }

                $media_object[$m[1]] = $m2[1];

                // Skip next value
                $onKey = False;
            }
        } else {
            $onKey = True;
        }
    }

    // Get local link to album artwork
    if(in_array("Album", $media_object) && in_array("Artist", $media_object)) {
        $artist_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $media_object["Artist"])));
        $album_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $media_object["Album"])));
        $artwork_url = "./artwork/".$artist_slug."/".$album_slug.".jpg";

        // Set local link if it exists
        $handle = curl_init($artwork_url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 200) {
            $media_object["Album_Artwork"] = $artwork_url;
        }
    }

    return json_encode($media_object);
}

function pause() {
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.bluez.MediaPlayer1.Pause", $output);
    return $output;
}

function play() {
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.bluez.MediaPlayer1.Play", $output);
    return $output;
}

function nextTrack() {
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.bluez.MediaPlayer1.Next", $output);
    return $output;
}

function prevTrack() {
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.bluez.MediaPlayer1.Previous", $output);
    return $output;
}

switch ($_GET["command"]) {
    case "nextTrack":
        echo(nextTrack());
        break;
    case "prevTrack":
        echo(prevTrack());
        break;
    case "info":
    default:
        echo(getMediaInfo());
        break;
}


?>