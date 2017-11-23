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

class SideBarComposer
{
    public function compose(View $view)
    {
        $pathMask = $this->getPathMask();
        
        $links = [];
        
        if($pathMask == 'users'){
            $links = config('links_admin.sidebar.users');
        }

        $view->with('links', $links);
    }
    
    private function getPathMask()
    {
        $path = $_SERVER['REQUEST_URI'];
        
        if(strpos($path,'admin/users')){
            return 'users';
        }
    }
}