<?php

namespace App\Providers;

use Faker\Factory;
use Illuminate\Support\ServiceProvider;
use Throwable;

class FakeDataServiceProvider extends ServiceProvider
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
     * Generates fake data and import into the database
     * @return array
     */
    
    public static function generateData(): Array
    {
        
        $arrCount = array();
        
        try
        {
        
            $arrCount['people'] = 0;
            $arrCount['peopleBelongs'] = 0;
            $arrCount['accounts'] = 0;
            $arrCount['posts'] = 0;
            $arrCount['socialNetworks'] = 0;
            
            //Fake  list array
            $arrListNames = array(
                "Brazil", //Divisible by 7
                "Politicians", //Divisible by 11
                "UN", //Divisible by 13
                "Europe", //Divisible by 17
                "Asia", //Divisible by 19
                "Geopolytics", //Pair
                "Enviroment and Climate" //Odd
            );
            
            $arrLists = array();
            
            for($l = 0; $l < count($arrListNames); $l++)
            {
                $arrLists[$l]['name'] = $arrListNames[$l];
            }
            
            
                
            $arrCount['lists'] = \App\Providers\ListsServiceProvider::importData($arrLists);
           
            
            //Fake  social networks array
            $arrSocialNetworkNames = array(
                "Twitter", 
                "Facebook" 
            );
            
            $arrSocialNetworks = array();
            
            for($l = 0; $l < count($arrSocialNetworkNames); $l++)
            {
                $arrSocialNetworks[$l]['name'] = $arrSocialNetworkNames[$l];
            }
            
            $arrCount['socialNetworks'] = \App\Providers\SocialNetworksServiceProvider::importData($arrSocialNetworks);
            
            //Workaround to control IDs
            $countAccounts = 0;
            $countPeople = 0;
            $countPeopleBelongs = 0;
            $countPosts = 0;
            
            for($i = 1; $i <= 2500; $i++)
            {
                
                $arrPeople = array();
                $arrPeopleBelongs = array();
                $arrPosts = array();
                $arrAccounts = array();
                
                $faker = Factory::create();
                
                
                //Assembly people array
                $arrPeople[]['name'] = $faker->name();
                
                //A little workaround to generate associations between list and people
                $peopleBelongs = array();
                if($i % 7 == 0)
                {
                    $peopleBelongs['list'] = 1;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                if($i % 11 == 0)
                {
                    $peopleBelongs['list'] = 2;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                if($i % 13 == 0)
                {
                    $peopleBelongs['list'] = 3;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                if($i % 17 == 0)
                {
                    $peopleBelongs['list'] = 4;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                if($i % 19 == 0)
                {
                    $peopleBelongs['list'] = 5;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                if($i % 2 == 0)
                {
                    $peopleBelongs['list'] = 6;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                if($i % 2 != 0)
                {
                    $peopleBelongs['list'] = 7;
                    $peopleBelongs['people'] = $i;
                    
                    $arrPeopleBelongs[] = $peopleBelongs;
                    $countPeopleBelongs++;
                }
                //Garbage collector
                unset($peopleBelongs);
                //End of workaround
                
                
                //Assembly account array
                for($k = 1; $k <= 4; $k++)
                {
                    
                    $account = array();
                    if($k % 2 == 1)
                    {
                        $account["social_network"] = 1; //Twitter ID at database
                        
                    }
                    else
                    {
                        $account["social_network"] = 2; //Facebook ID at database
                    }
                    
                    $account["profile_link"] = "https://profile.example/" . $faker->bothify('#?#?#?##');
                    $account["people"] = $i;
                    
                    $arrAccounts[] = $account;
                    
                    
                    $post = array();
                    //Mounting post array
                    for($j = 0; $j < 1000; $j++)
                    {
                        $post['text'] = $faker->sentence();
                        $post['date'] = $faker->date();
                        $post['link'] = "https://post.example/" . $faker->bothify('#?#?#?##');
                        $post['account'] = $countAccounts + 1;
                        
                        $arrPosts[] = $post;
                        
                        //Garbage collector
                        unset($post);
                        $countPosts++;
                        
                    }
                    unset($account);
                    $countAccounts++;
                }
                
                $countPeople++;
                
                //Inserting people
                $arrCount['people'] += \App\Providers\PeopleServiceProvider::importData($arrPeople);
                $arrCount['peopleBelongs'] += \App\Providers\PeopleBelongsServiceProvider::importData($arrPeopleBelongs);
                $arrCount['accounts'] += \App\Providers\AccountsServiceProvider::importData($arrAccounts);
                $arrCount['posts'] += \App\Providers\PostsServiceProvider::importData($arrPosts);
                
                //Free memory
                unset($arrPeople);
                unset($arrPeopleBelongs);
                unset($arrAccounts);
                unset($arrPosts);
                unset($faker);
                gc_collect_cycles();
                gc_mem_caches();
                echo $countPeople . " People inserted!" . PHP_EOL;
            }
        
            return $arrCount;
        }
        catch(Throwable $e)
        {
            report ($e);
            
            return $arrCount;
        }
    }
}

