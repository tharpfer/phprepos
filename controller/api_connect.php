<?php

function getRepoData()
{
    $ch = curl_init("https://api.github.com/search/repositories?q=php+language:php&sort=stars&order=desc");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 1);
    //curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    if ($response === false)
    {
        $error = "CURL ERROR: " .curl_error($ch);
        echo $error;
        
    }
    curl_close($ch);

    //since the response contains so much data 
    //go through the response and only return the necessary data
    $response = json_decode($response);
    $values = [];
    foreach($response->items as $item)
    {
        $values[$item->id] = [
            'id' => $item->id,
            'name' => $item->name,
            'url' => $item->html_url,
            'created_date' => date('Y-m-d H:i:s', strtotime($item->created_at)),
            'last_push_date' => date('Y-m-d H:i:s', strtotime($item->pushed_at)),
            'description' => $item->description,
            'num_stars' => $item->stargazers_count
        ];
    }
    return $values;
}
?>

