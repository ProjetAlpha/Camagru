
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>


<section class="hero is-light is-fullheight-with-navbar">
    <!-- fetch les images dans la DB et les paginates | ajouts des commentaires + likes -->
    <!-- Quand on clic sur afficher les commentaires, requete ajax et affiche les commentaires associe avec l'image --->
    <div class="hero-body" style="display:block!important;">
        <?php if (isset($images)): ?>
            <?php foreach ($images as $img): ?>
                <div class="columns is-centered is-mobile">
                    <div class="column is-half-desktop is-two-quarter-fullhd is-half-tablet is-two-quarter-mobile has-text-centered">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image">
                                    <img src="<?php echo htmlspecialchars($img->img_path); ?>"
                                    id="<?php echo htmlspecialchars($img->id); ?>" alt="user-image"/>
                                </figure>
                            </div>
                            <div class="columns is-centered is-multiline is-mobile mr-b">
                                <div class="column has-text-centered">
                                    <a class="card-footer-item" id="<?php echo htmlspecialchars($img->id); ?>"
                                        onclick="getComments(this)">
                                        Afficher les commentaires
                                    </a>
                                    <div class="modal">
                                        <div class="modal-background"></div>
                                        <div class="modal-card">
                                            <header class="modal-card-head">
                                                <p class="modal-card-title">Modal title</p>
                                                <button class="delete" aria-label="close" onclick="hideModal(this)"></button>
                                            </header>
                                            <section class="modal-card-body">
                                                <!-- Content ... -->
                                            </section>
                                            <!-- <footer class="modal-card-foot">
                                            <button class="button is-success" onclick="hideModal(this)">Save changes</button>
                                            <button class="button" onclick="hideModal(this)">Cancel</button>
                                        </footer> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column" id="add-comments-<?php echo htmlspecialchars($img->id); ?>">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- si on clic sur afficher les commentaires + on est log, afficher le ajouter un commentaire apres
        avoir load les commentaires. --->
        <!--<div class="columns is-centered is-mobile" id="display-comments-<?php echo htmlspecialchars($img->id); ?>"
        style="display:none;">
        <div class="field" style="width:60%;">
        <div class="control">
        <textarea class="textarea is-small" placeholder="Ajouter un commentaire" required></textarea>
        <button class="button is-primary is-medium is-small-mobile is-pulled-right mr-b mr-t"
        type="submit" id="<?php echo htmlspecialchars($img->id); ?>" onclick="addCommentary(this)">
        Valider</button>
    </div>
</div>
</div> --->

<!-- si il est affiche l'option likes $img->id | $img->img_path --->
<?php endforeach; ?>
<?php endif; ?>
</div>
<!-- si il est co affiche l'option comments --->
<div class="hero-foot" style="height:10%;">
    <?php include_once(dirname(__DIR__)."/views/paginate.php"); ?>
</div>
</section>

<script>

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
    var parent = link.parentElement.children[1].children[1].children[1];
    var srcImg = link.parentElement.parentElement.parentElement.children[0].children[0].children[0];
    var container = document.createElement('div'),
    cardImg =  document.createElement('div'),
    figure = document.createElement('figure'),
    img = document.createElement('img');

    cardImg.className = 'card-image';
    figure.className = 'image mr-b';
    img.src = srcImg.src;
    img.style.borderRadius = '2%';
    img.style.width = '100%';
    img.style.height = 'auto';
    container.className = 'columns is-centered is-mobile';

    figure.appendChild(img);
    cardImg.appendChild(figure);

    container.appendChild(cardImg);
    parent.appendChild(container);
}


function createComment(txt, dst, before = null)
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
    cardContent.className = 'card-content';
    cardContentTxt.className = 'content';
    cardContentTxt.innerHTML = txt;

    cardContent.appendChild(cardContentTxt);
    articleCard.appendChild(cardContent);
    cardCol.appendChild(articleCard);
    dst.style.background = '#E7ECEF';
    //(newItem, list.childNodes[0]);
    if (before !== null)
    dst.insertBefore(cardCol, before);
    else {
        dst.appendChild(cardCol);
    }
}


function getAllComments(comments, link)
{
    var parent = link.parentElement.children[1].children[1].children[1];
    console.log(parent);
    for(i = 0; i < comments.length; i++)
    {
        createComment(comments[i], parent);
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
    let parent = node.parentElement.parentElement.parentElement;
    parent.classList.remove('is-active');
    var modalBody = parent.children[1].children[1];
    while (modalBody.firstChild) {
        modalBody.removeChild(modalBody.firstChild);
    }
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
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
                /*
                    overflow-x: hidden;
                    overflow-y: scroll !important;
                 */

                document.getElementsByTagName("html")[0].style.overflowX = 'hidden';

                document.getElementsByTagName("html")[0].style.overflowY = 'scroll !important';
                var parent = link.parentElement.children[1];
                parent.classList.add('is-active');
                current_node = parent;
                createImg(link);
                getAllComments(data, link);
                var dstBody = link.parentElement.children[1].children[1].children[1];
                createTextarea(dstBody, link);
            }else {
                var parent = link.parentElement.children[1];
                parent.classList.add('is-active');
                current_node = parent;
                createImg(link);
                var dstBody = link.parentElement.children[1].children[1].children[1];
                createTextarea(dstBody, link);
            }
        }
    }
}

function addCommentary(btn)
{
    var xhr = new XMLHttpRequest();
    var currentIndex = Array.prototype.indexOf.call(btn.parentNode.children, btn);
    var textarea = btn.parentNode.children[currentIndex - 1].children[0].children[0].children[0];
    var text = textarea.value;
    textarea.value = '';
    var imgId = btn.id;

    xhr.open('POST', '/comments/add/'+imgId);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('comment='+text);

    createComment(text, btn.parentElement, btn.parentNode.children[currentIndex - 1]);

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

</script>
<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
