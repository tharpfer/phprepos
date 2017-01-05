<?php
class DB
{
    private $host = 'localhost';
    private $db_name = 'repo';
    private $username = 'repouser'; 
    private $password = 'YWDqp7E9GrpP5dQH';
    private $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; 
    private $dbh;

    private function connect()
    {
        if (empty($dbh))
        {
            $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password, $this->opts);           
        }
        return $this->dbh;       
    }

    public function getRepos()
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM repository ORDER BY num_stars DESC";
        $statement = $dbh->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $rows;
    }

    public function updateRepos($values, $id)
    {
        //build sql because $values is an array of varying elements
        foreach($values as $key => $value)
        {
            $set[] = "$key = :$key";
        }
        $setStr = implode(', ', $set);
        $sql = "UPDATE repository  
                SET $setStr
                WHERE id = :id";
    
        $dbh = self::connect();

        $statement = $dbh->prepare($sql);
        $statement->bindValue(":id", $id);
        foreach($values as $k => $v)
        {
            $statement->bindValue(":$k", $v);
        }
        $statement->execute();
    }

    public function deleteRepo($id)
    {
        $dbh = self::connect();
        $sql = "DELETE FROM repository WHERE id = :id";
        $statement = $dbh->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
    }

    public function addRepos($values)
    {
        $dbh = self::connect();
        $sql = "INSERT INTO repository (id, name, url, created_date, last_push_date, description, num_stars)
                VALUES (:id, :name, :url, :created_date, :last_push_date, :description, :num_stars)";
        $statement = $dbh->prepare($sql);
        foreach ($values as $value)
        {
            foreach($value as $k => $v)
            {
                $statement->bindValue(":$k", $v);
            }
            $statement->execute();            
        }
    }

    public function createDatabase($user, $password)
    {
        $user = escapeshellarg($user);
        $password = escapeshellarg($password);
        $file = escapeshellarg(dirname(__DIR__).'/sql/repo.sql');
        exec("mysql --user=$user --password=$password < $file 2>&1", $output, $return_code);
        if($return_code > 0)
        {
            throw new Exception(implode("\n", $output));
        }
    }
}

?>
