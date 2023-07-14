<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PostsView;
use App\Models\Posts;

class PostsServiceProvider extends ServiceProvider
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
     * Filter Posts.
     *
     * @return void
     */
    public static function filter(Array $filters)
    {
        //
        $modelPosts = new PostsView();
        
        $arrPosts = $modelPosts->filterPosts($filters);
        
        return $arrPosts;
        
    }
    
    public static function importData(Array $arrPosts)
    {
        //Inserting lists
        $model = new Posts();
        $model->import($arrPosts);
        
        
        return count($arrPosts);
    }
    
    
    
}
