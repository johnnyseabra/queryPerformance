<?php
namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Franzose\DoctrineBulkInsert\Query;
use Throwable;
use Doctrine\Persistence\ObjectRepository;

class Accounts
{

    
    public function __construct()
    {
        $dbParams = config()->get('database.connections.pgsql');
        $this->connection = DriverManager::getConnection($dbParams);
    }
    
    
    public function import(Array $arrAccounts)
    {
        try
        {
            (new Query($this->connection))->execute('tb_accounts', $arrAccounts);
            
            return true;
        }
        catch(Throwable $e)
        {
            report ($e);
            
            return false;
        }
        
    }
}

