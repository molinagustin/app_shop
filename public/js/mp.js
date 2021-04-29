   window.onload = function () {
       //CONFIGURACIONES PARA MERCADOPAGO
       //PUBLIC KEY FRONTEND MP
       const mp = new MercadoPago('TEST-3e3146d4-dce2-425a-9244-73da497ebfb8', {
           locale: 'es-AR',
       });

       //Obtengo los tipos de Documentos
       const identificationTypes = mp.getIdentificationTypes();

       //Obtener metodo de pago de la tarjeta
       document.getElementById('form-checkout__cardNumber').addEventListener('change', guessPaymentMethod);

       function guessPaymentMethod(event) {
           let cardnumber = document.getElementById("form-checkout__cardNumber").value;
           if (cardnumber.length >= 6) {
               //Bank Identification Number
               let BIN = cardnumber.substring(0, 6);
               //Forma de pago
               const paymentMethods = mp.getPaymentMethods({
                   bin: BIN
               });           
               document.getElementById('credit_card_logo').style.display = 'inline';
               //Obtengo los bancos disponibles segun la tarjeta (No es necesario si se rellena con el numero de tarjeta)
               /*const issuers = mp.getIssuers({
                   paymentMethodId: 'master',
                   bin: BIN
               });*/
           }
           else{
            document.getElementById('credit_card_logo').style.display = 'none';
           }
       };

       const cardForm = mp.cardForm({
           amount: document.getElementById('cartTotal').value,
           autoMount: true,
           processingMode: 'aggregator',
           form: {
               id: 'form-checkout',
               cardholderName: {
                   id: 'form-checkout__cardholderName',
                //    placeholder: 'Cardholder name',
                placeholder: 'Como figura en la tarjeta',
               },
               cardholderEmail: {
                   id: 'form-checkout__cardholderEmail',
                   placeholder: 'Email',
               },
               cardNumber: {
                   id: 'form-checkout__cardNumber',
                //    placeholder: 'Card number',
                   placeholder: 'Número Tarjeta',
               },
               cardExpirationMonth: {
                   id: 'form-checkout__cardExpirationMonth',
                   placeholder: 'MM'
               },
               cardExpirationYear: {
                   id: 'form-checkout__cardExpirationYear',
                //    placeholder: 'YYYY'
                placeholder: 'YY'
               },
               securityCode: {
                   id: 'form-checkout__securityCode',
                   placeholder: 'CVV',
               },
               installments: {
                   id: 'form-checkout__installments',
                //    placeholder: 'Total installments'
                   placeholder: 'Cantidad'
               },
               identificationType: {
                   id: 'form-checkout__identificationType',
                //    placeholder: 'Document type'
                   placeholder: 'Tipo Documento'
               },
               identificationNumber: {
                   id: 'form-checkout__identificationNumber',
                //    placeholder: 'Document number'
                   placeholder: 'Sin "-" ni "."'
               },
               issuer: {
                   id: 'form-checkout__issuer',
                //    placeholder: 'Issuer'
                   placeholder: 'Entidad'
               }
           },
           callbacks: {
               onFormMounted: error => {
                   if (error) return console.warn('Form Mounted handling error: ', error)
                   console.log('Form mounted')
               },
               onFormUnmounted: error => {
                   if (error) return console.warn('Form Unmounted handling error: ', error)
                   console.log('Form unmounted')
               },
               onIdentificationTypesReceived: (error, identificationTypes) => {
                   if (error) return console.warn('identificationTypes handling error: ', error)
                   console.log('Identification types available: ', identificationTypes)
               },
               onPaymentMethodsReceived: (error, paymentMethods) => {
                   if (error) return console.warn('paymentMethods handling error: ', error)
                   console.log('Payment Methods available: ', paymentMethods)
                   document.getElementById('credit_card_logo').src = paymentMethods[0].thumbnail;
               },
               onIssuersReceived: (error, issuers) => {
                   if (error) return console.warn('issuers handling error: ', error)
                   console.log('Issuers available: ', issuers)
               },
               onInstallmentsReceived: (error, installments) => {
                   if (error) return console.warn('installments handling error: ', error)
                   console.log('Installments available: ', installments)
               },
               onCardTokenReceived: (error, token) => {
                   if (error) return console.warn('Token handling error: ', error)
                   console.log('Token available: ', token)
               },
               onSubmit: (event) => {
                   //event.preventDefault();
                   const cardData = cardForm.getCardFormData();
                   //Input Hidden Data
                   //document.getElementById('form-data').value = cardData;
                   console.log('CardForm data available: ', cardData)
                   
               },
               onFetching: (resource) => {
                   console.log('Fetching resource: ', resource)
/*
                   // Animate progress bar
                   const progressBar = document.querySelector('.progress-bar')
                   progressBar.removeAttribute('value')

                   return () => {
                       progressBar.setAttribute('value', '0')
                   }*/
               },
           }
       });



       /*
       //Obtener los tipos de documentos
       //window.Mercadopago.getIdentificationTypes();
       //Obtener metodo de pago de la tarjeta
       document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

       function guessPaymentMethod(event) {
           let cardnumber = document.getElementById("cardNumber").value;
           if (cardnumber.length >= 6) {
               let bin = cardnumber.substring(0, 6);
               window.Mercadopago.getPaymentMethod({
                   "bin": bin
               }, setPaymentMethod);
           }
       };

       function setPaymentMethod(status, response) {
           if (status == 200) {
               let paymentMethod = response[0];
               document.getElementById('paymentMethodId').value = paymentMethod.id;

               getIssuers(paymentMethod.id);
           } else {
               alert(`payment method info error: ${response}`);
           }
       }
       //Obtener banco emisor
       function getIssuers(paymentMethodId) {
           window.Mercadopago.getIssuers(
               paymentMethodId,
               setIssuers
           );
       }

       function setIssuers(status, response) {
           if (status == 200) {
               let issuerSelect = document.getElementById('issuer');
               response.forEach(issuer => {
                   let opt = document.createElement('option');
                   opt.text = issuer.name;
                   opt.value = issuer.id;
                   issuerSelect.appendChild(opt);
               });

               getInstallments(
                   document.getElementById('paymentMethodId').value,
                   document.getElementById('transactionAmount').value,
                   issuerSelect.value
               );
           } else {
               alert(`issuers method info error: ${response}`);
           }
       }
       //Obtener cantidad de cuotas segun tarjeta
       function getInstallments(paymentMethodId, transactionAmount, issuerId) {
           window.Mercadopago.getInstallments({
               "payment_method_id": paymentMethodId,
               "amount": parseFloat(transactionAmount),
               "issuer_id": parseInt(issuerId)
           }, setInstallments);
       }

       function setInstallments(status, response) {
           if (status == 200) {
               document.getElementById('installments').options.length = 0;
               response[0].payer_costs.forEach(payerCost => {
                   let opt = document.createElement('option');
                   opt.text = payerCost.recommended_message;
                   opt.value = payerCost.installments;
                   document.getElementById('installments').appendChild(opt);
               });
           } else {
               alert(`installments method info error: ${response}`);
           }
       }
       //Crear el TOKEN para enviar datos de la tarjeta
       doSubmit = false;
       document.getElementById('paymentForm').addEventListener('submit', getCardToken);

       function getCardToken(event) {
           event.preventDefault();
           if (!doSubmit) {
               let $form = document.getElementById('paymentForm');
               window.Mercadopago.createToken($form, setCardTokenAndPay);
               return false;
           }
       };

       function setCardTokenAndPay(status, response) {
           if (status == 200 || status == 201) {
               let form = document.getElementById('paymentForm');
               let card = document.createElement('input');
               card.setAttribute('name', 'token');
               card.setAttribute('type', 'hidden');
               card.setAttribute('value', response.id);
               form.appendChild(card);
               doSubmit = true;
               form.submit();
           } else {
               alert("Verify filled data!\n" + JSON.stringify(response, null, 4));
           }
       };
       //CONFIGURACIONES PARA MERCADOPAGO
       */

       // this prevents from typing non-number text, including "e".
       function isNumber(evt) {
           evt = (evt) ? evt : window.event;
           let charCode = (evt.which) ? evt.which : evt.keyCode;
           if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
               evt.preventDefault();
           } else {
               return true;
           }
       }
   };
