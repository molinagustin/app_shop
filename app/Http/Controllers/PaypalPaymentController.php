<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPalHttp\HttpException;
use App\Cart;
use App\Mail\NewOrder;
use App\Mail\OrderRequested;
use Carbon\Carbon;
use App\User;
use Mail;
use Illuminate\Support\Facades\Http;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaypalPaymentController extends Controller
{
    private $client;

    public function __construct()
    {
        //Obtengo los valores de configuracion del archivo paypal.php de config
        $payPalConfig = Config::get('paypal');
        //Guardo las credenciales del usuario que recibira el dinero
        $environment = new sandboxEnvironment($payPalConfig['client_id'], $payPalConfig['secret']);
        //Creo el usuario al que sera depositada la transaccion y lo dejo como global para no tener q crearlo constantemente
        $this->client = new PayPalHttpClient($environment);
    }

    public function pay()
    {
        //Obtengo el carro del usuario activo que va a realizar el pago
        $cart = Cart::where('user_id', Auth()->user()->id)->where('status_id', '1')->get();

        //Obtengo el valor de los producto dolarizados (Tiene que ser exacto por eso lo convierto por separado)
        $saleValue = 0;
        $ars_usd = $this->currencyConverter('USD', 'ARS'); //Conversion a dolar oficial
        foreach ($cart[0]->details as $detail) {
            $saleValue += number_format((float)($detail->product->price / $ars_usd), 2, '.', '') * $detail->quantity; //Conversion aproximada a USD
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "application_context" => [
                'brand_name' => 'AlVenta', //Nombre de la empresa
                'landing_page' => 'BILLING',
                'user_action' => 'PAY_NOW', //Accion a realizar por el usuario en la pagina destino (Es por defecto PAY_NOW)
                "cancel_url" => url('/paypal/cancelled'),
                "return_url" => url('/paypal/status')
            ],
            "purchase_units" => [[
                "reference_id" => 'Venta #' . $cart[0]->id, //Id del carro de compras
                'description' => 'Compra en AlVenta',
                'custom_id' => 'Venta #' . $cart[0]->id,
                'soft_descriptor' => 'Productos Varios',
                "amount" => [
                    "value" => number_format((float)($saleValue) + 5, 2, '.', ''),
                    "currency_code" => "USD",
                    'breakdown' =>
                    [
                        'item_total' =>
                        [
                            'currency_code' => 'USD',
                            'value' => number_format((float)($saleValue), 2, '.', ''),
                        ],
                        'shipping' =>
                        [
                            'currency_code' => 'USD',
                            'value' => '5.00',
                        ],
                        'handling' =>
                        [
                            'currency_code' => 'USD',
                            'value' => '0.00',
                        ],
                        'tax_total' =>
                        [
                            'currency_code' => 'USD',
                            'value' => '0.00',
                        ],
                        'shipping_discount' =>
                        [
                            'currency_code' => 'USD',
                            'value' => '0.00',
                        ],
                    ],
                ],
                'items' => $this->setItemsArray(),
                //Para usar el shipping hace falta mejor base de datos del usuario
                /*'shipping' =>
                    [
                        'method' => 'Correo Argentino',
                        'address' =>
                        [
                            'address_line_1' => '123 Townsend St',
                            'address_line_2' => 'Floor 6',
                            'admin_area_2' => 'San Francisco',
                            'admin_area_1' => 'CA',
                            'postal_code' => '94107',
                            'country_code' => 'US',
                        ],
                    ],*/
            ]],
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);
            session(['respId' => $response->result->id]);
            $redirectLink = $response->result->links[1]->href;
            return redirect()->away($redirectLink);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
            //Para produccion se quitan los mensajes y se redirige al usuario
            //return redirect(route('cart'));
        }
    }

    public function cancel()
    {
        $cancelled = 'El pago ha sido cancelado.';
        return redirect(route('cart'))->with(compact('cancelled'));
    }

    public function status(Request $status)
    {
        $token = $status->input('token');
        $PayerID = $status->input('PayerID');

        if (!$token || !$PayerID) {
            $error = 'El pago no pudo ser procesado, por favor, verifique sus credenciales de PayPal.';
            return redirect(route('cart'))->with(compact('error'));
        }

        // Here, OrdersCaptureRequest() creates a POST request to /v2/checkout/orders
        // $response->result->id gives the orderId of the order created above
        $request = new OrdersCaptureRequest(session()->pull('respId'));
        $request->prefer('return=representation');

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //print_r($response);
            if ($response->result->status === 'COMPLETED') {
                $this->updateCartPayed();
                $notification = 'El pago se proceso correctamente y el pedido está siendo preparado. Te contactaremos pronto vía email.';
                return redirect(route('cart'))->with(compact('notification'));
            }

            $error = 'El pago no pudo ser procesado, por favor, verifique sus credenciales de PayPal y sus fondos.';
            return redirect(route('cart'))->with(compact('error'));
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
            //Para produccion se quitan los mensajes y se redirige al usuario
            //return redirect(route('cart'));
        }
    }

    private function setItemsArray()
    {
        $cart = Cart::where('user_id', Auth()->user()->id)->where('status_id', '1')->get();
        $ars_usd = $this->currencyConverter('USD', 'ARS');
        $loop = 0;
        $items = [];
        foreach ($cart[0]->details as $detail) {
            $items += [
                $loop =>
                [
                    'name' => $detail->product->name,
                    'description' => $detail->product->description,
                    'sku' => $detail->product->id,
                    'unit_amount' =>
                    [
                        'currency_code' => 'USD',
                        'value' => number_format((float)($detail->product->price / $ars_usd), 2, '.', ''),
                    ],
                    'tax' =>
                    [
                        'currency_code' => 'USD',
                        'value' => '0.00',
                    ],
                    'quantity' => $detail->quantity,
                    'category' => 'PHYSICAL_GOODS', //Valor por defecto y necesario en PayPal
                ],
            ];
            $loop++;
        }
        $collection = collect($items);
        return $collection->all();
    }

    public function currencyConverter($from_Currency, $to_Currency)
    {
        $from_Currency = urlencode(strtoupper($from_Currency));
        $to_Currency = urlencode(strtoupper($to_Currency));
        $url = Http::get('https://free.currencyconverterapi.com/api/v3/convert?q=' . $from_Currency . '_' . $to_Currency . '&compact=ultra&apiKey=ff95b55ee6a7ef3dd027');
        $json = json_decode($url, true);
        //dd(number_format((float)($json[$from_Currency . '_' . $to_Currency]), 2, '.', ''));
        return $json[$from_Currency . '_' . $to_Currency];        
        //return number_format((float)($json[$from_Currency . '_' . $to_Currency]), 2, '.', '');
    }

    public function updateCartPayed()
    {
        $cart = auth()->user()->cart;
        $cart->status_id = 2; //Se le cambia el estado a pendiente (2)
        $cart->order_date = Carbon::now(); //Se guarda la fecha en que fue realizada la orden de compra.
        $cart->total = $cart->total;
        $cart->payed = true;
        $cart->pay_method_id = 3; //2- Efectivo ; 3-PayPal ; 4-MercadoPago
        $cart->pay_date = Carbon::now();
        //Se realiza un UPDATE
        $cart->save();
        
        //A traves de una instancia de Mailable, enviamos un correo a todos los administradores
        $admins = User::whereIn('rol_id', [1, 2])->get();
        Mail::to($admins)->send(new NewOrder(auth()->user(), $cart)); //Le enviamos por parametros el usuario que realizo el pedido y su carro de compras
        //Le enviamos un email al usuario que realizo el pedido
        Mail::to($cart->user->email)->send(new OrderRequested(auth()->user(), $cart));
    }
}
