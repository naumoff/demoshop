<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Group;
use App\Http\Requests\EditCategoryPatch;
use App\Http\Requests\EditGroupPatch;
use App\Http\Requests\StoreCategoryPost;
use App\Http\Requests\StoreGroupPost;
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
    
    public function updateCategory(EditCategoryPatch $request)
    {
        $categoryId = $request->input('id');
        $categoryName = $request->input('category-name');
        $category = Category::find($categoryId);
        $category->category = $categoryName;
        $category->save();
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
    
    public function addGroup(StoreGroupPost $request)
    {
        $categoryId = $request->input('category-id');
        $newGroupName = $request->input('new-group');
        $newGroup = new Group();
        $newGroup->category_id = $categoryId;
        $newGroup->group = $newGroupName;
        $newGroup->active = 1;
        $newGroup->save();
        return back();
    }
    
    public function updateGroup(EditGroupPatch $request)
    {
        $categoryId = $request->input('category-id');
        $groupId = $request->input('group-id');
        $groupName = $request->input('group-name');
       
        $group = Group::find($groupId);
        $group->category_id = $categoryId;
        $group->group = $groupName;
        $group->active = 1;
        $group->save();
        return back();
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
    
    public function showProductsByCategoryByGroup($categoryId, $groupId)
    {
        $categories = Category::getCategories()
            ->Active()
            ->get();
    
        $category = Category::find($categoryId);
        
        $groups = Group::getGroups()
            ->Active()
            ->where('category_id','=',$category->id)
            ->get();
        
        $group = Group::where('category_id','=',$category->id)
            ->find($groupId);
        
        if($group === null){
            $group = Group::getGroups()
                ->active()
                ->where('category_id','=',$category->id)
                ->first();
        }
        
        $products = Product::getProducts()
            ->byCategoryId($category->id)
            ->byGroupId($group->id)
            ->paginate(10);
        
        return view('admin.products.category-group-products',[
            'categories'=>$categories,
            'category'=>$category,
            'groups'=>$groups,
            'group'=>$group,
            'products'=>$products
        ]);
    }
    
    public function createProduct(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        
        $categories = Category::getCategories()
            ->active()
            ->get();
    
        if($request->input('group')){
            $groupId = $request->input('group');
            
            $count = count($category->groups()->where('id','=',$groupId)->get());
            if($count == 0){
                unset($groupId);
            }
        }
    
        if(!isset($groupId)){
            $groupId = Group::getFirstActiveGroupId($categoryId);
        }
        
        $group = Group::find($groupId);
        
        $groups = Group::getGroups()
            ->byCategoryId($categoryId)
            ->active()
            ->get();
            
        return view('admin.products.add-product',
            [
                'category'=>$category,
                'group'=>$group,
                'categories'=>$categories,
                'groups'=>$groups
            ]
        );
    }
    
    public function addProduct(Request $request)
    {
    
    }
    
    public function editProduct($id)
    {
    
    }
    
    public function updateProduct(Request $request)
    {
    
    }
    #endregion
    
    #region AJAX REQUESTS
    public function changeCategoryStatus(Request $request)
    {
        $categoryId = $request->input('category-id');
        $oldValue = $request->input('old-value');
        $newValue = ($oldValue == 1)? 0:1;
        $category = Category::find($categoryId);
        $category->active = $newValue;
        $category->save();
        return 'SUCCESS';
    }
    
    public function changeGroupStatus(Request $request)
    {
        $groupId = $request->input('group-id');
        $oldValue = $request->input('old-value');
        $newValue = ($oldValue == 1)? 0:1;
        $group = Group::find($groupId);
        $group->active = $newValue;
        $group->save();
        return 'SUCCESS';
    }
    
    public function changeProductStatus(Request $request)
    {
        $productId = $request->input('product-id');
        $oldValue = $request->input('old-value');
        $newValue = ($oldValue == 1)? 0:1;
        $product = Product::find($productId);
        $product->active = $newValue;
        $product->save();
        return 'SUCCESS';
    }
    
    public function changeProductActionStatus(Request $request)
    {
        $productId = $request->input('product-id');
        $oldValue = $request->input('old-value');
        $newValue = ($oldValue == 1)? 0:1;
        $product = Product::find($productId);
        $product->discount_active = $newValue;
        $product->save();
        return 'SUCCESS';
    }
    
    public function deleteCategory(Request $request)
    {
        $categoryId = $request->input('category-id');
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
    
    public function deleteGroup(Request $request)
    {
        $groupId = $request->input('group-id');
        $group = Group::find($groupId);
        if (count($group->products) > 0) {
            return 'Группа содержит товары - пожалуйста, перед удалением группы удалите вложенные товары!';
        }else{
            $group->delete();
            return 'SUCCESS';
        }
    }
    
    public function deleteProduct(Request $request)
    {
        $productId = $request->input('product-id');
        $product = Product::find($productId);
        $product->delete();
        return 'SUCCESS';
    }
    #endregion
}
