<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePresentPost;
use App\Http\Requests\UpdatePresentPatch;
use App\Present;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PresentsController extends Controller
{
    #region MAIN METHODS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presents = Present::orderBy('min_order_value_rub','asc')
            ->paginate(15);

        return view('admin.presents.presents',[
            'presents'=>$presents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.presents.create-present');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePresentPost $request)
    {
        $present = new Present();
        $present->present_ru = $request->input('present-ru');
        $present->present_de = $request->input('present-de');
        $present->description = $request->input('description');
        $present->weight_gr = $request->input('weight-gr');
        $present->min_order_value_rub = $request->input('min-order-value-rub');
        $present->max_order_value_rub = $request->input('max-order-value-rub');
        $present->active = ($request->active == 1)? 1:0;
        $present->save();
        
        $urls = [];
        foreach($request->urls AS $file){
            $extension = $file->extension();
            $fileName = $present->id.'-'.uniqid().'.'.$extension;
            $file->storeAs('/public/presents/',$fileName);
            $url = Storage::disk('presents')->url($fileName);
            $urls[] = $url;
        };
        $present->urls = serialize($urls);
        $present->save();
        
        return redirect()->route('presents.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $present = Present::find($id);

        return view('admin.presents.edit-present',['present'=>$present]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePresentPatch $request, $id)
    {
        if($request->input('active') === null){
            $request->merge(['active'=>0]);
        }
        $present = Present::find($id);
        $present->present_ru = $request->input('present-ru');
        $present->present_de = $request->input('present-de');
        $present->description = $request->input('description');
        $present->weight_gr = $request->input('weight-gr');
        $present->min_order_value_rub = $request->input('min-order-value-rub');
        $present->max_order_value_rub = $request->input('max-order-value-rub');
        $present->active = $request->input('active');
        $present->save();
        return redirect()->back();
        
    }

    public function editPhoto($id)
    {
        $present = Present::find($id);
        return view('admin.presents.edit-photo',['present'=>$present]);
    }
    
    public function deletePhoto(Request $request, $id)
    {
        $present = Present::find($id);
        $urls = unserialize($present->urls);
        foreach ($urls AS $key=>$url){
            if($url == $request->input('url')){
                $this->deleteRealPhoto($url);
                unset($urls[$key]);
            }
        }
        $present->urls = serialize($urls);
        $present->save();
        return 'SUCCESS';
    }
    
    public function addPhoto(Request $request, $id)
    {
        $present = Present::find($id);
        $oldUrls = unserialize($present->urls);
    
        $newUrls = [];
        foreach($request->urls AS $file){
            $extension = $file->extension();
            $fileName = $present->id.'-'.uniqid().'.'.$extension;
            $file->storeAs('/public/presents/',$fileName);
            $url = Storage::disk('presents')->url($fileName);
            $newUrls[] = $url;
        };
        
        $updatedUrls = array_merge($oldUrls, $newUrls);
        $present->urls = serialize($updatedUrls);
        $present->save();
        
        return redirect()->back();
    }
    
    #endregion
    
    #region AJAX METHODS
    public function changePresentStatus(Request $request)
    {
        $presentId = $request->input('present-id');
        $oldValue = $request->input('old-value');
        $newValue = ($oldValue == 1)? 0:1;
        $present = Present::find($presentId);
        $present->active = $newValue;
        $present->save();
        return 'SUCCESS';
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $present = Present::find($id);
        $present->delete();
        $this->deleteAllPresentPhotos($id);
        return 'SUCCESS';
    }
    #endregion
    
    #region SERVICE METHODS
    private function deleteRealPhoto($url)
    {
        $file = basename($url);
        Storage::disk('presents')->delete($file);
    }
    
    private function deleteAllPresentPhotos($presentId)
    {
        $files = Storage::disk('presents')->files('/');

        $mask = "/^{$presentId}\-.*/i";
        foreach ($files AS $file){
            if(preg_match($mask,$file)===1){
                Storage::disk('presents')->delete($file);
            }
        };
    }
    #endregion
    
}
