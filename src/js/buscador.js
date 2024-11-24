document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();    
})

function iniciarApp(){
    const fechaElement = document.querySelector('#fecha');
    fechaElement.addEventListener('input', function (e) {
        const fechaSelec = e.target.value;
        window.location = '?fecha='+fechaSelec;
    });
}