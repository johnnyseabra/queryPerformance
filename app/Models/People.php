<?php
namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Franzose\DoctrineBulkInsert\Query;
use Throwable;
use Doctrine\Persistence\ObjectRepository;

class People
{

    public function __construct()
    {
        $dbParams = config()->get('database.connections.pgsql');
        $this->connection = DriverManager::getConnection($dbParams);
    }
    
    /**
     * Import array of people to database
     * Using DoctrineBulkQuery for performance reasons
     * @param array $arrPeople
     * @return bool
     */
    
    public function import(Array $arrPeople)
    {
        try 
        {
            (new Query($this->connection))->execute('tb_people', $arrPeople);
            
            return true;
        } 
        catch (Throwable $e)
        {
            report($e);
            
            return false;
        }
        
    }
}

