<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\DateTimeManipulation;
use App\Helpers\GetCategoriesAndGroups;
use App\Http\Requests\StorePackagePost;
use App\Http\Requests\UpdatePackagePatch;
use App\Jobs\Packages\UpdatePackageJob;
use App\Package;
use App\PackageProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackagesController extends Controller
{
    use GetCategoriesAndGroups,
        DateTimeManipulation;
    
    #region MAIN METHODS

    public function index()
    {
        $packages = Package::with('category')->paginate(10);
        return view('admin.packages.packages',[
            'packages'=>$packages
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        if($categories == null){
            return redirect()->route('admin-categories');
        }
        return view('admin.packages.create-package',[
            'categories'=>$categories
        ]);
    }

    public function store(StorePackagePost $request)
    {
        $package = new Package();
        $package->category_id = $request->input('category-id');
        $package->package_ru = $request->input('package-ru');
        $package->package_de = $request->input('package-de');
        $package->package_start_period = $request->input('package-start');
        $package->package_end_period = $request->input('package-end');
        $package->active = $request->input('package-active');
        $package->save();
        return redirect()->route('admin-create-package-products',[
            'pack_id'=>$package->id
        ]);
    }
    
    public function showPackageProductsList($packageId)
    {
        $package = Package::find($packageId);
        
        extract($this->getCategoryAndCategories($package->category_id));
    
        extract($this->getGroupAndGroups($category->id));
        
        $products = Package::find($packageId)->products()->paginate(5);
        
        return view('admin.packages.show-package-products-list',[
            'package'=>$package,
            'category'=>$category,
            'group'=>$group,
            'products'=>$products
        ]);
    }
    
    public function showProductsList($packageId, $categoryId = null, $groupId = null)
    {
        $package = Package::find($packageId);
        
        extract($this->getCategoryAndCategories($categoryId));
    
        extract($this->getGroupAndGroups($category->id, $groupId));
        
        $packageProductIds = PackageProduct::getProductIdsByPackageId($packageId);
        
        $products = Product::getProducts()
            ->byGroupId($groupId)
            ->excludeProductIds($packageProductIds)
            ->paginate(10);

        return view('admin.packages.add-package-products-list',[
            'categories'=>$categories,
            'category'=>$category,
            'groups'=>$groups,
            'group'=>$group,
            'package'=>$package,
            'products'=>$products
        ]);
    }
    
    public function edit($id)
    {
        $categories = Category::all();
        $package = Package::find($id);
        return view('admin.packages.edit-package',[
            'package'=>$package,
            'packageStart'=>$this->transformDateTime($package->package_start_period),
            'packageEnd'=>$this->transformDateTime($package->package_end_period),
            'categories'=>$categories
        ]);
    }

    public function update(UpdatePackagePatch $request, $id)
    {
        $package = Package::find($id);
        if($package == null){
            return redirect()->back();
        }
        
        if($request->input('package-active') == null){
            $request->merge(['package-active' => 0]);
        }
        
        $package->category_id = $request->input('category-id');
        $package->package_ru = $request->input('package-ru');
        $package->package_de = $request->input('package-de');
        $package->package_price = $request->input('price-rub');
        $package->package_start_period = $request->input('package-start');
        $package->package_end_period = $request->input('package-end');
        $package->active = $request->input('package-active');
        
        $package->save();
        
        return redirect()->back();
    }
    
    public function updatePackageRublePrice(Request $request)
    {
        $package = Package::find($request->input('package-id'));
        $package->price_rub_manual = $request->input('price-rub-manual');
        $package->save();
        return redirect()->back();
    }
    #endregion
    
    #region AJAX METHODS
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePackageStatus(Request $request)
    {
        $packageId = $request->input('package-id');
        $oldValue = $request->input('old-value');
        $newValue = ($oldValue == 1)? 0:1;
        $package = Package::find($packageId);
        $package->active = $newValue;
        $package->save();
        return 'SUCCESS';
    }
    
    public function destroy($id)
    {
        $package = Package::find($id);
        if($package === null){
            return 'Пакет не обнаружен. Скорее всего он уже удален!';
        }else{
            $package->delete();
            return 'SUCCESS';
        }
    }
    
    public function storeProductsList(Request $request)
    {
        $packageProduct = new PackageProduct();
        $packageProduct->package_id = $request->input('package-id');
        $packageProduct->product_id = $request->input('product-id');
        $packageProduct->save();
        
//        //updating package weight
//        $product = Product::find($request->input('product-id'));
//        $package = Package::find($request->input('package-id'));
//        $package->weight_gr = $package->weight_gr + $product->weight_gr;
//
//        //updating package automatic eur and rub price
//        $exchEurRub = CurrencyRate::getEurRubRate();
//        $package->price_eur = $package->price_eur + $product->price_eur;
//        $package->price_rub_auto = $package->price_eur * $exchEurRub;
//        $package->save();
    
        $package = Package::find($request->input('package-id'));
        UpdatePackageJob::dispatch($package);
        
        return 'SUCCESS';
    }
    
    public function deleteProductFromPackage(Request $request)
    {
        $productId =  $request->input('product-id');
        $packageId =  $request->input('package-id');
        $packageProduct = PackageProduct::where('package_id','=',$packageId)
            ->where('product_id','=',$productId)
            ->first();
        $packageProduct->delete();
        
//        //updating package weight
//        $product = Product::find($request->input('product-id'));
//        $package = Package::find($request->input('package-id'));
//        $package->weight_gr = $package->weight_gr - $product->weight_gr;
//        $package->save();
        
        $package = Package::find($request->input('package-id'));
        UpdatePackageJob::dispatch($package);
        
        return 'SUCCESS';
    }
    #endregion
}
