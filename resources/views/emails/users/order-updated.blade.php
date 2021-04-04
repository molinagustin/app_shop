@component('emails.components.orderUpdatedMessage')

Hola <b>{{ $cart->user->name }}</b>, ¿cómo estas?<br>
Te contamos que tu pedido <b>#{{ $cart->id }}</b> se encuenta @switch($cart->status->status)
@case('Pendiente')
<b style="text-transform: uppercase;color:#e6b11a;">{{ $cart->status->status }}</b>
@break

@case('Aprobado')
<b style="text-transform: uppercase;color:#00c700;">{{ $cart->status->status }}</b>
@break

@case('Cancelado')
<b style="text-transform: uppercase;color:red;">{{ $cart->status->status }}</b>
@break

@case('Finalizado')
<b style="text-transform: uppercase;color:#007ec7;">{{ $cart->status->status }}</b>
@break
@endswitch>

@if($cart->status->status == 'Finished')
El mismo fue entregado correctamente en la dirección: <b>{{ $cart->user->address }}</b>.<br>
El día: <b>{{ \Carbon\Carbon::parse($cart->arrived_date)->format('d/m/Y H:i:s') }}</b><br>
@elseif($cart->status->status == 'Approved')
Pronto te estaremos visitando en: <b>{{ $cart->user->address }}</b><br>
Si deseas conocer más detalles del mismo, puedes hacerlo a través del siguiente boton:
@else
Si deseas conocer más detalles del mismo, puedes hacerlo a través del siguiente boton:
@endif

@component('mail::button', ['url' => config('app.url') . '/order/' . $cart->id])
Ver Pedido
@endcomponent

@if($cart->status->status == 'Finished')
Si por alguna razón, ninguno de esos datos es correcto, por favor ponte en [contacto][link] con nosotros lo antes posible.
@endif

[link]: {{ url(config('app.url') . '/contact') }}
Gracias por confiar en **{{ config('app.name') }}**.
@endcomponent