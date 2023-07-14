<?php
namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Franzose\DoctrineBulkInsert\Query;
use Throwable;
use Doctrine\Persistence\ObjectRepository;

class Posts
{

    
    public function __construct()
    {
        $dbParams = config()->get('database.connections.pgsql');
        $this->connection = DriverManager::getConnection($dbParams);
    }
    
    
    /**
     * Import array of Posts to database
     * Using DoctrineBulkQuery for performance reasons
     *
     * @param array $arrPosts
     * @return boolean
     */
    public function import(Array $arrPosts)
    {
        try
        {
            (new Query($this->connection))->execute('tb_posts', $arrPosts);
            
            return true;
        }
        catch(Throwable $e)
        {
            report ($e);
            
            return false;
        }
    }
}

