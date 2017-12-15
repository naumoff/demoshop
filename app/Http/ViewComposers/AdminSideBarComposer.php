<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 23.11.2017
 * Time: 18:02
 */

namespace App\Http\ViewComposers;

use App\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Category;
use App\Group;

class AdminSideBarComposer
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
            $links = $this->replacePathTokens($links);
        }
        
        if($pathMask == 'packages'){
            $links = config('links_admin.sidebar.packages');
        }
        
        if($pathMask == 'presents'){
            $links = config('links_admin.sidebar.presents');
        }
        
        if($pathMask == 'partners'){
            $links = config('links_admin.sidebar.partners');
        }
        
        if($pathMask == 'sales'){
            $links = config('links_admin.sidebar.sales');
            $links = $this->replaceQtyTokens($links);
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
        
        if(strpos($path,'admin/packages')){
            return 'packages';
        }
        
        if(strpos($path,'admin/presents')){
            return 'presents';
        }
        
        if(strpos($path,'admin/partners')){
            return 'partners';
        }
        
        if(strpos($path,'admin/sales')){
            return 'sales';
        }
    }
    
    private function replacePathTokens($links)
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
    
    private function replaceQtyTokens($links)
    {
        $updatedLinks = [];
        foreach ($links AS $link){
            //replace tokens in qty
            if(isset($link['qty'])){
                switch($link['qty']){
                    case '{not-paid-orders}':
                        $link['qty'] = Order::notPaid()->valid()->get()->count();
                    break;
                    case '{paid-orders}':
                        $link['qty'] = Order::paid()->get()->count();
                    break;
                    case '{dispatched-orders}':
                        $link['qty'] = Order::dispatched()->get()->count();
                    break;
                    case '{overdue-orders}':
                        $link['qty'] = Order::overdue()->get()->count();
                    break;
                }
            }
            $updatedLinks[] = $link;
        }
        return $updatedLinks;
    }
}