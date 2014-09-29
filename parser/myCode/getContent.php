<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/24/14
 * Time: 12:17 PM
 */

include(dirname(__FILE__)."/dbConfigConnection.php");

if (!empty($_REQUEST["fileName"])){
    $params["fileName"] = $_REQUEST["fileName"];
    saveDescription($dbLink, $params);
}

if (!empty($_REQUEST["status"]) && !empty($_REQUEST["id"])){
    $params["status"] = $_REQUEST["status"];
    $params["id"] = $_REQUEST["id"];
    saveStatus($dbLink, $params);
}

function downloadUrl($params) {

    $savedFilesDir = dirname(__FILE__)."/html";

    if (!is_dir($savedFilesDir)) {
        mkdir($savedFilesDir);
        chmod($savedFilesDir, 0755);
    }

    $url = ltrim(rtrim($params["fileName"]));
    $savedFile = $savedFilesDir."/".basename($url);

    if (is_file($savedFile)) {
        return $savedFile;
    }

    echo "Downloading '".$url."' (will be saved into '".$savedFile."') ...\n";

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $html = curl_exec($handle);

    file_put_contents($savedFile, $html);
    chmod($savedFile, 0755);

    return $savedFile;
}

function getJsonAndItemsFromFile($params)
{
    $file = downloadUrl($params);

    $html = file_get_contents($file);
    preg_match('/TuneIn\.payload = ({.*})\s+\/\//s', $html, $matches);

    if (count($matches) != 2) {
        // failed to find match
        return false;
    }

    $payload = json_decode($matches[1]);

    $items["st_name"] = $payload->Station->description;
    if (isset($payload->SongsPlaylist))
    {
        $items["author"] = isset($payload->SongsPlaylist->items[0])
            ? $payload->SongsPlaylist->items[0]->Artist
            : "";
        $items["song"] = isset($payload->SongsPlaylist->items[0])
            ? $payload->SongsPlaylist->items[0]->Title
            : "";
    }
    else
    {
        $items["author"] = "";
        $items["song"] = "";
    }

    return $items;
}

function saveDescription($dbLink, $params)
{
    include(dirname(__FILE__)."/dbConfigConnection.php");
    $items = getJsonAndItemsFromFile($params);
    $items['st_name'] = $dbLink->real_escape_string($items['st_name']);
    $iQuery = "INSERT INTO `description` (`st_name`, `song`, `author`)
        VALUES (
            '". $items['st_name'] ."',
            '". $items['song'] ."',
            '". $items['author'] ."'
        )";

    if (!$dbLink->query($iQuery)) {
        echo "Error execute query: " . mysqli_error($dbLink)."\n";
        exit;
    }

    echo "Saving radio station information: " . $items['st_name'] . "\n";

    return true;
}

function saveStatus($dbLink, $params)
{
    $iQuery = "UPDATE `stations`
        SET
           `status` = '". $params['status'] ."'
        WHERE
            `id` = ". $params['id'] ."
        ";

    if (!$dbLink->query($iQuery)) {
        echo "Error execute query: " . mysqli_error($dbLink)."\n";
        exit;
    }

    echo "Saving radio station status: " . $params['status'] . "\n";

    return true;
}
