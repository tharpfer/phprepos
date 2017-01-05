<?php 
require_once('./controller/build_views.php');

date_default_timezone_set('America/Chicago');

try
{
    displayUpdatedRepos();
}
catch(Exception $e)
{
    $error = $e->getMessage();
    $result = ['error' => true, 'msg' => $error];
    echo json_encode($result);
}

?>