<?php
// Controller for BT media

function getMediaInfo() {
    // Output media object
    $media_object = array();

    // Get track info first
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.freedesktop.DBus.Properties.Get string:org.bluez.MediaPlayer1 string:Track", $output);
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

    // Get media status first
    $output = array();
    exec("dbus-send --system --print-reply --type=method_call --dest=org.bluez /org/bluez/hci0/dev_4C_32_75_AD_98_24/player0 org.freedesktop.DBus.Properties.Get string:org.bluez.MediaPlayer1 string:Status", $output);
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
    if(array_key_exists("Album", $media_object) && array_key_exists("Artist", $media_object)) {
        $artist_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $media_object["Artist"])));
        $album_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $media_object["Album"])));
        $artwork_url = "./artwork/".$artist_slug."/".$album_slug.".jpg";

        // Set local link if it exists
        if(file_exists($artwork_url)) {
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
    case "pause":
        echo(pause());
        break;
    case "play":
        echo(play());
        break;
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