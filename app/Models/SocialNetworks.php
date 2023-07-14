<?php
namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Franzose\DoctrineBulkInsert\Query;
use Throwable;
use Doctrine\Persistence\ObjectRepository;

class SocialNetworks
{
    /**
     * Social Network's name
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
     * Return all social networks in database
     * @return \App\Models\SocialNetworks[]
     */
    
    public function getAll()
    {
        
        $sql = "SELECT * FROM tb_social_networks";
        
        
        $stmt = $this->connection->prepare($sql);
        
        $resultSet = $stmt->executeQuery();
        
        $arrSocialNetworks = array();
        
        while($row = $resultSet->fetchAssociative())
        {
            $socialNetwork = new SocialNetworks();
            $socialNetwork->setName($row['name']);
            $arrSocialNetworks[] = $socialNetwork;
        }
        
        return $arrSocialNetworks;
    }
    
    /**
     * Import array of Social Networks to database
     * Using DoctrineBulkQuery for performance reasons
     * 
     * @param array $arrSocialNetworks
     * @return boolean
     */
    public function import(Array $arrSocialNetworks)
    {
        try
        {
            (new Query($this->connection))->execute('tb_social_networks', $arrSocialNetworks);
            
            return true;
        }
        catch(Throwable $e)
        {
            report ($e);
            
            return false;
        }
        
    }
}

