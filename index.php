<?php 
require_once('./controller/build_views.php');

date_default_timezone_set('America/Chicago');

try
{
    displayRepos();
}
catch(Exception $e)
{
    $error = $e->getMessage();
    displayError($error);
}

?>