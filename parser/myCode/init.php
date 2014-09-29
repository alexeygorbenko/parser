<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/24/14
 * Time: 3:40 PM
 */
include(dirname(__FILE__)."/dbConfigConnection.php");

/**
 * Get parameters from input (if called via CLI)
 *
 */

if (!(isset($_SERVER['argc']) && $_SERVER['argc']
    && isset($_SERVER['argv']) && count($_SERVER['argv']) > 1))
{
    // Nothing to parse
    return array();
}

// According to standarts - first element is filename
$arguments = array_slice($_SERVER['argv'], 1);

$parsed = array();

foreach ($arguments as $argument)
{
    if (strpos($argument, '--') === 0) // valid param, ignore others
    {
        $argument = substr($argument, 2);
        if (strpos($argument, '='))
        {
            $argument = explode('=', $argument);
            $parsed[$argument[0]] = $argument[1];
        }
        else
        {
            $parsed[$argument] = NULL;
        }
    }
}

/**
 * Get input params and save data to DB
 *
 */
if (file_exists("../" . $parsed["input"]))
{
    $content = explode("\n", file_get_contents("../" . $parsed["input"]));
    $keys = array("name", "url", "status");
    $stationsInfo = array();

    foreach($content as $value)
    {
        $string = explode("|" , $value);
        $stationsInfo[] = array_combine ($keys, $string);
    }

    foreach($stationsInfo as $stationInfo)
    {
        $stationInfo['name'] = $dbLink->real_escape_string($stationInfo['name']);
        $query = "INSERT INTO `stations` (
            `name`,
            `url`,
            `status`)
        VALUES (
            '".ltrim(rtrim($stationInfo['name']))."',
            '".ltrim(rtrim($stationInfo['url']))."',
            '".ltrim(rtrim($stationInfo['status']))."'
        )";

        if (!$dbLink->query($query)) {
            echo "Error execute query: " . mysqli_error($dbLink)."\n";
            exit;
        }
    }

    echo "Saved information to DB"."\n";
    return;
}

echo "File " . $parsed["input"]. " doesn't exist"."\n";



