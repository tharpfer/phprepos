<?php
require_once('./model/database.php');
require_once('./controller/api_connect.php');

date_default_timezone_set('America/Chicago');

$user = getInput("Enter mysql root user: "); 
$password = getInput("Enter mysql root password: "); 

try
{
    $dbsetup = new DB();
    $dbsetup->createDatabase($user, $password);         //only creates db if it doesn't exist
    $api_response = getRepoData();                      //get the data from the GitHub api
    $dbsetup->addRepos($api_response);                  //save the data to the newly created table
    echo "Setup successful.\n";
}
catch(Exception $e)
{
    $error = $e->getMessage();
    echo "Setup failed: $error\n";
}


function getInput($prompt)
{
    if (PHP_OS == 'WINNT') 
    {
        echo $prompt;
        return stream_get_line(STDIN, 1024, PHP_EOL);
    }
    else
    {
        return readline($prompt);
    }
}

?>
