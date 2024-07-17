document.addEventListener('DOMContentLoaded', function () {
    var toast = document.getElementById('toast');

    if(toast){
        setTimeout(function(){
            toast.style.display = 'none';
        }, 3000);
    }else{
        console.log('No hay mensajes');
    }
});

//sidebar toggle button, cuando se toca el boton de hamburguesa se activa el sidebar y se desactiva
