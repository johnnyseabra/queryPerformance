<?php

namespace App\Providers;

use App\Models\Lists;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use Ramsey\Collection\AbstractArray;
use phpDocumentor\Reflection\Types\Array_;
use App\Models\SocialNetworks;

class SocialNetworksServiceProvider extends ServiceProvider
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
    
    public static function importData($arrSocialNetworks):int
    {
        //Inserting lists
        $model = new SocialNetworks();
        $model->import($arrSocialNetworks);
        
        
        return count($arrSocialNetworks);
        
        
    }
    
    public static function getSocialNetworks():Array
    {
        $model = new SocialNetworks();
        
        
        $arrSocialNetworks = $model->getAll();
        
        return $arrSocialNetworks;
        
    }
}
