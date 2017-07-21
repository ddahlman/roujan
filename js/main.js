$(document).ready(function () {
    document.querySelector('.collapse-btn').addEventListener('click', () => {
        let menuDrop = document.querySelector('#menu-drop');
        menuDrop.classList.toggle('responsive');
    });
});