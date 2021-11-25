let bouttonFav1 = document.querySelectorAll("div.img_card a i.far.fa-heart");

let bouttonFav2 = document.querySelectorAll("div.img_card a i.fas.fa-heart");

var isFav = document.querySelectorAll("div.none span.c");
console.log(isFav);

isFav.forEach(function(item,index) {
    
    if (item.innerText == 1) {
        console.log(item.innerText);
        bouttonFav1[index].style.display = 'none';
        bouttonFav2[index].style.display = 'block';
    }
});




bouttonFav1.forEach(function(item, index) {

    item.addEventListener('mouseover', function(e){
        if (isFav[index].innerText == 1) {
            console.log(isFav[index].innerText);
            bouttonFav1[index].style.display = 'none';
            bouttonFav2[index].style.display = 'block';
        }else{
            onMouseHandler(item,index);
        }
       
    })
});


bouttonFav2.forEach(function(item, index) {

    item.addEventListener('mouseout', function(e){
        if (isFav[index].innerText == 1) {
            console.log(isFav[index].innerText);
            bouttonFav1[index].style.display = 'none';
            bouttonFav2[index].style.display = 'block';
        }else{
            onMouseOutHandler(item,index);
        }
    })
});



function onMouseHandler(item,index) {
    
    item.style.display = 'none';

    bouttonFav2[index].style.display = 'block'
    
}

function onMouseOutHandler(item, index) {

    item.style.display = 'none';
    
    bouttonFav1[index].style.display = 'block';
}