<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\StorePackagePost;
use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackagesController extends Controller
{
    #region MAIN METHODS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::with('category')->paginate(10);
        return view('admin.packages.packages',[
            'packages'=>$packages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackagePost $request)
    {
        $package = new Package();
        $package->category_id = $request->input('category-id');
        $package->package_name = $request->input('package-ru');
        $package->package_price = $request->input('price-rub');
        $package->package_start_period = $request->input('package-start');
        $package->package_end_period = $request->input('package-end');
        $package->active = $request->input('package-active');
        $package->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(3);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd(1);
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
    #endregion
}
