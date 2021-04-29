window.onload = function() {
    document.getElementById('form-checkout').reset();
};

function setCardNumber(){
    let numSection = document.getElementById('form-checkout__cardNumber');
    let number = numSection.value;
    document.getElementById('cardNumber').innerHTML = number;    
};

function setCardNameHolder(){
    let nameSection = document.getElementById('form-checkout__cardholderName');
    let name = nameSection.value;
    document.getElementById('cardNameHolder').innerHTML = name;
};

function setCardMonthExp(){
    let mmSection = document.getElementById('form-checkout__cardExpirationMonth');
    let month = mmSection.value;
    document.getElementById('cardMonthExp').innerHTML = month;
};

function setCardYearExp(){
    let yearSection = document.getElementById('form-checkout__cardExpirationYear');
    let year = yearSection.value;
    document.getElementById('cardYearExp').innerHTML = year;
};

function setCardCvv(){
    let cvvSection = document.getElementById('form-checkout__securityCode');
    let cvv = cvvSection.value;
    document.getElementById('cardCvv').innerHTML = cvv;
};

function flipCard(){
    let card = document.getElementById('card');
    card.style.transform = "rotateY(180deg)";
};

function flipCardBack(){
    let card = document.getElementById('card');
    card.style.transform = "rotateY(360deg)";
};

function checkImg(){
    
}