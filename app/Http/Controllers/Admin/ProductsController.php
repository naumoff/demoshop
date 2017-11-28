<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\StoreCategoryPost;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    #region CLASS PROPERTIES
    #endregion
    
    #region MAIN METHODS
    public function index()
    {
        return view('admin.products.products-home');
    }
    
    public function showCategories()
    {
        $categories = Category::getCategories()->paginate(2);
        return view('admin.products.categories')
            ->with('categories',$categories);
    }
    
    public function addCategory(StoreCategoryPost $request)
    {
        $newCategoryName = $request->input('new-category');
        $newCategory = new Category();
        $newCategory->category = $newCategoryName;
        $newCategory->active = 1;
        $newCategory->save();
        return back();
    }
    
    public function showGroupsByCategory($category_id)
    {
       
        $categories = Category::getCategories()->Active()->get();
        $category = Category::find($category_id);
        $groups = $category->groups;
        
        return view('admin.products.category-groups')
            ->with([
                'categories'=>$categories,
                'category'=>$category,
                'groups'=>$groups
            ]);
    }
    
    
    public function showProductsByCategory($category_id)
    {
        $categories = Category::getCategories()
            ->Active()
            ->get();
        
        $category = Category::find($category_id);
        
        $products = Product::getProducts()
            ->byCategoryId($category_id)
            ->paginate(10);

        return view('admin.products.category-products')
            ->with([
                'categories'=>$categories,
                'category'=>$category,
                'products'=>$products
            ]);
    }
    #endregion
    
    #region AJAX REQUESTS
    public function changeCategoryStatus(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $oldValue = $request->input('oldValue');
        $newValue = ($oldValue == 1)? 0:1;
        $category = Category::find($categoryId);
        $category->active = $newValue;
        $category->save();
        return 'SUCCESS';
    }
    
    public function deleteCategory(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $category = Category::find($categoryId);
        if (count($category->groups) > 0) {
            return 'Категория содержит группы - пожалуйста, перед удалением категории удалите вложенные группы!';
        }elseif (count($category->products) > 0 ){
            return 'Категория содержит вложенные товары - пожалуйста, перед удалением категории удалите вложенные товары!';
        }else{
            $category->delete();
            return 'SUCCESS';
        }
    }

    #endregion
}
