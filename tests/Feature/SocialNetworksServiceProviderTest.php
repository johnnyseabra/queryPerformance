<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SocialNetworks;

class SocialNetworksServiceProviderTest extends TestCase
{
    /**
     * A test to get Social Networks.
     *
     * @return void
     */
    public function testGetAll()
    {
        $ret =\App\Providers\SocialNetworksServiceProvider::getSocialNetworks();
        
        $this->assertNotEmpty($ret);
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
        
        $ret = \App\Providers\SocialNetworksServiceProvider::importData($arrSocialNetworks);
        
        $this->assertNotEquals(0 ,$ret);
    }
}
