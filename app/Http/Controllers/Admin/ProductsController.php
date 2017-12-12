<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Color;
use App\ColorProduct;
use App\CurrencyRate;
use App\Events\ExchangeRateUpdated;
use App\Group;
use App\Helpers\DateTimeManipulation;
use App\Http\Requests\EditCategoryPatch;
use App\Http\Requests\EditGroupPatch;
use App\Http\Requests\StoreCategoryPost;
use App\Http\Requests\StoreCurrencyRatePost;
use App\Http\Requests\StoreGroupPost;
use App\Http\Requests\StoreProductPost;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{
    use DateTimeManipulation;
    
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
       
        $categories = Category::getCategories()->get();
        $category = Category::find($category_id);
        $groups = $category->groups;
        
        return view('admin.products.category-groups')
            ->with([
                'categories'=>$categories,
                'category'=>$category,
                'categoryActive'=>$category->active,
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
    
    public function showProductsByCategoryByGroup($categoryId, $groupId)
    {
     
        $categories = Category::all();
        $category = Category::find($categoryId);
        
        $groups = Group::getGroups()->byCategoryId($categoryId)->get();
        
        $groupIdCheck = Group::getGroups()->byCategoryId($categoryId)->find($groupId);
        
        if($groupIdCheck == null){
            $group = Group::find(Group::getFirstActiveGroupId($categoryId));
            if($group === null){
                $group = Group::find(Group::getFirstAnyGroupId($categoryId));
                if($group === null){
                    return redirect()->route('admin-groups',['cat_id'=>$categoryId]);
                }
            }
        }else{
            $group = Group::find($groupId);
        }
        

        $products = Product::getProducts()->byGroupId($groupId)->paginate(10);
        
        $groupActivity = $group->active;
        $categoryActivity = $category->active == 1;

        return view('admin.products.category-group-products',[
            'categories'=>$categories,
            'category'=>$category,
            'groups'=>$groups,
            'group'=>$group,
            'products'=>$products,
            'categoryActive'=>$categoryActivity,
            'groupActive'=>$groupActivity
        ]);
    }
    
    public function createProduct(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        
        $categories = Category::getCategories()
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
            if($groupId == null){
                $groupId = Group::getFirstAnyGroupId($categoryId);
                if($groupId == null){
                    return redirect()->route('admin-groups',['cat_id'=>$categoryId]);
                }
            }
        }
        
 
        $group = Group::find($groupId);
        $groups = Group::getGroups()
            ->byCategoryId($categoryId)
            ->get();
            
        return view('admin.products.add-product',
            [
                'category'=>$category,
                'categoryActive'=>$category->active,
                'groupActive'=>$group->active,
                'group'=>$group,
                'categories'=>$categories,
                'groups'=>$groups
            ]
        );
    }
    
    public function addProduct(StoreProductPost $request)
    {
        $postData = $this->formProductCreateData($request);
        $product = Product::create($postData);

        return redirect()->route('admin-create-photo',['prod_id'=>$product->id]);
        
    }
    
    public function createPhoto($productId)
    {
        $product = Product::find($productId);
        $colors = Color::getColors();
        return view('admin.products.add-photo',[
            'product'=>$product,
            'colors'=>$colors
        ]);
    }
    
    public function addPhoto(Request $request)
    {
        $input = $request->except(['_token','product-id','product-name']);
    
        foreach ($input as $key=>$photo) {
            $files = $request->file($key);
            if(!empty($files)){
                foreach ($files AS $file){
                    $fileExtension = $file->extension();
                    $fileName = $key.'-'.uniqid().'.'.$fileExtension;
                    $pathToFile = null;
                    $file->storeAs('/public/products/',$fileName);
                    $colorId = $this->getColorId($key);
                    ColorProduct::create([
                        'color_id'=>$colorId,
                        'product_id'=>$request->input('product-id'),
                        'url'=>Storage::disk('products')->url($fileName)
                    ]);
                }
            }
        }
        
        return redirect()
            ->route('admin-edit-product-photo',['prod_id'=>$request->input('product-id')]);
    }
    
    public function editProduct($productId)
    {
        $product = Product::find($productId);
        
        if($product->discount_start !== null){
            $product->discount_start = $this->transformDateTime($product->discount_start);
        }
        
        if($product->discount_end !== null){
            $product->discount_end = $this->transformDateTime($product->discount_end);
        }
        return view('admin.products.edit-product',[
            'product'=>$product
        ]);
    }
    
    public function updateProduct(Request $request)
    {
        $updateDate = $this->formProductCreateData($request);
        Product::where('id','=',$request->input('id'))
            ->update($updateDate);
        
        $groupId = $request->input('group-id');

        return redirect()->back();
    }
    
    public function editPhoto(Request $request, $productId)
    {
        $product = Product::find($productId);
        $photos = ColorProduct::byProductId($productId)->get();
        
        return view('admin.products.edit-photo',[
            'product'=>$product,
            'photos'=>$photos
        ]);
    }
    
    public function createCurrencyRate()
    {
        $currentRate = CurrencyRate::getEurRubRate();

        $allRates = CurrencyRate::orderBy('created_at','desc')->paginate(15);
        return view('admin.products.edit-currency-rate',[
                'currentRate'=>$currentRate,
                'allRates'=>$allRates
            ]
        );
    }
    
    public function storeCurrencyRate(StoreCurrencyRatePost $request)
    {
        $currencyRate = new CurrencyRate();
        $currencyRate->eur_rub = $request->input('eur-rub');
        $currencyRate->save();
        
        //updating all products prices
        event(new ExchangeRateUpdated(new CurrencyRate()));
        
        return back();
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
    
    public function deletePhoto(Request $request)
    {
        $photoId = $request->input('photo-id');
        $photo = ColorProduct::find($photoId);
        Storage::disk('products')->delete(basename($photo->url));
        $photo->delete();
        return 'SUCCESS';
    }
    
    public function formGroupLoaderForProductPhoto($productId, $colorCode)
    {
        $fieldName = $colorCode.'-'.$productId;
        
        if($colorCode === 'xxx'){
            $colorCode = null;
        }

        return view('inclusions.admin.add-photo-form-item',[
            'color'=>$colorCode,
            'fieldName'=>$fieldName
        ]);
    }
    #endregion
    
    #region SERVICE METHODS
    
    private function formProductCreateData(Request $request)
    {
        return [
            'group_id' => $request->input('group-id'),
            'product_ru' => $request->input('product-ru'),
            'product_de' => $request->input('product-de'),
            'description' => $request->input('description'),
            'price_eur' => $request->input('price-eur'),
            'price_rub_auto' => $this->calculateRublePrice($request->input('price-eur')),
            'price_rub_manual' => $request->input('price-rub-manual'),
            'price_with_discount' => $request->input('price-with-discount'),
            'discount_start' => $request->input('discount-start'),
            'discount_end' => $request->input('discount-end'),
            'discount_active' => ($request->input('discount-active') == null)? 0:1,
            'weight_gr' => $request->input('weight-gr'),
            'active' => ($request->input('product-active') == null)? 0:1
        ];
    }
    
    private function calculateRublePrice($eurPrice)
    {
        $rubRate = CurrencyRate::getEurRubRate();
        return round($eurPrice * (float)$rubRate,2);
    }
   
    private function getColorId($key){
        $pattern = '/-.*/i';
        $colorName = preg_replace($pattern,'',$key);
        $colorId = Color::getColorIdFromColorName($colorName);
        return $colorId;
    }
   
    #endregion
}
