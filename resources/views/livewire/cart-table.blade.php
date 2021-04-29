<div>
    <hr>
    <p>Tienes <b>{{ auth()->user()->cart->details->count() }}</b> {{ (auth()->user()->cart->details->count() != 1) ? 'productos' : 'producto'}} en tu carro de compras.</p>
    <table class="table">
        <thead>

            <tr>
                <th class="text-center">Imagen</th>
                <th class="col-auto text-center">Nombre</th>
                <th class="text-right">Precio</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Sub Total</th>
                <th class="text-center">Opciones</th>
            </tr>

        </thead>

        <tbody>
            @foreach(auth()->user()->cart->details as $detail)
            <tr>
                <td class="text-center">
                    <img src="{{$detail->product->featured_image_url}}" width="50" height="50">
                </td>

                <td class="text-center">
                    <a href="{{ url('/products/'. $detail->product->id) }}" target="_blank">{{$detail->product->name}}</a>
                </td>

                <td class="text-right">&dollar; <span id="{{ 'price_id' . $detail->product->id}}">{{$detail->product->price}}</span></td>

                <td class="text-center"><input class="form-control" type="number" min="1" max="100" step="1" value="{{ $detail->quantity }}" name="quantity" id="{{ 'quantity_id' . $detail->product->id}}" style="width: 5em;display:inline-block;text-align:center;" onchange="calcular(this.value, '{{$detail->product->id}}');" oninput="validity.valid||(value='1');" onpress="isNumber(event);" required readonly>
                    <button wire:click="addCartDetail('{{$detail->id}}')" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                        <i class="material-icons">add</i>
                    </button>
                    <button wire:click="removeCartDetail('{{$detail->id}}')" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                        <i class="material-icons">remove</i>
                    </button>
                </td>

                <td class="text-center">&dollar; <span id="{{ 'sub_total' . $detail->product->id}}">{{ $detail->quantity * $detail->product->price }}</span></td>

                <td class="td-actions text-center">

                    <form method="post" action="{{ url('/cart') }}">
                        @csrf
                        @method('DELETE')
                        <!--<input type="hidden" name="_method" value="DELETE">
                    el @method('DELETE') es equivalente al INPUT HIDDEN-->

                        <input type="hidden" name="cart_detail_id" value="{{ $detail->id }}">

                        <a href="{{ url('/products/'. $detail->product->id) }}" target="_blank" rel="tooltip" data-placement="right" title="Ver Detalles" class="btn btn-info btn-simple btn-xs">
                            <i class="fa fa-info-circle"></i>
                        </a>

                        <button type="submit" rel="tooltip" data-placement="right" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                            <i class="fa fa-times"></i>
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(auth()->user()->cart->total > 0)
    <p><b>Importe total a pagar: </b> $ <span id="total_id">{{ auth()->user()->cart->total }}</span></p>

    <div class="text-center">
        <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#modalOrder">
            <i class="material-icons">local_shipping</i> Realizar Pedido
        </button>
        @if(auth()->user()->address)
        <a class="btn btn-primary btn-round" href="{{ url('/paypal/pay') }}">Pagar con PayPal <img src="{{ asset('img/paypal_icon.svg') }}" height="17" width="17"></a>
        <a  href="{{ url('/mercadopago/pay') }}"><img src="{{ asset('img/mp_icon.png') }}" height="40"></a>
        @endif
    </div>
    @endif
</div>