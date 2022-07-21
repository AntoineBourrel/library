const nightToggleBtn = document.querySelector('.js-btn-night');
const body = document.querySelector('body');

if (localStorage.getItem('isNightMode') === 'true') {
    body.classList.add('night-template');
}

nightToggleBtn.addEventListener('click', function(){
    body.classList.toggle("night-template");
    if(body.className != "night-template" || localStorage.getItem('isNightMode') === 'false'){
        nightToggleBtn.innerText = "Night Mode";
        localStorage.setItem('isNightMode', false);
    } else if(body.className == "night-template" || localStorage.getItem('isNightMode') === 'true') {
        nightToggleBtn.innerText = "light Mode";
        localStorage.setItem('isNightMode', true);
    }
});