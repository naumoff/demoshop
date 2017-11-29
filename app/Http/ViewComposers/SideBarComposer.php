<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 23.11.2017
 * Time: 18:02
 */

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Category;
use App\Group;

class SideBarComposer
{
    public function composeForAdmin(View $view)
    {
     
        $pathMask = $this->getPathMaskForAdminDashboard();
        
        $links = [];
        
        if($pathMask == 'users'){
            $links = config('links_admin.sidebar.users');
        }
        
        if($pathMask == 'products'){
            $links = config('links_admin.sidebar.products');
            $links = $this->replaceTokens($links);
        }

        $view->with('links', $links);
    }
    
    private function getPathMaskForAdminDashboard()
    {
        $path = $_SERVER['REQUEST_URI'];
        
        if(strpos($path,'admin/users')){
            return 'users';
        }
        
        if(strpos($path,'admin/products')){
            return 'products';
        }
    }
    
    private function replaceTokens($links)
    {
        $updatedLinks = [];
        foreach ($links AS $link){
            if(strpos($link['link'],'{cat_id}') !== false){
                $firstCatId = Category::getFirstActiveCategoryId();
                if($firstCatId === null){
                    continue;
                }
                $link['link'] = str_replace('{cat_id}', $firstCatId, $link['link']);
            }
            if(strpos($link['link'],'{group_id}') !== false){
                $firstGroupId = Group::getFirstActiveGroupId($firstCatId);
                $link['link'] = str_replace('{group_id}', $firstGroupId, $link['link']);
            }

            $updatedLinks[] = $link;
        };
        return $updatedLinks;
    }
}