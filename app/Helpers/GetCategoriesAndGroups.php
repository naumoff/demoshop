<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 04.12.2017
 * Time: 16:02
 */

namespace App\Helpers;

use App\Category;
use App\Group;

trait GetCategoriesAndGroups
{
    public function getCategoryAndCategories($categoryId = null)
    {
        if($categoryId == null){
            $categoryId = Category::getFirstActiveCategoryId();
            if($categoryId == null){
                return redirect()->route('admin-categories');
            }
        }
    
        $categories = Category::all();
        $category = Category::find($categoryId);
        
        return compact([
            'categories',
            'category',
            'categoryId'
        ]);
    }
    
    public function getGroupAndGroups($categoryId, $groupId = null)
    {
        $group = Group::where('category_id','=',$categoryId)
            ->find($groupId);
        
        if($group == null){
            $groupId = Group::getFirstActiveGroupId($categoryId);
            if($groupId == null){
                $groupId = Group::getFirstAnyGroupId($categoryId);
                if($groupId == null){
                    return redirect()->route('admin-groups',[
                        'cat_id'=>$categoryId
                    ]);
                }
            }
            $group = Group::find($groupId);
        }
        
        $groups = Group::where('category_id','=',$categoryId)->get();
        
        return compact([
            'groups',
            'group'
        ]);
    }
}