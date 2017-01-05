<?php
require_once(dirname(__DIR__) . '/model/database.php');
require_once(dirname(__DIR__) . '/model/refresh_data.php');

function displayRepos()
{
    $db_object = new DB();
    $values = $db_object->getRepos();

    foreach ($values as $value)
    {
        $htmlRows .= buildRow($value);
    }
    
    echo buildOutput($htmlRows);   
}

function displayUpdatedRepos()
{
    $refresh = new RefreshData();
    $results = $refresh->updateData();

    foreach ($results['data'] as $value)
    {
        $htmlRows .= buildRow($value);
    }
    
    $results['html'] = $htmlRows;
    $results['error'] = false;
    echo json_encode($results);  
}

function displayError($error)
{
    echo buildError($error);
}

function buildRow($values)
{
    $rowTemplate = file_get_contents(dirname(__DIR__) . '/view/tablerow.html');
    //populate arrays to be used for string replace
    $oldValues = [
        '%%ID%%',
        '%%STARS%%',
        '%%NAME%%',
        '%%DESCRIPTION%%',
        '%%URL%%',
        '%%CREATED%%',
        '%%PUSHED%%'
    ];
    $newValues = [
        $values['id'],
        $values['num_stars'],
        $values['name'],
        $values['description'],
        $values['url'],
        $values['created_date'],
        $values['last_push_date']        
    ];
    $htmlRow = str_replace($oldValues, $newValues, $rowTemplate);
    return $htmlRow;
}

function buildOutput($htmlRows)
{
    $output = file_get_contents(dirname(__DIR__) . '/view/template.html');
    $output = str_replace('%%HTMLROWS%%', $htmlRows, $output);
    return $output;
}

function buildError($error)
{
    $output = file_get_contents(dirname(__DIR__) . '/view/error.html');
    $output = str_replace('%%ERROR%%', $error, $output);
    return $output;
}

?>