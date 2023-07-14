<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Accounts;

class AccountsRepositoryTest extends TestCase
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
        
        
        $model = new Accounts(); 
        
        $ret = $model->import($arrAccount);
        
        $this->assertTrue($ret);
    }

}
