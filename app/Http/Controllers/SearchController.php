<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)  
    {
        //Guardamos los datos introducidos en el formulario
        $query = $request->input('query');

        //Buscamos los productos comparando con el nombre del producto y la query
        $products = Product::where('active', true)->where('name', 'LIKE', '%' . $query . '%')->paginate(5);

        //Si el producto es exactamente 1 y su nombre es equivalente a la query pasada por parametro, redirecciono al usuario a la pagina del producto
        if($products->count() == 1 && $products->first()->name == $query)
        {
            $id = $products->first()->id;
            return redirect("products/$id"); //Usar comillas dobles es igual a '/products/' . $id; Es decir, las comillas dobles interpretan las variables dentro y no hace falta concatenar
        }

        //Devolvemos una vista con resultados
        return view('search.show')->with(compact('products', 'query'));
    }

    public function data()
    {
        //Como solo queremos los campos del nombre de los productos, utilizamos el metodo PLUCK que nos devuelve una columna en particular de todos los registros que buscamos
        $products = Product::where('active', true)->pluck('name');
        return $products;
    }
}
