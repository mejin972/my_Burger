let existing_mail = document.querySelector('.exist_mail');
/*$( document ).ready(function() {
    $('#exampleModal').modal('toggle');
});*/

existing_mail.style.display = 'none';
console.log(existing_mail.innerText);

if (existing_mail.innerText == 1) {
    $( document ).ready(function() {
        $('#exampleModal').modal('toggle');
    });
    
}

    

