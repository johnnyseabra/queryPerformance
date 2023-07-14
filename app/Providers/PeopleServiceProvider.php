<?php

namespace App\Providers;

use App\Models\People;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use Ramsey\Collection\AbstractArray;
use phpDocumentor\Reflection\Types\Array_;

class PeopleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Generates list data
     * 
     * @return int
     */
    
    public static function importData(Array $arrPeople)
    {
        
        //Inserting lists
        $model = new People();
        $model->import($arrPeople);
        
       
        return count($arrPeople);
        
        
    }
    

}
