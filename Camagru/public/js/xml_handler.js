function img_create(src, alt, title) {
    var img = document.createElement('img');
    img.src = src;
    if ( alt != null ) img.alt = alt;
    if ( title != null ) img.title = title;
    return img;
}

function displayImages(data)
{
    for(i = 0; i < data.length; i++)
    {
        addImg(data[i], true);
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

function async_request(xhr, method, url, data, type) {
    xhr.open(method, url);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
    var container = document.getElementById('user-img');
    var data = [];

    if (type !== 'delete')
    {
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (IsJsonString(xhr.responseText))
                    var data = JSON.parse(xhr.responseText);
                if (Array.isArray(data) && data.length > 1)
                {
                    displayImages(data);
                }else if (data !== undefined && data !== "" && data.length != 0){
                    addImg(data);
                }
            }
        }
    }
    xhr.onerror = function() {
        console.log("Request failed");
    };
}

function do_xml_request(method, url, data, type = null) {
    var container = document.getElementById('user-img');
    var xhr = new XMLHttpRequest();
    async_request(xhr, method, url, data, type);
}

function addImg(img, isAll = false)
{
    var container = document.getElementById('user-img');
    var lastIndex = Array.isArray(img) ? img.length - 1 : -1;
    var currentImg = (isAll == false && Array.isArray(img) && lastIndex !== -1) ?
    img_create(img[lastIndex],  "user-img") : img_create(img, "user-img");
    var figure = document.createElement('figure');
    var mainDiv = document.createElement('div');

    var card = document.createElement('article');
    var cardContent = document.createElement('div');

    var cardBtn = document.createElement('div');
    cardBtn.style.padding = '2%';

    //var deleteBtn = document.createElement('a');
    var icon = document.createElement('span');
    var iconElement = document.createElement('i');
    var text = document.createElement('span');

    iconElement.className = 'fas fa-times-circle fa-lg icon-responsive2 icon-reponsive-lg-percent';
    //iconElement.style.color = '#212529';
    icon.className = 'tag is-info is-small-mobile';
    icon.style.float = 'right';
    icon.style.cursor = 'pointer';
    icon.appendChild(iconElement);

    //text.innerHTML = 'Supprimer';
    text.className = 'reponsive-text-1';
    //deleteBtn.className = 'button is-danger is-small-mobile';
    //
    // /ressources/images/tho/opCngxceiOYNNk2AmkgVmN4XKrkxVNtD.png
    icon.addEventListener('click', function(event){
        var parent = this.parentElement.parentElement;
        var path = parent.children[0].children[0].children[0].src;
        var urlPath = new URL(path).pathname;
        do_xml_request('POST', '/profil/img/delete', 'delete=1&path='+urlPath, 'delete');
        event.preventDefault();
        parent.parentElement.removeChild(parent);
    }, false);
    //deleteBtn.appendChild(text);
    //deleteBtn.appendChild(icon);

    card.className = 'card mr-b';
    cardContent.className = 'card-image';
    card.appendChild(cardContent);
    cardBtn.className = 'card-content is-overlay is-clipped';
    cardBtn.appendChild(icon);
    card.appendChild(cardBtn);

    mainDiv.className = 'level-item has-text-centered';
    mainDiv.appendChild(currentImg);
    cardContent.appendChild(mainDiv);

    container.appendChild(card);
}
