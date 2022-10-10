// alert('el enlace está funcionando');

function confirmacion(e) {
    if (confirm("¿Desea eliminar el registro indicado?")){
        return true;
    }else{
        e.preventDefault();
    }
}
let linkDelete = document.querySelectorAll(".table__item--link--del");
for (var i = 0; i < linkDelete.length; i++){
    linkDelete[i].addEventListener('click', confirmacion);
}