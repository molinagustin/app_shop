@extends('layouts.app')

@section ('tittle', 'AlVenta | Pagar Compra')

@section ('body-class', 'profile-page sidebar-collapse')

@section ('cssFiles')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<!-- <link rel="stylesheet" href="{{ url('css\adminlte.min.css') }}"> -->
<link rel="stylesheet" href="{{ url('css\credit_card.css') }}">

<style>
    .input-label {
        padding-bottom: .5rem;
    }
</style>
@endsection

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce.jpg')}}')">

</div>

<div class="main main-raised">

    <div class="container">

        <div class="section ">
            <h2 class="title text-center">Pasarela de Pago</h2>

            <!-- <form action="{{ url('/mercadopago/process') }}" method="post" id="form-checkout">
                @csrf 

                 <input type="text" name="cardNumber" id="form-checkout__cardNumber" /> 
                 <input type="text" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" /> 
                 <input type="text" name="cardExpirationYear" id="form-checkout__cardExpirationYear" /> 
                 <input type="text" name="cardholderName" id="form-checkout__cardholderName" /> 
                 <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail" /> 
                 <input type="text" name="securityCode" id="form-checkout__securityCode" /> 
                 <select name="issuer" id="form-checkout__issuer"></select> 
                 <select name="identificationType" id="form-checkout__identificationType"></select> 
                 <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" placeholder="Sin '-' ni '.'" /> 
                 <select name="installments" id="form-checkout__installments"></select> 
                 <button type="submit" id="form-checkout__submit">Pay</button> 

                 <progress value="0" class="progress-bar">loading...</progress> 

                 <form id="cardForm">
    <label >Numero<input type="text" id="number" onkeyup="setCardNumber()"></label><br>
    <label >Nombre<input type="text" id="name" onkeyup="setCardNameHolder()"></label><br>
    <label >MM<input type="text" id="mm" onkeyup="setCardMonthExp()"></label><br>
    <label >YY<input type="text" id="yy" onkeyup="setCardYearExp()"></label><br>
    <label >CVV<input type="text" id="cvv" onkeyup="setCardCvv()" onfocus="flipCard()" onblur="flipCardBack()"></label>
  </form>
             </form> -->

            <form action="{{ url('/mercadopago/process') }}" method="post" id="form-checkout">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h3 class="text-center">Detalles de la Tarjeta</h3>
                        <div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="cardNumber">Número de la tarjeta</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control fixes" name="cardNumber" id="form-checkout__cardNumber" onkeyup="setCardNumber()" onkeypress="isNumber(event);" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off autofocus minlength="16" maxlength="20" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="cardholderName">Titular de la tarjeta</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control fixes" name="cardholderName" id="form-checkout__cardholderName" placeholder="Como figura en la tarjeta" onkeyup="setCardNameHolder()" onkeypress="isNotNumber(event);" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="">Fecha de vencimiento</label>
                                </div>
                                <div class="col-sm-3">
                                    <input style="width:45%; margin:0" type="text" class="form-control fixes" placeholder="MM" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" onkeyup="setCardMonthExp()" onblur="monthsNumbers()" onkeypress="isNumber(event);" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off minlength="2" maxlength="2" required>
                                    <span class="date-separator">/</span>
                                    <input style="width:45%; margin:0" type="text" class="form-control fixes" placeholder="YY" name="cardExpirationYear" id="form-checkout__cardExpirationYear" onkeyup="setCardYearExp()" onblur="yearsExp()" onkeypress="isNumber(event);" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off minlength="2" maxlength="2" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="securityCode">Código de seguridad</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control fixes" name="securityCode" id="form-checkout__securityCode" placeholder="CVV" onkeyup="setCardCvv()" onfocus="flipCard()" onblur="flipCardBack()" onkeypress="isNumber(event);" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off minlength="3" maxlength="3" required>
                                </div>
                            </div>
                            <div class="row" id="issuerInput">
                                <div class="col-sm-3">
                                    <label for="issuer">Banco/Tarjeta</label>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control fixes" name="issuer" id="form-checkout__issuer" style="width:100%"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="installments">Cuotas</label>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control fixes" name="installments" id="form-checkout__installments" style="width:100%"></select>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cart = \App\Cart::where('user_id', Auth()->user()->id)->where('status_id', 1)->get();
                        ?>
                        <input type="hidden" id="cartTotal" value="{{ $cart[0]->total }}">
                    </div>

                    <div class="col-md-6">
                        <h3 class="text-center">Detalles del Comprador</h3>
                        <div>
                            <div class="row">
                                <div class="col-sm-3"><label for="cardholderEmail">E-mail</label></div>
                                <div class="col-sm-3"><input type="email" class="form-control fixes" id="form-checkout__cardholderEmail" name="cardholderEmail" placeholder="nombre@correo.com" value="{{ auth()->user()->email }}" required /></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"><label for="identificationType">Tipo de documento</label></div>
                                <div class="col-sm-3"><select class="form-control fixes" name="identificationType" id="form-checkout__identificationType" style="width:100%"></select></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"><label for="identificationNumber">Número de documento</label></div>
                                <div class="col-sm-3"><input type="text" class="form-control fixes" onkeypress="isNumber(event);" name="identificationNumber" id="form-checkout__identificationNumber" placeholder="Sin '-' ni '.'" minlength="7" maxlength="8" required /></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <!--TARJETA-->
                    <div class="col-md-6" style="padding:0; height:fit-content">

                        <div class="center">
                            <div class="card" style="margin:0; box-shadow:none">
                                <div class="flip" id="card">
                                    <div class="front">
                                        <div class="strip-bottom"></div>
                                        <div class="strip-top"></div>
                                        <img class="logo" width="40" height="40" src="{{ asset('img/alventa_icon.png') }}">
                                        <!-- <svg class="logo" width="40" height="40" viewbox="0 0 17.5 16.2">
                                            <path d="M3.2 0l5.4 5.6L14.3 0l3.2 3v9L13 16.2V7.8l-4.4 4.1L4.5 8v8.2L0 12V3l3.2-3z" fill="white"></path>
                                                    </svg> -->
                                        <div class="investor">AlVenta</div>
                                        <div class="chip">
                                            <div class="chip-line"></div>
                                            <div class="chip-line"></div>
                                            <div class="chip-line"></div>
                                            <div class="chip-line"></div>
                                            <div class="chip-main"></div>
                                        </div>
                                        <svg class="wave" viewBox="0 3.71 26.959 38.787" width="26.959" height="38.787" fill="white">
                                            <path d="M19.709 3.719c.266.043.5.187.656.406 4.125 5.207 6.594 11.781 6.594 18.938 0 7.156-2.469 13.73-6.594 18.937-.195.336-.57.531-.957.492a.9946.9946 0 0 1-.851-.66c-.129-.367-.035-.777.246-1.051 3.855-4.867 6.156-11.023 6.156-17.718 0-6.696-2.301-12.852-6.156-17.719-.262-.317-.301-.762-.102-1.121.204-.36.602-.559 1.008-.504z">
                                            </path>
                                            <path d="M13.74 7.563c.231.039.442.164.594.343 3.508 4.059 5.625 9.371 5.625 15.157 0 5.785-2.113 11.097-5.625 15.156-.363.422-1 .472-1.422.109-.422-.363-.472-1-.109-1.422 3.211-3.711 5.156-8.551 5.156-13.843 0-5.293-1.949-10.133-5.156-13.844-.27-.309-.324-.75-.141-1.114.188-.367.578-.582.985-.542h.093z">
                                            </path>
                                            <path d="M7.584 11.438c.227.031.438.144.594.312 2.953 2.863 4.781 6.875 4.781 11.313 0 4.433-1.828 8.449-4.781 11.312-.398.387-1.035.383-1.422-.016-.387-.398-.383-1.035.016-1.421 2.582-2.504 4.187-5.993 4.187-9.875 0-3.883-1.605-7.372-4.187-9.875-.321-.282-.426-.739-.266-1.133.164-.395.559-.641.984-.617h.094zM1.178 15.531c.121.02.238.063.344.125 2.633 1.414 4.437 4.215 4.437 7.407 0 3.195-1.797 5.996-4.437 7.406-.492.258-1.102.07-1.36-.422-.257-.492-.07-1.102.422-1.359 2.012-1.075 3.375-3.176 3.375-5.625 0-2.446-1.371-4.551-3.375-5.625-.441-.204-.676-.692-.551-1.165.122-.468.567-.785 1.051-.742h.094z">
                                            </path>
                                        </svg>
                                        <div class="card-number">
                                            <div class="section" id="cardNumber" style="padding:0">00000000000000000000</div>
                                            <!-- <div class="section">2000</div>
                                            <div class="section">0000</div>
                                            <div class="section">0000</div> -->
                                        </div>
                                        <div class="end">
                                            <span class="end-text">fecha venc.:</span><span class="end-date" id="cardMonthExp">11</span>/<span class="end-date" id="cardYearExp">22</span>
                                        </div>
                                        <div class="card-holder" id="cardNameHolder">Lopez Gerardo Fabian</div>
                                        <img class="master" id="credit_card_logo" width="31" height="24" src="" style="display: none;">
                                        <!-- <div class="master">
                                            <div class="circle master-red"></div>
                                            <div class="circle master-yellow"></div>
                                        </div> -->
                                    </div>
                                    <div class="back">
                                        <div class="strip-black"></div>
                                        <div class="ccv">
                                            <label>ccv</label>
                                            <div id="cardCvv">123</div>
                                        </div>
                                        <div class="terms">
                                            <p>Ésta tarjeta es propiedad exclusiva de la persona que figura en ella. El uso indebido de la misma puede conllevar a penas criminales. Si usted la encuentra, por favor devolverla a la entidad correspondiente más cercana.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="text-center">
                    <!-- <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />
                    <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
                    <input type="hidden" name="description" id="description" />
                    <br> -->
                    <button type="submit" class="btn btn-primary btn-round" id="form-checkout__submit">Pagar</button>
                    <a class="btn btn-primary btn-round" href="{{ url('/mercadopago/cancelled') }}">Cancelar Pago</a>
                    <br>
                </div>

            </form>
        </div>

    </div>
</div>

@include('includes.footer')
@endsection
@section('js_scripts')
<script>
    // this prevents from typing non-number text, including "e".
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) || charCode == 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    // this prevents from typing number text.
    function isNotNumber(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            return true;
        } else {
            evt.preventDefault();
        }
    }

    function monthsNumbers(){
        let control = document.getElementById('form-checkout__cardExpirationMonth');
        let value = control.value;
        if (value > 12 || value < 1)
        {
            control.value = null;
        }
    }

    function yearsExp(){
        let control = document.getElementById('form-checkout__cardExpirationYear');
        let value = control.value;
        if (value < 21)
        {
            control.value = null;
        }
    }
</script>
<!--Libreria SDK Mercado Pago-->
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script type="text/javascript" src="{{ asset('js/mp.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
@endsection