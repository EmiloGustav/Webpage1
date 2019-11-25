function loadSearchResult(listOfIDs) {
    // AJAX request database for information about every book by ID

    for (i = 0; i < listOfIDs.length; i++) {
        var li = document.createElement('LI');
        li.setAttribute('class', 'container-searchItem');
        var aImage = document.createElement('A');
        aImage.setAttribute('href', '?');
        var img = document.createElement('IMG');
        img.setAttribute('src', '?');
        var div = document.createElement('DIV');
        div.setAttribute('class', 'searchItem-info');
        var aTitle = document.createElement('A');
        aTitle.setAttribute('href', '?');
        var h3Title = document.createElement('H3');
        var pAuthor = document.createElement('P');
        pAuthor.innerText = 'Skriven av ';
        var aAuthor = document.createElement('A');
        var pSpecificInfo = document.createElement('P');
        pSpecificInfo.innerText = ' , , ISBN: ';

        li.appendChild(aImage);
        aImage.appendChild(img);
        li.appendChild(div);
        div.appendChild(aTitle);
        aTitle.appendChild(h3Title);
        div.appendChild(pAuthor);
        pAuthor.appendChild(aAuthor);
        div.appendChild(pSpecificInfo);
        document.getElementById('container-searches').appendChild(li);
    }
}

window.onload = function() {
    this.loadSearchResult();
}