<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Image;
use File;

class CategoryController extends Controller
{
    //Muestro el listado de categorias
    public function index()
    {
        //Las obtengo paginadas al listado de categorias y las devuelvo en la vista
        $categories = Category::where('active', true)->orderBy('name')->paginate(5);
        return view('admin.categories.index')->with(compact('categories'));
    }

    public function create()
    {
        //Solo devuelvo la vista con el formulario de registro
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        //Compruebo la validacion de sus campos
        $this->valid($request);

        //Almaceno los valores de los campos enviados y guardo un registro
        /*$category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $request->image;
        $category->save();*/

        //Otra forma de almacenar datos en la BD mas resumida a la anterior
        //Por medio del metodo create, podemos pasarle internamente un arreglo con los valores a crear en la nueva clase, o bien podemos definir en el modelo CATEGORY, cuales son los campos que SI van a poder utilizarse como asignacion masiva (VER EL MODELO CATEGORY)
        //Category::create($request->all()); //A esto se le conoce como asignacion masiva o mass assignment

        $category = Category::create($request->only('name', 'description'));

        //Consulto si hay una imagen en el input que llega por el request
        if ($request->hasFile('image')) {
            //Guardar la imagen en la carpeta de nuestro proyecto
            $file = $request->file('image');
            $path = public_path() . '/images/categories/'; // El public_path es la ruta absoluta hacia la carpeta PUBLIC dentro de nuestro proyecto
            $fileName = uniqid() . $file->getClientOriginalName(); //Se guarda un nombre en el cual se genera un ID unico y se concatena con el nombre del archivo

            //Redimensiono la imagen
            $moved = Image::make($file)
                ->resize(250, 250)
                ->save($path . $fileName);

            //Se usa una variable intermedia porque en servidores como Linux, si no se cuenta con permisos apropiados a veces no crea la carpeta y si no lo verificamos antes de guardar la imagen en la BD, de igual forma se guardara a pesar de no tener carpeta
            //Esta forma es sin usar el Intervention Image para redimensionar la imagen, simplemente se guarda como viene
            //$moved = $file->move($path, $fileName); //Finalmente al archivo se lo guarda en la ruta con el nombre indicado

            //Actualizar el registro en la base de datos
            if ($moved) {
                $category->image = $fileName;
                $category->save(); //Realiza un UPDATE
            }
        }

        $notification = 'La categoría fue creada exitosamente.';
        return redirect('/admin/categories')->with(compact('notification'));
    }
    //Otra forma de que cuando recibimos un parametro por la URL, lo utilicemos de forma directa es colocando el objeto de la clase indicada y el mismo realiza una busqueda y se instancia con el valor pasado por la URL. Hay que tenes en cuenta que el parametro a recibir se llame igual al que se pasa por la URL desde la RUTA
    //public function edit($id){
    public function edit(Category $category)
    {
        //Encuentro la categoría solicitada y devuelvo un json con sus valores
        //$category = Category::find($id);

        //Utilizando la otra forma de recibir un parametro y ya buscar el objeto apropiado directamente devolvemos la vista con el objeto ya instanciado
        return view('admin.categories.edit')->with(compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        //Compruebo la validacion de sus campos
        $this->valid($request);

        //Encuentro la categoria editada, le cambio los valores por lo que traiga y actualizo el registro
        /*$category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $request->image;
        $category->save();*/

        //Aplicando la forma de actualizar por medio de todos los campos
        $category->update($request->only('name', 'description'));

        //Consulto si hay una imagen en el input que llega por el request
        if ($request->hasFile('image')) {
            //Guardar la imagen en la carpeta de nuestro proyecto
            $file = $request->file('image');
            $path = public_path() . '/images/categories/'; // El public_path es la ruta absoluta hacia la carpeta PUBLIC dentro de nuestro proyecto            
            $fileName = uniqid() . $file->getClientOriginalName(); //Se guarda un nombre en el cual se genera un ID unico y se concatena con el nombre del archivo

            //Redimensiono la imagen
            $moved = Image::make($file)
                ->resize(250, 250)
                ->save($path . $fileName);

            //Actualizar el registro en la base de datos
            if ($moved) {
                //Elimino la imagen anterior
                //Guardo el PATH anterior y el nombre de la imagen
                $previousPath = $path . '/' . $category->image;

                $category->image = $fileName;
                $saved = $category->save(); //Realiza un UPDATE

                //Si se salvo correctamente, elimino el archivo del PATH anterior
                if ($saved)
                    File::delete($previousPath);
            }
        }

        $notification = 'La categoría fue editada correctamente.';
        return redirect('/admin/categories')->with(compact('notification'));
    }

    public function destroy(Category $category)
    {
        //Encuentro la categoria y aplico el metodo delete (SE CAMBIO EL ID POR EL CASTEO DE LA CATEGORIA EN EL PARAMETRO DIRECTAMENTE)
        //$category = Category::find($id);
        $category->delete();

        //Uso una variable flash
        $notification = 'La categoría fue eliminada correctamente.';
        return back()->with(compact('notification'));
    }

    //Validaciones generales para almacenar y editar categorias
    public function valid(Request $request)
    {   //Es una forma distinta de hacer la validacion a la vista en las categorias. VER CATEGORY MODEL
        $this->validate($request, Category::$rules, Category::$messages);
    }

    public function delete(Request $request)
    {
        //Busco los productos activos dentro de la categorias
        $products = Product::where('active', true)->where('category_id', $request->categoryID)->get();
        //Si hay algun producto activo, evito la baja de la categoría
        if (Count($products) > 0) {
            $error = 'No se pudo eliminar la categoría dado que todavía existen ' . Count($products) . ' productos activos, por favor delos de baja antes.';
            return redirect('/admin/categories')->with(compact('error'));
        }

        //Modifico a la categoria su estado
        $category = Category::find($request->categoryID);
        $category->active = false;
        if ($category->save()) {
            $updatedCategory = 'La categoría fue eliminada correctamente.';
            return redirect('/admin/categories')->with(compact('updatedCategory'));
        }

        $error = 'No se pudo eliminar la categoría.';
        return redirect('/admin/categories')->with(compact('error'));
    }
}
