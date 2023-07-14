<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Accounts;
use Tests\CreatesApplication;

class FakeDataServiceProviderTest extends TestCase
{
    
    /**
     * A test to generate fake data
     *
     * @return void
     */
    public function testGenerateData()
    {
        
        $ret = \App\Providers\FakeDataServiceProvider::generateData();
        
        $this->assertNotEmpty($ret);
    }

}
