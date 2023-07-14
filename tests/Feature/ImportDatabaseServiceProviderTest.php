<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SocialNetworks;

class ImportDatabaseServiceProviderTest extends TestCase
{

    
    /**
     * A test to import Social Networks.
     *
     * @return void
     */
    public function testCreateTables()
    {
        
        $ret = \App\Providers\ImportDatabaseServiceProvider::createTables();
        
        $this->assertTrue($ret);
    }
    
    /**
     * A test to import Social Networks.
     *
     * @return void
     */
    public function testCreateMaterializedView()
    {
        
        $ret = \App\Providers\ImportDatabaseServiceProvider::createMaterializedView();
        
        $this->assertTrue($ret);
    }
}
