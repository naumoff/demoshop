<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    #region CLASS PROPERTIES
    #endregion
    
    #region MAIN METHODS
    public function index()
    {
        return view('admin.products-home');
    }
    
    public function showCategories()
    {
        $categories = Category::getCategories()->paginate(2);
        return view('admin.products-categories')
            ->with('categories',$categories);
    }
    #endregion
}
