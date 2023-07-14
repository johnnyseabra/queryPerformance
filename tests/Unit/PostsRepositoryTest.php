<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Posts;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\Date;

class PostsRepositoryTest extends TestCase
{

    
    /**
     * A test to import Posts
     *
     * @return void
     */
    public function testImport()
    {
        $arrPosts = array();
        
        for($i = 0; $i <= 5; $i++)
        {
            $arrPosts[$i]['text'] = "Testing post";
            $arrPosts[$i]['date'] = date("Y-m-d", mt_rand(1, time()));
            $arrPosts[$i]['link'] = "https://post.example/" . rand();
            $arrPosts[$i]['account'] = $i + 1;
        }
        
        $model = new Posts();
        
        $ret = $model->import($arrPosts);
        
        $this->assertTrue($ret);
    }


}
