<?php
namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Franzose\DoctrineBulkInsert\Query;
use Throwable;
use Doctrine\Persistence\ObjectRepository;

class PeopleBelongs
{

    
    public function __construct()
    {
        $dbParams = config()->get('database.connections.pgsql');
        $this->connection = DriverManager::getConnection($dbParams);
    }
    
    /**
     * Import array of people to database
     * Using DoctrineBulkQuery for performance reasons
     * 
     * @param array $arrPeopleBelongs
     * @return boolean
     */
    
    public function import(Array $arrPeopleBelongs)
    {
        try
        {
            (new Query($this->connection))->execute('tb_people_belongs', $arrPeopleBelongs);
            
            return true;
        }
        catch (Throwable $e)
        {
            report ($e);
            
            return false;
        }
    }
}

