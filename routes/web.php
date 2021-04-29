<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

//SOLO USAR METODO GET SI NECESITO OBTENER DATOS, PARA CUALQUIER OTRA OPERACION USO METODO POST COMO REGISTRAR, ACTUALIZAR O ELIMINAR ELEMENTOS
Route::get('/', 'TestController@welcome');
/*Route::get('/mailable', function(){     
    $cart = App\Cart::where('id', '10')->first(); 
   return new App\Mail\OrderUpdated($cart);
});*/


//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/confirmation', 'Auth\EmailController@confirm');

//InfoController manejara todo lo relacionado a la informacion disponible en el footer
Route::get('/contact', 'InfoController@contact');
Route::post('/send', 'InfoController@sendEmail');

Route::prefix('/home')->group(function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/cart', 'HomeController@index')->name('cart');
    Route::get('/orders', 'HomeController@index')->name('orders');
    Route::get('/settings', 'HomeController@index')->name('settings');
    Route::post('', 'HomeController@update'); //Actualizar Datos del Usuario Colocar / o nada en la ruta es lo mismo
});

Route::get('/search', 'SearchController@show'); //Realizar una busqueda de todos los productos dentro de una categoria
Route::get('/products/json', 'SearchController@data'); //Ruta para devolverle un objeto JSON al buscador predictivo de la vista WELCOME

//IMPORTANTE => TENER CUIDADO AL MOMENTO DE DEFINIR RUTAS CON EL MISMO NOMBRE, COMO PRODUCTS, PORQUE EN EL ORDEN EN QUE SE COLOQUEN EN ESTE ARCHIVO
//SERA LA PRIORIDAD DE COMO SE RESOLVERA. LA RUTA SUPERIOR /products/json SE RESUELVE ANTES QUE /products/{id}, PERO SI LAS COLOCO EN ORDEN DISTINTO
//VA A HABER PROBLEMAS AL TRATAR DE INGRESAR A /products/json PORQUE EL OBJETO JSON QUE SE CREA EN ESTA RUTA SERA TOMADA POR EL {id} DE LA OTRA QUE ESTA SUPERIOR A ÉSTA
//Route::get('/products/{id}', 'ProductController@show');
//Route::get('/products/json', 'SearchController@data');

Route::get('/products/{id}', 'ProductController@show'); // Mostrar datos de un producto a un usuario general
Route::get('/categories', 'CategoryController@index'); //Muestra el listado de categorias disponibles
//Route::get('/categories/{category}', 'CategoryController@show'); //Mostrar los productos de una categoria
Route::get('/categories/{category}', 'CategoryController@show');

Route::post('/cart', 'CartDetailController@store');
Route::delete('/cart', 'CartDetailController@destroy');

Route::get('/order/{cart}', 'CartController@show');
Route::post('/order', 'CartController@update'); //Actualiza el estado del carro de Activo a Pendiente, queriendo decir que se realizo una nueva orden de compra

//PayPal
Route::get('/paypal/pay', 'PaypalPaymentController@pay');
Route::get('/paypal/cancelled', 'PaypalPaymentController@cancel');
Route::get('/paypal/status', 'PaypalPaymentController@status');

//MercadoPago
Route::get('/mercadopago/pay', 'MercadoPagoController@pay'); //Formulario
Route::get('/mercadopago/cancelled', 'MercadoPagoController@cancel'); //Vuelta Carro
Route::post('/mercadopago/process', 'MercadoPagoController@processForm'); //Procesa los datos enviados por el formulario hacia MP

//Utilizamos un middleware para asociarlo a un grupo de rutas, de esta forma se aplicara a cualquier ruta dentro del grupo elegido
//Para usar el prefijo 'admin' se le aplico un alias al AdminMiddleware.php en el archivo Kernel.php dentro de App\Http
/*Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/products', 'ProductController@index'); // Listar productos y acceder a modificar o eliminar
    Route::get('/admin/products/create', 'ProductController@create'); // Crear producto
    Route::post('/admin/products', 'ProductController@store'); // Guardar el registro del producto
    Route::get('/admin/products/{id}/edit', 'ProductController@edit'); // Mostrar datos de un producto
    Route::post('/admin/products/{id}/edit', 'ProductController@update'); // Guardar los cambios del producto
    //Al usar el metodo DELETE, explicitamente estamos indicando que queremos borrar algo, por eso no lleva la palabar DELETE en la URL
    //Route::delete('/admin/products/{id}/delete', 'ProductController@destroy'); // Eliminar el registro de un producto
    Route::delete('/admin/products/{id}', 'ProductController@destroy');
    //Otros metodos que podemos usar son PUT, PATCH y DELETE los cuales son variaciones del tipo POST
});*/

