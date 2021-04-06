<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        //El metodo HAS es un SQL JOIN en donde se establece que busque las categorias que tengan productos
        $categories = Category::where('active', true)->has('activeProducts')->get();
        return view('categories.index')->with(compact('categories'));
    }

    /*public function show(Category $category)
    {
        //Obtenemos los productos de una categoria en particular de forma paginada. Se los pasamos a la vista
        $products = $category->products()->paginate(10);
        return view ('categories.show')->with(compact('category', 'products'));
    } */

    public function show(Category $category)
    {
        //Obtenemos los productos de una categoria en particular de forma paginada. Se los pasamos a la vista
        $products = $category->activeProducts()->paginate(10);

        return view('categories.show')->with(compact('category', 'products'));
    }
}
