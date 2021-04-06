<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function welcome()
    {
        //En una variable, llamo al metodo de Eloquent ALL para traer todos los productos
       //$products = Product::all(); 
       
       $products = Product::where('active', true)->latest()->take(3)->get();
       //dd($products);
       //Obtengo las categorias para el Dropdown Menu
       //$categories = Category::orderBy('name')->get();

       //Cuando devuelve la vista, le agrega los productos. Con "compact" se envia todo el arreglo directamente sin tener que crearlo manualmente
       return view('welcome')->with(compact('products')); 
    }    
}
