const nightToggleBtn = document.querySelector('.js-btn-night');


nightToggleBtn.addEventListener('click', function(){
    const body = document.querySelector('body');
    body.classList.add("night-template");
});