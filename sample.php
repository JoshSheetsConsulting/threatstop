<?php
/**  Josh Sheets
 *    8-05-15
 *    ThreatSTOP Coding Test
 **/
require_once("Config.php");
try{
    $config = new Config("config.txt");
}
catch (Exception $e)
{
    echo "There was an error with the config file.<br>". $e->getMessage()."<br>";
    exit();
}
    echo 'Sample for using Config.php.<br>';
    echo 'Host: '.$config->host."<br>";
    echo 'Verbose: '.$config->verbose."<br>";
    echo 'Company Name: '.$config->companyName."<br>";

    $config->companyName = "ThreatSTOP";
    echo 'Adding Company Name...<blockquote>$config->companyName = "ThreatSTOP";</blockquote><br>';
    echo "Company Name: ".$config->companyName;
?>
