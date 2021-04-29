<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//SDK de Mercado Pago
use MercadoPago as MP;

use App\Cart;
use App\Mail\NewOrder;
use App\Mail\OrderRequested;
use Carbon\Carbon;
use App\User;
use Mail;

class MercadoPagoController extends Controller
{
    public function pay()
    {
        return view('mp.pay');
    }

    public function cancel()
    {
        $cancelled = 'El pago fue cancelado.';
        return redirect(route('cart'))->with(compact('cancelled'));
    }

    public function processForm(Request $request)
    {
        //Usuario Prueba COMPRADOR
        /*{
        "id": 746466388,
        "nickname": "TESTIWB1CJSR",
        "password": "qatest3164",
        "site_status": "active",
        "email": "test_user_99755748@testuser.com"  
        }*/
        //Usuario Prueba VENDEDOR
        /*{
        "id": 746488835,
        "nickname": "TETE3058889",
        "password": "qatest5326",
        "site_status": "active",
        "email": "test_user_32348533@testuser.com" 
        }*/

        //Configuro la clave privada
        MP\SDK::setAccessToken("TEST-8189562188134941-041921-a602f48a38182e9fcebbba6ff1b80468-746488835");

        //Obtengo el carro del usuario activo
        $cart = Cart::where('user_id', Auth()->user()->id)->where('status_id', '1')->get();
        $cartTotal = $cart[0]->total;
        //Configuro el pago
        $payment = new MP\Payment();
        $payment->transaction_amount = number_format((float)($cartTotal), 2, '.', '');
        $payment->token = $request->input('MPHiddenInputToken');
        $payment->description = 'Compra-en-AlVenta';
        $payment->installments = number_format((int)($request->input('installments')), 0, '', '');
        $payment->payment_method_id = $request->input('MPHiddenInputPaymentMethod');
        $payment->issuer_id = number_format((int)($request->input('issuer')), 0, '', '');

        $payer = new MP\Payer();
        //$payer->first_name = Auth()->user()->name;
        /*if (Auth()->user()->phone)
            $payer->phone = Auth()->user()->phone;
        if(Auth()->user()->address)
            $payer->address = Auth()->user()->address;*/
        $payer->email = $request->input('cardholderEmail');
        $payer->identification = array(
            "type" => $request->input('identificationType'),
            "number" => $request->input('identificationNumber')
        );
        $payment->payer = $payer;

        //Queda guardado en el payment los datos del pago
        $payment->save();
        //dd($payment);
        /*$response = array(
            'status' => $payment->status,
            'message' => $payment->status_detail,
            'id' => $payment->id
        );

        echo json_encode($response);*/


        switch ($payment->status) {
            case ('approved'):
                if ($this->updateCartPayed()) {
                    $notification = 'El pago se procesó correctamente y su pedido está siendo preparado. Lo contactaremos pronto vía email.';
                    return redirect(route('cart'))->with(compact('notification'));
                    break;
                }
                $error = 'El pago no ha podido ser procesado correctamente, intentelo nuevamente en unos minutos o con otra tarjeta.';
                return redirect(route('cart'))->with(compact('error'));
                break;
            //PARA PODER UTILIZAR CORRECTAMENTE ESTE CASO, HACE FALTA VER COMO RECIBIR LA NOTIFICACION DE QUE EL PAGO FUE ACREDITADO CORRECTAMENTE Y VOLVER A ACTUALIZAR LOS DATOS DEL CARRO, POR AHORA LO DEJO PARA TENERLO EN CONOCIMIENTO PERO NO SE VA A USAR.
            case ('in_process'):
                $cancelled = 'El pago esta en proceso para ser acreditado, nos comunicaremos con usted en cuanto se haya podido finalizar.';
                return redirect(route('cart'))->with(compact('cancelled'));
                break;
            case ('rejected'):
                switch ($payment->status_detail) {
                    case ('cc_rejected_other_reason'):
                        $error = 'El pago fue rechazado, por favor, compruebe los datos introducidos y la disponibilidad de la tarjeta.';
                        return redirect(route('cart'))->with(compact('error'));
                        break;
                    case ('cc_rejected_call_for_authorize'):
                        $error = 'El pago fue rechazado, no se pudo autorizar el uso de la tarjeta.';
                        return redirect(route('cart'))->with(compact('error'));
                        break;
                    case ('cc_rejected_insufficient_amount'):
                        $error = 'El pago fue rechazado por no contarse con suficientes fondos en la tarjeta.';
                        return redirect(route('cart'))->with(compact('error'));
                        break;
                    case ('cc_rejected_bad_filled_security_code'):
                        $error = 'El pago fue rechazado, por favor, compruebe el codigo de seguridad introducido.';
                        return redirect(route('cart'))->with(compact('error'));
                        break;
                    case ('cc_rejected_bad_filled_date'):
                        $error = 'El pago fue rechazado, por favor, compruebe la fecha de vencimiento introducida.';
                        return redirect(route('cart'))->with(compact('error'));
                        break;
                    case ('cc_rejected_bad_filled_other'):
                        $error = 'El pago fue rechazado, por favor, compruebe los datos introducidos en el formulario.';
                        return redirect(route('cart'))->with(compact('error'));
                        break;
                }
                break;
            default:
                $cancelled = 'El pago no pudo ser procesado correctamente, intentelo nuevamente más tarde o pongase en contacto con la administración.';
                return redirect(route('cart'))->with(compact('cancelled'));
        }
    }

    public function updateCartPayed()
    {
        $cart = auth()->user()->cart;
        $cart->status_id = 2; //Se le cambia el estado a pendiente (2)
        $cart->order_date = Carbon::now(); //Se guarda la fecha en que fue realizada la orden de compra.
        $cart->total = $cart->total;
        $cart->payed = true;
        $cart->pay_method_id = 4; //2- Efectivo ; 3-PayPal ; 4-MercadoPago
        $cart->pay_date = Carbon::now();
        //Se realiza un UPDATE
        $saved = $cart->save();

        //A traves de una instancia de Mailable, enviamos un correo a todos los administradores
        $admins = User::whereIn('rol_id', [1, 2])->get();
        Mail::to($admins)->send(new NewOrder(auth()->user(), $cart)); //Le enviamos por parametros el usuario que realizo el pedido y su carro de compras
        //Le enviamos un email al usuario que realizo el pedido
        Mail::to($cart->user->email)->send(new OrderRequested(auth()->user(), $cart));

        return $saved;
    }
}
