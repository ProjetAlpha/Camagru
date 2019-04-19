
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
                        <div class="card" style="border-radius:0!important">
                            <div class="card-image">
                                <figure class="image">
                                    <img src="<?php echo htmlspecialchars($img->img_path); ?>"
                                    id="<?php echo htmlspecialchars($img->id); ?>" alt="user-image"/>
                                </figure>
                            </div>
                            <div class="columns is-centered is-multiline is-mobile mr-b mr-t">
                                <div class="columns is-mobile">
                                    <div class="column is-half">
                                        <a class="card-footer-item mr-t" id="<?php echo htmlspecialchars($img->id); ?>"
                                            onclick="getComments(this)" style="width:100%;">
                                            <i class="fas fa-comments icon-responsive">
                                            <?php if (($commentaryNumber = htmlspecialchars($util->getCommentaryNumber($img->id))) > 0): ?>
                                                (<?php echo htmlspecialchars($commentaryNumber); ?>)
                                            <?php else: ?>
                                                <?php echo 0; ?>
                                            <?php endif; ?>
                                            </i>
                                        </a>
                                    </div>
                                    <div class="column is-half">
                                        <a class="card-footer-item" id="<?php echo htmlspecialchars($img->id); ?>"
                                            style="width:100%">
                                            <i class="fas fa-thumbs-up icon-responsive"></i>
                                        </a>
                                    </div>
                                    <div class="modal">
                                        <div class="modal-background"></div>
                                        <div class="modal-card" id="modal-body">
                                            <header class="modal-card-head" style="background:none;padding:3%">
                                                <p class="modal-card-title"></p>
                                            </header>
                                            <section class="modal-card-body">
                                                <!-- Content ... -->
                                            </section>
                                            <!-- <footer class="modal-card-foot">
                                            <button class="button is-success" onclick="hideModal(this)">Save changes</button>
                                            <button class="button" onclick="hideModal(this)">Cancel</button>
                                        </footer> -->
                                    </div>
                                    <button class="modal-close is-large" style="right:2%;top:6%"
                                    aria-label="close" onclick="hideModal(this)"></button>
                                </div>
                            </div>
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

const currentUser = '<?php echo json_encode(htmlspecialchars($_SESSION['name'])); ?>';
const islooged = <?php echo json_encode(htmlspecialchars(isAuth())); ?>;

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
    img.style.borderRadius = '6%';
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
    // clic en dehors de la window.
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

console.log(islooged);

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
            console.log(xhr.responseText);
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
                var parent = link.parentElement.children[1];
                console.log(link.parentElement);
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
        xhr.send('comment='+text+'&page=1');
    else
        xhr.send('comment='+text+'&page='+path.split('/').pop()+'&user=');
    createComment(text, btn.parentElement, btn.parentNode.children[currentIndex - 1]);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
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
