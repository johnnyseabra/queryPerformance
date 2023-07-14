<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\People;

class PeopleRepositoryTest extends TestCase
{
    
    
    /**
     * A test to import People
     *
     * @return void
     */
    public function testImport()
    {
        
        $arrPeople = array();
        
        
        $arrPeople[]['name'] = "Peter Parker";
        $arrPeople[]['name'] = "Logan";
        $arrPeople[]['name'] = "Prof Xavier";
        $arrPeople[]['name'] = "Scott Summers";
        
        $model = new People();
        
        $ret = $model->import($arrPeople);
        
        $this->assertTrue($ret);
    }

}
