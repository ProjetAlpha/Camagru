var startX, startY;

var mouseX, mouseY;

var is_active = false;

var coords = {x:0, y:0};


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
        // qd on change d'image, restart le bail.
        function startImg(event, node){

            if (currentNode.id !== undefined)
            {
                var filterParent = document.querySelector('#card-filter').getBoundingClientRect();
                var x = document.getElementById(currentNode.id).getBoundingClientRect().left;
                var y = document.getElementById(currentNode.id).getBoundingClientRect().top;

                var isInRect = isObjectinRect(filterParent, x, y, document.getElementById(currentNode.id).getBoundingClientRect().right,
                document.getElementById(currentNode.id).getBoundingClientRect().bottom);
                if (isInRect){
                        currentNode = node;
                        startX = event.clientX;
                        startY = event.clientY;
                    }
                }
                //if (currentNode.id !== node.id)

                // si
                if (currentNode.id !== undefined && currentNode.id !== node.id)
                    return;
                if (isDown == false)
                {
                    console.log('yes change node');
                    //console.log(isImgChanged);
                    // si on change d'image... remet le currentNode dans le cadre. cadre.getBoundingrect().x cadre.getBoundingrect().y;
                    startX = event.clientX;
                    startY = event.clientY;
                    //isImgChanged = false;
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
                if (!document.getElementById(currentNode.id))
                    return ;

                mouseX = event.clientX;
                mouseY = event.clientY;

                var dx = mouseX - startX;
                var dy = mouseY - startY;

                event.preventDefault();
                event.stopPropagation();

                var x = document.getElementById(currentNode.id).getBoundingClientRect().left;
                var y = document.getElementById(currentNode.id).getBoundingClientRect().top;

                var imgRect = document.getElementById('img-display'), divRect;
                if (imgRect.style.display == 'block'){
                    divRect = imgRect.getBoundingClientRect();
                    console.log('yes');
                }else {
                    divRect = document.getElementById("video").getBoundingClientRect();
                }
                var isInRect = isObjectinRect(divRect, x, y, document.getElementById(currentNode.id).getBoundingClientRect().right,
                document.getElementById(currentNode.id).getBoundingClientRect().bottom);
                var startbutton = document.querySelector('#startbutton');
                if (isInRect && mouseX >= divRect.left && mouseX <= divRect.right
                    && mouseY >= divRect.top && mouseY <= divRect.bottom){
                        posX = x - divRect.left;
                        posY = y - divRect.top;
                        startbutton.disabled = false;
                        currentNode.style.transform = 'translate('+dx+'px'+','+dy+'px'+')';
                        isReadyPicture = true;
                    }
                    if (!isInRect)
                        startbutton.disabled = true;
                        is_active = false;
                        isDown = true;
                    };
