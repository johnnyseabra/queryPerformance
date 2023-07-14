<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\CreatesApplication;

class AccountsServiceProviderTest extends TestCase
{
    
    /**
     * A test to import Accounts
     *
     * @return void
     */
    public function testImport()
    {
        
        $arrAccount = array();
        
        for($k = 0; $k <= 5; $k++)
        {
            if($k % 2 == 1)
            {
                $arrAccount[$k]["social_network"] = 1; //Twitter ID at database
                
            }
            else
            {
                $arrAccount[$k]["social_network"] = 2; //Facebook ID at database
            }
            
            $arrAccount[$k]["profile_link"] = "https://profile.example/" . rand();
            $arrAccount[$k]["people"] = $k;
        }
        
        
        $ret = \App\Providers\AccountsServiceProvider::importData($arrAccount);
        
        $this->assertNotEquals(0 ,$ret);
    }

}
