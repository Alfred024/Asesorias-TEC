const register = document.querySelector('input[type="submit"]');
var statusCode;

register.addEventListener('click', ()=>{
    const formData = new FormData(document.querySelector('form'));
    fetch('http://localhost/asesorias_api/components/usuario/post.php', {
        method: 'POST',
        body: formData,
    })
        .then(response =>{
            statusCode = response.status;
            return response.text();
        })
        .then(data =>{
            alert("Register succesfull, now you can login");
            if (statusCode == 200){
                location.href("../login.html");
            }
        })
        .catch(error =>{
            alert(error);
        });
});