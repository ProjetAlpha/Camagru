function isLiked(node)
{
    xhr.open('POST', '/isliked/'+node.id);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('user='+currentUser);
}

function addLike(node)
{
    if (parseInt(islooged) == 0)
        return ;
    if (node.children[0].className.split(' ')[0] == 'fas')
    {
        node.children[0].className = 'far fa-thumbs-up icon-responsive';
        var htmlVal = !isNaN(parseInt(node.innerHTML)) ? parseInt(node.innerHTML) : 0;
        node.children[0].innerHTML = '<br />('+(htmlVal > 0 ? htmlVal - 1 : 0).toString()+')';
        var xhr = new XMLHttpRequest();
        var id = node.id;
        xhr.open('POST', '/likes/delete/'+node.id);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(null);
        return ;
    }
    node.children[0].className = 'fas fa-thumbs-up icon-responsive';
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/likes/add/'+node.id);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(null);
    var htmlVal = !isNaN(parseInt(node.innerHTML)) ? parseInt(node.innerHTML) : 0;
    node.children[0].innerHTML = '<br />('+(htmlVal + 1).toString()+')';
}

function createTextarea(dst, link)
{
    var  col = document.createElement('div');
    var  field = document.createElement('div');
    var  control = document.createElement('div');
    var textarea = document.createElement('textarea');
    var btn = document.createElement('button');

    col.className = 'columns is-centered is-mobile';
    col.id = link.id;
    field.className = 'field';
    field.style.width = '60%';
    control.className = 'control';
    textarea.className = 'textarea is-medium is-primary mr-t';
    textarea.onkeypress= 'handleEnter(this)';
    textarea.id = link.id;

    btn.className = 'button is-primary is-medium is-small-mobile mr-t';
    btn.required = true;
    btn.id = link.id;
    btn.onclick='addCommentary(this)';
    btn.setAttribute('onclick', 'addCommentary(this)');
    btn.innerHTML = 'Ajouter un commentaire';

    control.appendChild(textarea);
    field.appendChild(control);
    col.appendChild(field);

    dst.appendChild(col);
    dst.appendChild(btn);
}

function createImg(link)
{
    var parent = link.parentElement.parentElement.children[2].children[1].children[1];
    var srcImg = link.parentElement.parentElement.parentElement.parentElement.children[0].children[0].children[0];
    var container = document.createElement('div'),
    cardImg =  document.createElement('div'),
    figure = document.createElement('figure'),
    img = document.createElement('img');

    cardImg.className = 'card-image';
    figure.className = 'image mr-b';
    img.src = srcImg.src;
    img.style.padding = '1%';
    img.style.width = '100%';
    img.style.height = 'auto';
    container.className = 'columns is-centered is-mobile';

    figure.appendChild(img);
    cardImg.appendChild(figure);

    container.appendChild(cardImg);
    parent.appendChild(container);
}


function createComment(user, txt, dst, before = null)
{
    var cardCol = document.createElement('div'),
    articleCard = document.createElement('div'),
    cardContent = document.createElement('div'),
    cardContentTxt = document.createElement('div');

    cardCol.className = 'columns is-centered is-mobile';
    cardCol.style.text = 'text-align:none!important;';
    articleCard.className = 'card has';
    articleCard.style.width = '80%';
    articleCard.style.margin = '2%';
    articleCard.style.textAlign = 'left';
    cardContent.className = 'card-content txt-responsive';
    cardContentTxt.className = 'content';
    cardContentTxt.innerHTML = '<strong>'+user+'</strong><br />';
    cardContentTxt.innerHTML += txt;

    cardContent.appendChild(cardContentTxt);
    articleCard.appendChild(cardContent);
    cardCol.appendChild(articleCard);
    dst.style.background = '#E7ECEF';
    if (before !== null)
        dst.insertBefore(cardCol, before);
    else {
        dst.appendChild(cardCol);
    }
}


