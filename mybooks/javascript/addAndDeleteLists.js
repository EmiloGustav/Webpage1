var span = document.getElementById('modalSpan');
var modal = document.getElementById('myModal');
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    document.getElementsByClassName("h6")[0].remove();
    document.getElementsByClassName("btnNo")[0].remove();
    document.getElementsByClassName("btnYes")[0].remove();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.getElementsByClassName("h6")[0].remove();
        document.getElementsByClassName("btnNo")[0].remove();
        document.getElementsByClassName("btnYes")[0].remove();
    }
}

function deleteList(listName) {
    var modal = document.getElementById('myModal');
    modal.style.display='block';
    var mc = document.getElementById('modalContent');
    var h6 = document.createElement('H6');
    h6.innerText = 'Är du säker på att du vill ta bort listan '+listName+' och alla böcker i den?';
    h6.setAttribute('class','h6');
    var btnYes = document.createElement('A');
    btnYes.innerText = "Ja";
    btnYes.setAttribute('href','../includes/listsHandler.inc.php?type=removeList&listName='+listName);
    btnYes.setAttribute('class','btnYes');
    var btnNo = document.createElement('BUTTON');
    btnNo.innerText = "Nej";
    btnNo.setAttribute('class','btnNo');
    btnNo.setAttribute('onClick','document.getElementById("myModal").style.display="none";document.getElementsByClassName("h6")[0].remove();document.getElementsByClassName("btnNo")[0].remove();document.getElementsByClassName("btnYes")[0].remove();');
    mc.appendChild(h6);
    mc.appendChild(btnYes);
    mc.appendChild(btnNo);

}
function addList() {
    document.getElementById('createList').remove();
    var li = document.createElement('LI');
    li.setAttribute('id', 'jsNew');
    var form = document.createElement('FORM');
    form.setAttribute('action', '../includes/listsHandler.inc.php?type=addList');
    form.setAttribute('method', 'POST');
    form.setAttribute('id', 'formNew')
    var input = document.createElement('INPUT');
    input.setAttribute('type', 'text')
    input.setAttribute('placeholder', 'Listans namn...')
    input.setAttribute('name', 'listName')
    var button = document.createElement('BUTTON');

    button.innerHTML = 'Skapa';
    button.setAttribute('type', 'submit');

    document.getElementById('liCreateList').parentNode.insertBefore(li, document.getElementById('liCreateList'));
    document.getElementById('jsNew').appendChild(form);
    document.getElementById('formNew').appendChild(input);
    document.getElementById('formNew').appendChild(button);
}
