<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PostsView;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\Date;

class PostsViewRepositoryTest extends TestCase
{

    
    /**
     * A test to filter Posts by date
     *
     * @return void
     */
    public function testSearchbyDate()
    {
        $arrFilters = array();
        
        $arrFilters['dateSince'] = "2021-06-20";
        $arrFilters['dateHence'] = "2021-08-20";
        
        
        
        $model = new PostsView();
        
        $arrPosts = $model->filterPosts($arrFilters);
        
        $this->assertNotEmpty($arrPosts);
    }
    
    /**
     * A test to filter Posts by lists
     *
     * @return void
     */
    public function testSearchbyLists()
    {
        $arrFilters = array();
        
        $arrFilters['lists'][] = "Geopolytics";
        $arrFilters['lists'][] = "Brazil";
        
        
        
        $model = new PostsView();
        
        $arrPosts = $model->filterPosts($arrFilters);
        
        $this->assertNotEmpty($arrPosts);
    }
    
    /**
     * A test to filter Posts by social networks
     *
     * @return void
     */
    public function testSearchbySocialNetwork()
    {
        $arrFilters = array();
        
        $arrFilters['socialNetwork'][] = "Twitter";
        
        $model = new PostsView();
        
        $arrPosts = $model->filterPosts($arrFilters);
        
        $this->assertNotEmpty($arrPosts);
    }
    
    /**
     * A test to filter Posts by text
     *
     * @return void
     */
    public function testSearchbyText()
    {
        $arrFilters = array();
        
        $arrFilters['text'] = "Aut sapiente placeat sit sunt qui.";
        
        $model = new PostsView();
        
        $arrPosts = $model->filterPosts($arrFilters);
        
        $this->assertNotEmpty($arrPosts);
    }


}