function getAllComments(comments, link)
{
    var parent = link.parentElement.parentElement.children[2].children[1].children[1];
    for(i = 0; i < comments.length; i++)
    {
        createComment(comments[i].user_name, comments[i].comment, parent);
    }
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

var current_node = {};

function hideModal(node)
{
    let parent = node.parentElement;
    parent.classList.remove('is-active');
    var modalBody = parent.children[1].children[1];
    while (modalBody.firstChild) {
        modalBody.removeChild(modalBody.firstChild);
    }
    document.getElementsByTagName("html")[0].style.overflowY = 'auto';
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    // clic en dehors de la window -- getBoundingrect -> si clic en dehors => isEscape.
    var isEscape = false;
    if ("key" in evt) {
        isEscape = (evt.key === "Escape" || evt.key === "Esc");
    } else {
        isEscape = (evt.keyCode === 27);
    }
    if (isEscape) {
        current_node.classList.remove('is-active');
    }
};

function getComments(link)
{
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/comments/'+link.id);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(null);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (IsJsonString(xhr.responseText))
                var data = JSON.parse(xhr.responseText);
            if (Array.isArray(data) && data.length > 0)
            {
                document.getElementsByTagName("html")[0].style.overflowY = 'hidden';
                var parent = link.parentElement.parentElement.children[2];
                parent.classList.add('is-active');
                current_node = parent;
                createImg(link);
                getAllComments(data, link);
                var dstBody = link.parentElement.parentElement.children[2].children[1].children[1];
                if (parseInt(islooged) !== 0)
                {
                    createTextarea(dstBody, link);
                }
            }else {
                var parent = link.parentElement.parentElement.children[2];
                //console.log(link.parentElement.parentElement.children[2]);
                parent.classList.add('is-active');
                current_node = parent;
                createImg(link);
                var dstBody = link.parentElement.parentElement.children[2].children[1].children[1];
                if (parseInt(islooged) !== 0)
                {
                    createTextarea(dstBody, link);
                }
            }
        }
    }
}

var regex = /(\d)+(#[A-Za-z-0-9_-]+)?/;
var matchGoTo = window.location.href.split('/').pop().match(regex);
if (Array.isArray(matchGoTo) && matchGoTo.length > 0)
{
    if (matchGoTo[0].includes('#'))
    {
        var id = matchGoTo[0].split('#').pop();
        var btns = document.getElementsByClassName("card-footer-item");
        var modal = document.getElementById('modal-body');
        for (i = 0; i < btns.length; i++)
        {
            if (btns[i].getAttribute('id') == id)
            {
                btns[i].click();
                modal.scrollTop = modal.scrollHeight;
            }
        }
    }
}


function addCommentary(btn)
{
    if (islooged == 0)
        return ;
    var xhr = new XMLHttpRequest();
    var currentIndex = Array.prototype.indexOf.call(btn.parentNode.children, btn);
    var textarea = btn.parentNode.children[currentIndex - 1].children[0].children[0].children[0];
    var text = textarea.value;
    textarea.value = '';
    var imgId = btn.id;

    xhr.open('POST', '/comments/add/'+imgId);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var path = window.location.pathname;
    if (path == '/')
        xhr.send('comment='+text+'&page=1'+'&user='+currentUser);
    else
        xhr.send('comment='+text+'&page='+path.split('/').pop()+'&user='+currentUser);
    createComment(currentUser, text, btn.parentElement, btn.parentNode.children[currentIndex - 1]);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (IsJsonString(xhr.responseText))
                var data = JSON.parse(xhr.responseText);
            if (Array.isArray(data) && data.length > 0)
            {

            }
        }
    }
}

function handleEnter(node)
{
    var key = window.event.keyCode;

    if (key === 13) {
        var parent = node.parentElement.parentElement.parentElement.parentElement;
        //addCommentary(parent, node.value, node.id);
    }
}
