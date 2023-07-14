<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lists;
use NunoMaduro\Collision\Provider;

class ListsServiceProviderTest extends TestCase
{
    /**
     * A test to get Lists.
     *
     * @return void
     */
    public function testGetAll()
    {
        $ret =\App\Providers\ListsServiceProvider::getLists();
        
        $this->assertNotEmpty($ret);
    }
    
    /**
     * A test to import Lists.
     *
     * @return void
     */
    public function testImport()
    {
        
        $arrLists = array();
        
        $arrLists[]['name'] = "Army";
        $arrLists[]['name'] = "Companies";
        $arrLists[]['name'] = "CEOs";
        
        $ret =\App\Providers\ListsServiceProvider::importData($arrLists);
        
        $this->assertNotEquals(0 ,$ret);
    }
}
