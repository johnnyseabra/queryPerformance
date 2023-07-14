<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PeopleBelongs;

class PeopleBelongsServiceProviderTest extends TestCase
{
    
    /**
     * A test to import PeopleBelongs
     *
     * @return void
     */
    public function testImport()
    {
        
        $arrPeopleBelongs = array();
        
        for($i = 0; $i <= 3; $i++)
        {
            $arrPeopleBelongs[$i]['people'] = $i + 1;
            $arrPeopleBelongs[$i]['list'] = 1;
        }
        
        $ret = \App\Providers\PeopleBelongsServiceProvider::importData($arrPeopleBelongs);
        
        $this->assertNotEquals(0 ,$ret);
    }
}
