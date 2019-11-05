function switchRating() {

    var rating = document.getElementById("rating");
    var button = document.getElementById("ratingButton");
    button.innerText=rating.style.display;
    if(rating.style.display == "none"||rating.style.display == ""||rating.style.display == null ){
        rating.style.display = "block";
        button.innerText = "Dölj betyg";
    }else if(rating.style.display == "block") {
        rating.style.display ="none";
        button.innerText = "Visa betyg";
    }
}