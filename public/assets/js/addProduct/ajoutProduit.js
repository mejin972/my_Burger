let button_minus = document.querySelectorAll(".btn.btn-outline-secondary.minus-btn");

let button_add = document.querySelectorAll(".btn.btn-outline-secondary.add-btn");

let input_quantity = document.querySelectorAll(".form-control.input-manulator");

let errorMessage;

let Ajout_panier = document.querySelectorAll(".btn.btn-info");

let a = document.querySelectorAll("span.a");

let b = document.querySelectorAll("span.b");


button_add.forEach(function(item, index){
    item.addEventListener(
        "click",
        function(e){
            var target = e.target;
            increase_quantity(index);
        }
    )
});

button_minus.forEach(function(item , index) {
    item.addEventListener(
        "click",
        function(e){
            var target = e.target;
            decrease_quantity(index);
        }
    )
});


function increase_quantity(index){
    if (input_quantity[index].value <10) {
        input_quantity[index].value++;
    }
    if (input_quantity[index].value == 10) {
        errorMessage = "La quantité maximal de produit a été atteinte vous ne pouvez plus ajouter se produit";
        console.log(errorMessage);
    }
    console.log(input_quantity[index].value);
    b[index].innerText = input_quantity[index].value;

    Ajout_panier[index].href = "http://127.0.0.1:8000/cart/" +a[index].innerText+"/"+b[index].innerText;
    console.log(Ajout_panier[index].href);
}

function decrease_quantity(index){
    if (input_quantity[index].value >= 1) {
        input_quantity[index].value--;
    }
    if (input_quantity[index].value == 0) {
        errorMessage = "Se produit n'est plus présent dans votre panier";
        console.log(errorMessage);
    }
    console.log(input_quantity[index].value);
    b[index].innerText = input_quantity[index].value;

    Ajout_panier[index].href = "http://127.0.0.1:8000/cart/" +a[index].innerText+"/"+b[index].innerText;
    console.log(Ajout_panier.href);
    
}

