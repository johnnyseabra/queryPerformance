<?php
namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Franzose\DoctrineBulkInsert\Query;
use Throwable;
use Doctrine\Persistence\ObjectRepository;

class Lists
{
    /**
     * List's name
     * 
     * @var string
     */ 
   
    public $name;
    
        
    public function __construct()
    {
        $dbParams = config()->get('database.connections.pgsql');
        $this->connection = DriverManager::getConnection($dbParams);
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Return all lists in database
     * @return \App\Models\Lists[]
     */
    
    public function getAll()
    {
        
        $sql = "SELECT * FROM tb_lists";
        
        
        $stmt = $this->connection->prepare($sql);
        
        $resultSet = $stmt->executeQuery();
        
        $arrLists = array();
        
        while($row = $resultSet->fetchAssociative())
        {
            $list = new Lists();
            
            $list->setName($row['name']);
            
            $arrLists[] = $list;
        }
        
        return $arrLists;
    }
    
    /**
     * Import array of lists to database
     * Using DoctrineBulkQuery for performance reasons
     * 
     * @param array $arrLists
     * @return bool
     */
    
    public function import(Array $arrLists)
    {
        
        try 
        {
            (new Query($this->connection))->execute('tb_lists', $arrLists);

            return true;
        } 
        catch (Throwable $e) 
        {
            report ($e);
            
            return false;
        }

    }
}

