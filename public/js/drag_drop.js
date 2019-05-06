var mario = document.getElementById("mario-img");
var pomme = document.getElementById("pomme-img");

var startX, startY;

var mouseX, mouseY;

var is_active = false;

var coords = {x:0, y:0};

var currentNode = {};

function isObjectinRect(rect, a, b, c, d)
{

    if (!(a >= rect.left && a <= rect.right &&
        b >= rect.top && b <= rect.bottom))
        return (false);
        if (!(c >= rect.left && c <= rect.right &&
            d >= rect.top && d <= rect.bottom))
            return (false);
            return true;
        }


        // si le currentNode revient dans la box du parent, alors possibilite de changer de node.
        // il y a un seul qui bouger en dehors de la box.
        function startImg(event, node){

            if (currentNode.id !== undefined)
            {
                var filterParent = document.querySelector('#card-filter').getBoundingClientRect();
                var x = document.getElementById(currentNode.id).getBoundingClientRect().left;
                var y = document.getElementById(currentNode.id).getBoundingClientRect().top;

                if (x >= filterParent.left && x <= filterParent.right &&
                    y >= filterParent.top && y <= filterParent.bottom){
                        currentNode = node;
                    }
                }
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
                var x = document.getElementById(currentNode.id).getBoundingClientRect().left;
                var y = document.getElementById(currentNode.id).getBoundingClientRect().top;
                var divRect = document.getElementById("video").getBoundingClientRect();

                var isInRect = isObjectinRect(divRect, x, y, document.getElementById(currentNode.id).getBoundingClientRect().right,
                document.getElementById(currentNode.id).getBoundingClientRect().bottom);
                if (isInRect && mouseX >= divRect.left && mouseX <= divRect.right
                    && mouseY >= divRect.top && mouseY <= divRect.bottom){
                        var startbutton = document.querySelector('#startbutton');
                        var video = document.querySelector('#video').getBoundingClientRect();

                        posX = x - video.left;
                        posY = y - video.top;
                        startbutton.disabled = false;
                        currentNode.style.transform = 'translate('+dx+'px'+','+dy+'px'+')';
                        isReadyPicture = true;
                    }
                    if (!isInRect)
                        isReadyPicture = false;
                        is_active = false;
                        isDown = true;
                    };
