<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\ListsServiceProvider;
use App\Providers\PostsServiceProvider;
use App\Providers\SocialNetworksServiceProvider;

class PostsController extends Controller
{
    //
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrLists = ListsServiceProvider::getLists();
        
        $arrSocialNetworks = SocialNetworksServiceProvider::getSocialNetworks();
        
        return view('posts.filter')->with('arrLists', $arrLists)->with('arrSocialNetworks', $arrSocialNetworks);
    }
    
    
    /**
     * Show the filtered posts
     *  
     *@param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $arrFilters = $request->all();
        
        $arrPosts = PostsServiceProvider::filter($arrFilters);
        
        $arrLists = ListsServiceProvider::getLists();
        $countPosts = count($arrPosts);
        $arrSocialNetworks = SocialNetworksServiceProvider::getSocialNetworks();
        
        if(isset($arrFilters['dateSince']) && (!isset($arrFilters['dateHence'])))
        {
            return view('posts.filter')->with('arrLists', $arrLists)->with('arrSocialNetworks', $arrSocialNetworks)->with('errorMsg', "Date hence needs to be filled.");
        }
        else if(!isset($arrFilters['dateSince']) && (isset($arrFilters['dateHence'])))
        {
            return view('posts.filter')->with('arrLists', $arrLists)->with('arrSocialNetworks', $arrSocialNetworks)->with('errorMsg', "Date since needs to be filled.");
        }
        else if(isset($arrFilters['dateSince']) && (isset($arrFilters['dateHence'])))
        {
            if(strtotime($arrFilters['dateHence']) < strtotime($arrFilters['dateSince']))
            {
                return view('posts.filter')->with('arrLists', $arrLists)->with('arrSocialNetworks', $arrSocialNetworks)->with('errorMsg', "Date since needs to be before date hence.");
            }
        }
        
        return view('posts.filter')->with('arrLists', $arrLists)->with('arrPosts', $arrPosts)->with('arrSocialNetworks', $arrSocialNetworks)->with('countPosts', $countPosts);
    }
}
