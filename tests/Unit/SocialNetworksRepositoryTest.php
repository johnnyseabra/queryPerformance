<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SocialNetworks;

class SocialNetworksRepositoryTest extends TestCase
{
    /**
     * A test to get Social Networks.
     *
     * @return void
     */
    public function testGetAll()
    {
        $model = new SocialNetworks();
        
        $socialNetworks = $model->getAll();
        
        $this->assertNotEmpty($socialNetworks);
    }
    
    /**
     * A test to import Social Networks.
     *
     * @return void
     */
    public function testImport()
    {
        
        $arrSocialNetworks = array();
        
        $arrSocialNetworks[]['name'] = "Instagram";
        $arrSocialNetworks[]['name'] = "Facebook";
        $arrSocialNetworks[]['name'] = "Linkedin";
        
        $model = new SocialNetworks();
        
        $ret = $model->import($arrSocialNetworks);
        
        $this->assertTrue($ret);
    }
}
