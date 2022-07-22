//création de sélecteur
const nightToggleBtn = document.querySelector('.js-btn-night');
const body = document.querySelector('body');

// vérification si le night mode est activé en arrivant sur une page
if (localStorage.getItem('isNightMode') === 'true') {
    body.classList.add('night-template');
    nightToggleBtn.innerText = "light Mode";
}

// Listener sur le bouton NightMode et vérification si le NightMode est activé ou non
nightToggleBtn.addEventListener('click', function(){
    // Ajout de la class "night-template" au 'body' de la page html
    body.classList.toggle("night-template");
    // Stockage dans le localStorage
    localStorage.setItem('isNightMode', true);
    if(body.className != "night-template" || localStorage.getItem('isNightMode') === 'false'){
        nightToggleBtn.innerText = "Night Mode";
        localStorage.setItem('isNightMode', false);
    } else if(body.className == "night-template" || localStorage.getItem('isNightMode') === 'true') {
        nightToggleBtn.innerText = "Day Mode";
    }
});