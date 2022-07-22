//création de sélecteur
const nightToggleBtn = document.querySelectorAll('.js-btn-night');
const body = document.querySelector('body');
const icon = document.querySelector('.icons');
const menu = document.querySelector('.menu-mobile');


//vérification si le night mode est activé en arrivant sur une page
if (localStorage.getItem('isNightMode') === 'true') {
    body.classList.add('night-template');
    nightToggleBtn.forEach(function(btn){
        btn.innerText = 'Day Mode';
    });
}


nightToggleBtn.forEach(function (btn){
    btn.addEventListener('click', function() {
        // Ajout de la class "night-template" au 'body' de la page html
        body.classList.toggle("night-template");
        // Stockage dans le localStorage
        localStorage.setItem('isNightMode', true);
        if (body.className != "night-template" || localStorage.getItem('isNightMode') === 'false') {
            btn.innerText = "Night Mode";
            localStorage.setItem('isNightMode', false);
        } else if (body.className == "night-template" || localStorage.getItem('isNightMode') === 'true') {
            btn.innerText = "Day Mode";
        }
    })
});




icon.addEventListener('click', function(){
    console.log('test');
    menu.classList.toggle('d-b');
});