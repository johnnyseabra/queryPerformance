<?php

namespace App\Providers;

use App\Models\Lists;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use Ramsey\Collection\AbstractArray;
use phpDocumentor\Reflection\Types\Array_;

class ListsServiceProvider extends ServiceProvider
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
     * Import list data
     * 
     * @return array
     * @todo Insert parameter to control amount of data generated 
     */
    
    public static function importData($arrLists):int
    {
        //Inserting lists
        $model = new Lists();
        $model->import($arrLists);
        
        
        return count($arrLists);
        
        
    }
    
    
    public static function getLists():Array
    {
        $model = new Lists();
        
        
        $arrLists = $model->getAll();
        
        return $arrLists;
        
    }
}
