// alert('el enlace está funcionando');

function actualizaCantidad (cantidad,id){
    let url = 'clases/act_carrito.php';
    let formData = new FormData();
    formData.append('action', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad);

    fetch(url, {
        method:'POST',
        body:formData,
        mode:'cors'
    }).then(Response => Response.json())
    .then(data =>{
        if(data.ok){
            let divsubtotal = document.getElementById('subtotal_' + id)
            divsubtotal.innerHTML = data.sub
        }
    })
}