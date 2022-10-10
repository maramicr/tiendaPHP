
// alert('el enlace está funcionando');

function addProducto (codigo, token){
    let url = 'clases/carrito.php';
    let formData = new FormData();    
    formData.append('codigo', codigo);
    formData.append('token', token);

    fetch(url, {
        method:'POST',
        body:formData,
        mode:'cors'
    }).then(Response => Response.json())
    .then(data =>{
        if(data.ok){
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML=data.numero;
        }
    })
}