<?php
require_once(dirname(__DIR__) . '/model/database.php');
require_once(dirname(__DIR__) . '/controller/api_connect.php');

class RefreshData
{
    private $db_object;

    public function __construct()
    {
        $this->db_object = new DB();
    }

    public function updateData()
    {
        $results = [
            'added' => 0,
            'updated' => [],
            'removed' => 0,
            'data' => []
        ];

        $api_response = getRepoData();
        $saved_data_associative = $this->getSavedData();
        //compare the 2 data sets then and insert, update or delete appropriately
        $inserts = [];
        foreach($api_response as $k => $v)
        {   
            if (!isset($saved_data_associative[$k]))
            {
                $inserts[] = $v;
                $results['added']++;
            }
            else 
            {
                $differences = array_diff($v, $saved_data_associative[$k]);
                if (!empty($differences)) 
                {
                    $this->db_object->updateRepos($differences, $k);
                    $results['updated'][] = $k;
                }
            }    
        }
        $this->db_object->addRepos($inserts);

        foreach(array_diff_key($saved_data_associative, $api_response) as $id)
        {
            $this->db_object->deleteRepo($id);
            $results['removed']++;
        }
        $results['data'] = $api_response;
        return $results;
    }

    private function getSavedData()
    {
        $saved_data = $this->db_object->getRepos();
        $saved_data_associative = [];
        foreach($saved_data as $key => $value)
        {
            $saved_data_associative[$value['id']] = $value;
        }
        return $saved_data_associative;
    }
}

?>