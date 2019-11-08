(function() {
    var menu = document.querySelector('ul'),
        menulink = document.querySelector('#menu-icon');

    menulink.addEventListener('click', function(e) {
        menu.classList.toggle('active');
        e.preventDefault();
    });
})();

function toggleEdit() {
    var elements = document.getElementsByClassName("edit-list");

    if(elements[0].getAttribute("style") == null) {
        for(var i=0;i<elements.length;i++) {
            elements[i].style="display:inline-block";
        }
    }else if(elements[0].style.display === "none") {
        for(var i=0;i<elements.length;i++) {
            elements[i].style="display:inline-block";
        }
    }else {
        for(var i=0;i<elements.length;i++) {
            elements[i].style="display:none";
        }
    }

}
