// Mobile version menu/navigation
(function() {
    var menu = document.querySelector('ul'),
        menulink = document.querySelector('#menu-icon');

    menulink.addEventListener('click', function(e) {
        menu.classList.toggle('active');
        e.preventDefault();
    });
})();