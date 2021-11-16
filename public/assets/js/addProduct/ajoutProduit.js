let button_minus = document.querySelector(".btn.btn-outline-secondary.minus-btn");
console.log(button_minus);

let button_add = document.querySelector(".btn.btn-outline-secondary.add-btn");
console.log(button_add);

let input_quantity = document.querySelector(".form-control.input-manulator");
console.log(input_quantity);
let errorMessage;

let Ajout_panier = document.querySelector(".btn.btn-info");
console.log(Ajout_panier.href);


button_add.addEventListener(
    "click",
    function(){
        increase_quantity();
    }
)
button_minus.addEventListener(
    "click",
    function(){
        decrease_quantity();
    }

)

function increase_quantity(){
    if (input_quantity.value <10) {
        input_quantity.value++;
    }
    if (input_quantity.value == 10) {
        errorMessage = "La quantité maximal de produit a été atteinte vous ne pouvez plus ajouter se produit";
        console.log(errorMessage);
    }

    Ajout_panier.href = "";
    console.log(Ajout_panier.href);
}

function decrease_quantity(){
    if (input_quantity.value >= 1) {
        input_quantity.value--;
    }
    if (input_quantity.value == 0) {
        errorMessage = "Se produit n'est plus présent dans votre panier";
        console.log(errorMessage);
    }
    
}

