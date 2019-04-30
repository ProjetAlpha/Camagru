var mario = document.getElementById("mario-img");
var pomme = document.getElementById("pomme-img");

var startX, startY;

var mouseX, mouseY;

var is_active = false, isDown = false;

var coords = {x:0, y:0};

function startImg(event, node){
    if (currentNode.id !== undefined && currentNode.id !== node.id)
        return;
    if (isDown == false)
    {
        startX = event.clientX;
        startY = event.clientY;
    }
    currentNode = node;
    is_active = true;
}

window.onmousemove = function (e){
    mouseX = e.clientX;
    mouseY = e.clientY;

    e.preventDefault();
    e.stopPropagation();
    var dx = mouseX - startX;
    var dy = mouseY - startY;

    if (is_active){
        currentNode.style.transform = 'translate('+dx+'px'+','+dy+'px'+')';
    }
};

window.onmouseup = function (event){
    mouseX = event.clientX;
    mouseY = event.clientY;

    var dx = mouseX - startX;
    var dy = mouseY - startY;

    event.preventDefault();
    event.stopPropagation();
    // on est bien dans le cadre de la video ? si ok, on lache le bail et on envoi les images a superposer au cote serveeur (pos des 2 images stp).
    // si l'image est bien dans le rect.
    var divRect = document.getElementById("video").getBoundingClientRect();
    if (mouseX >= divRect.left && mouseX <= divRect.right &&
      mouseY >= divRect.top && mouseY <= divRect.bottom){
        var startbutton = document.querySelector('#startbutton');
        var video = document.querySelector('#video').getBoundingClientRect();
        var x = document.getElementById(currentNode.id).getBoundingClientRect().left;
        var y = document.getElementById(currentNode.id).getBoundingClientRect().top;

        posX = x - video.left;
        posY = y - video.top;
        startbutton.disabled = false;
        currentNode.style.transform = 'translate('+dx+'px'+','+dy+'px'+')';
    }
    is_active = false;
    isDown = true;
};