//Gracias al prefijo admin (en minuscula) ya no sera necesario incluirlo en las rutas
//Al crear una carpeta ADMIN dentro de CONTROLLERS, se tuvo que actualizar el namespace dentro de cada controlador y la directiva USE para indicarle que el archivo Controller se encuentra en la ruta apropiada y no dentro de la carpeta ADMIN
/*Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/products', 'Admin\ProductController@index'); // Listar productos y acceder a modificar o eliminar
    Route::get('/products/create', 'Admin\ProductController@create'); // Crear producto
    Route::post('/products', 'Admin\ProductController@store'); // Guardar el registro del producto
    Route::get('/products/{id}/edit', 'Admin\ProductController@edit'); // Mostrar datos de un producto
    Route::post('/products/{id}/edit', 'Admin\ProductController@update'); // Guardar los cambios del producto
    //Al usar el metodo DELETE, explicitamente estamos indicando que queremos borrar algo, por eso no lleva la palabar DELETE en la URL
    //Route::delete('/admin/products/{id}/delete', 'Admin\ProductController@destroy'); // Eliminar el registro de un producto
    Route::delete('/products/{id}', 'Admin\ProductController@destroy');
    //Otros metodos que podemos usar son PUT, PATCH y DELETE los cuales son variaciones del tipo POST

    //Listado de Imagenes y subir nuevas
    Route::get('/products/{id}/images', 'Admin\ImageController@index'); //Para mostrar imagenes
    Route::post('/products/{id}/images', 'Admin\ImageController@store'); //Para guardar las imagenes
    Route::delete('/products/{id}/images', 'Admin\ImageController@destroy'); //Para eliminar imagenes
    Route::get('/products/{id}/images/select/{image}', 'Admin\ImageController@select'); //Para destacar imagenes
});*/

//Se le agrega un Namespace de Admin para la ruta de los controladores
Route::middleware(['auth', 'admin'])->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/products', 'ProductController@index'); // Listar productos y acceder a modificar o eliminar
    Route::get('/products/create', 'ProductController@create'); // Crear producto
    Route::post('/products', 'ProductController@store'); // Guardar el registro del producto
    Route::get('/products/{id}/edit', 'ProductController@edit'); // Mostrar datos de un producto
    Route::post('/products/{id}/edit', 'ProductController@update'); // Guardar los cambios del producto
    //Al usar el metodo DELETE, explicitamente estamos indicando que queremos borrar algo, por eso no lleva la palabar DELETE en la URL
    //Route::delete('/admin/products/{id}/delete', 'Admin\ProductController@destroy'); // Eliminar el registro de un producto
    //Route::delete('/products/{id}', 'ProductController@destroy'); //Eliminacion de registro de la bd
    Route::post('/products/delete', 'ProductController@delete'); //Eliminacion logica
    //Otros metodos que podemos usar son PUT, PATCH y DELETE los cuales son variaciones del tipo POST

    //Listado de Imagenes y subir nuevas
    Route::get('/products/{id}/images', 'ImageController@index'); //Para mostrar imagenes
    Route::post('/products/{id}/images', 'ImageController@store'); //Para guardar las imagenes
    Route::delete('/products/{id}/images', 'ImageController@destroy'); //Para eliminar imagenes
    Route::get('/products/{id}/images/select/{image}', 'ImageController@select'); //Para destacar imagenes


    //Rutas de Categorias. Usamos como parametros CATEGORY para los ID porque vamos a CASTEAR directamente sobre el metodo del controlador y deben llamarse igual a lo que espera el parametro dentro del metodo
    Route::get('/categories', 'CategoryController@index'); // Listar categorias y acceder a modificar o eliminar
    Route::get('/categories/create', 'CategoryController@create'); // Crear categoria
    Route::post('/categories', 'CategoryController@store'); // Guardar el registro de una categoria
    Route::get('/categories/{category}/edit', 'CategoryController@edit'); // Mostrar datos de un categoria
    Route::post('/categories/{category}/edit', 'CategoryController@update'); // Guardar los cambios de la categoria
    //Al usar el metodo DELETE, explicitamente estamos indicando que queremos borrar algo, por eso no lleva la palabar DELETE en la URL
    //Route::delete('/categories/{category}', 'CategoryController@destroy'); //Eliminacion de registro de la bd
    Route::post('/categories/delete', 'CategoryController@delete'); //Eliminacion logica

    //Rutas de Ordenes de Compras
    Route::get('/orders', 'OrderController@index'); //Ver listado de pedidos realizados
    Route::get('/orders/{order}', 'OrderController@edit'); //Ver listado de pedidos realizados
    Route::post('/orders/{order}/edit', 'OrderController@update'); // Guardar los cambios de una orden de compra
});
