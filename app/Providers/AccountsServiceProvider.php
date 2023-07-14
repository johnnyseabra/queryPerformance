<?php

namespace App\Providers;

use App\Models\Accounts;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use Ramsey\Collection\AbstractArray;
use Throwable;
use phpDocumentor\Reflection\Types\Array_;

class AccountsServiceProvider extends ServiceProvider
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
     * Imports accounts to database
     * @param array $arrAccounts
     * @return number
     */
    
    public static function importData(Array $arrAccounts)
    {
        
        try 
        {
            //Inserting lists
            $model = new Accounts();
            $model->import($arrAccounts);
            
            
            return count($arrAccounts);
        } 
        
        catch (Throwable $e) 
        {
            report ($e);
            
            return 0;
        }
        
    }
    

}
