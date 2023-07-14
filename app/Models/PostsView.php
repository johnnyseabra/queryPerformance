<?php

namespace App\Models;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Illuminate\Http\Request;

class PostsView
{
    
    public string $date;
    public string $socialNetwork;
    public string $postLink;
    public string $accountLink;
    public string $postText;
    public string $postAuthor;
    public array $authorLists;
    
    private $connection;
    
    public function __construct()
    {
        $dbParams = config()->get('database.connections.pgsql');
        $this->connection = DriverManager::getConnection($dbParams);
    }
    
    public function setDate($date)
    {
        $this->date = $date;
    }
    
    public function setSocialNetwork($socialNetwork)
    {
        $this->socialNetwork = $socialNetwork;
    }
    
    public function setPostLink($postLink)
    {
        $this->postLink = $postLink;
    }
    
    public function setPostAuthor($postAuthor)
    {
        $this->postAuthor = $postAuthor;
    }
    
    public function setAccountLink($accountProfileLink)
    {
        $this->accountLink = $accountProfileLink;
    }

    public function setPostText($postText)
    {
        $this->postText = $postText;
    }
    
    public function setAuthorLists($authorLists)
    {
        $arrLists = explode('|', $authorLists);
        
        $this->authorLists = $arrLists;
    }
    
    public function filterPosts(Array $filter)
    {
        $sql = "SELECT * FROM public.mv_posts WHERE 1 = 1 ";
        
        if(isset($filter['dateSince']) && isset($filter['dateHence']))
        {
            $sql .= " AND post_date >= '" . $filter['dateSince'] . "' AND post_date <= '" . $filter['dateHence'] . "'";
        }
        if(isset($filter['postText']))
        {
            $sql .= " AND post_text = '" . $filter['postText'] . "'";
        }
        if(isset($filter['socialNetwork']))
        {
            for($i = 0; $i < count($filter['socialNetwork']); $i++)
            {
                if($i == 0)
                {
                    $sql .= " AND (social_network = '" . $filter['socialNetwork'][$i] . "' ";
                }
                else
                {
                    $sql .= " OR social_network = '" . $filter['socialNetwork'][$i] . "' ";
                }
            }
            $sql .= ") ";
        }
        if(isset($filter['lists']))
        {
            
             for($i = 0; $i < count($filter['lists']); $i++)
             {
                if($i == 0)
                {
                    $sql .= " AND (list_name = '" . $filter['lists'][$i] . "' ";
                }
                else
                {
                    $sql .= " OR list_name = '" . $filter['lists'][$i] . "' ";
                }
             }
             
             $sql .= ") ";
        }
        
       
        $sql .= " ORDER BY post_date ASC";
        
        $stmt = $this->connection->prepare($sql);
        
        $resultSet = $stmt->executeQuery();
        
        $arrPosts = array();
        while($row = $resultSet->fetchAssociative())
        {
            $post = new PostsView();
            
            $post->setDate($row['post_date']);
            $post->setPostAuthor($row['people_name']);
            $post->setPostLink($row['post_link']);
            $post->setPostText($row['post_text']);
            $post->setAccountLink($row['profile_link']);
            $post->setSocialNetwork($row['social_network']);
            $post->setAuthorLists($row['lists']);
            
            $arrPosts[] = $post;
        }
        
        return $arrPosts;
        
        
    }
}
