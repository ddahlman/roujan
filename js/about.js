$(document).ready(function () {
    let modal = document.querySelector('#a-modal');
    let sorce = './img/gallery/lyktapool-test-2.jpg';
    let gallery = document.querySelector('#gallery');
    [...document.querySelectorAll('.the-house')].map((btn) => btn.addEventListener('click', () => {
        modal.style.display = 'block';
        gallery.src = sorce;
        /* modal.innerHTML = `<img src='${src}' class='img-responsive img-rounded gallery' alt='roujan-gallery'>`; */
        return btn;
    }));

    gallery.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    modal.addEventListener('click', () => {
        modal.style.display = 'none';
    });
});