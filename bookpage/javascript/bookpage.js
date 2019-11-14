function switchRating() {

    var rating = document.getElementById("rating");
    var button = document.getElementById("ratingButton");
    button.innerText = rating.style.display;
    if (rating.style.display == "none" || rating.style.display == "" || rating.style.display == null) {
        rating.style.display = "block";
        button.innerText = "Dölj betyg";
    } else if (rating.style.display == "block") {
        rating.style.display = "none";
        button.innerText = "Visa betyg";
    }
}

// Mobile version menu/navigation
(function() {
    var menu = document.querySelector('ul'),
        menulink = document.querySelector('#menu-icon');

    menulink.addEventListener('click', function(e) {
        menu.classList.toggle('active');
        e.preventDefault();
    });
})();

// Tab container (Beskrivning, specifik information)
var tabButtons = document.querySelectorAll(".tab-container .tabButton-container button");
var tabPanels = document.querySelectorAll(".tab-container .tabPanel");

function showTabPanel(panelIndex, colorCode) {
    tabButtons.forEach(function(btn) {
        btn.style.backgroundColor = "";
        btn.style.color = "";
        btn.style.textDecoration = "none";
    });
    tabButtons[panelIndex].style.backgroundColor = colorCode;
    tabButtons[panelIndex].style.color = "white";

    tabPanels.forEach(function(tab) {
        tab.style.display = "none";
    });
    tabPanels[panelIndex].style.display = "block";
    tabPanels[panelIndex].style.backgroundColor = "white";
}
showTabPanel(0, 'rgb(43, 161, 140)');

// Read more (book description)
function readMore() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("btnReadMore");
    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Läs mer";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Läs mindre";
        moreText.style.display = "inline";
    }
}

//  for add to list buttons
function setActionInAddForm(bookId, listToAddBook) {
    window.alert(bookId);
    window.alert(listToAddBook);
    document.getElementById("form-addToList").setAttribute("action", "../includes/bookHandler.inc.php?type=" + listToAddBook + "&bookId=" + bookId);
    document.getElementById("form-addToList").submit();
}

function showContainerWithAddButtons() {
    var container = document.getElementById("container-addButtons");
    if (container.style.display === "none") {
        container.style.display = "block";
    } else {
        container.style.display = "none";
    }
}
showContainerWithAddButtons();