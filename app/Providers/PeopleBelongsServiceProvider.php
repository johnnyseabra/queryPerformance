<?php

namespace App\Providers;

use App\Models\PeopleBelongs;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use Ramsey\Collection\AbstractArray;
use phpDocumentor\Reflection\Types\Array_;

class PeopleBelongsServiceProvider extends ServiceProvider
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
     * Import PeopleBelongs to database
     * 
     * @return int
     */
    
    public static function importData(Array $arrPeopleBelongs):int
    {
        //Inserting lists
        $model = new PeopleBelongs();
        $model->import($arrPeopleBelongs);
        
       
        return count($arrPeopleBelongs);
        
        
    }
    

}
