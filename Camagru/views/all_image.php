
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>

<body>
<section class="hero is-light is-fullheight-with-navbar">
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
                                                    <?php echo '('.htmlspecialchars($commentaryNumber).')'; ?>
                                                <?php else: ?>
                                                    <?php echo '(0)'; ?>
                                                <?php endif; ?>
                                            </i>
                                        </a>
                                    </div>
                                    <div class="column is-half">
                                        <a class="card-footer-item mr-t" id="<?php echo htmlspecialchars($img->id); ?>"
                                            style="width:100%" onclick="addLike(this)">
                                            <?php if (isAuth() && isset($_SESSION['email'])
                                            && $util->isLikedByUser($img->id, $_SESSION['email'])
                                            && ($likesNumber = htmlspecialchars($util->getLikesNumber($img->id))) > 0): ?>
                                            <i class="fas fa-thumbs-up icon-responsive">
                                                <?php echo '<br />('.htmlspecialchars($likesNumber).')'; ?>
                                            </i>
                                        <?php else: ?>
                                            <i class="far fa-thumbs-up icon-responsive">
                                                <?php if (($likesNumber = htmlspecialchars($util->getLikesNumber($img->id))) > 0): ?>
                                                    <?php echo '<br />('.htmlspecialchars($likesNumber).')'; ?>
                                                <?php else: ?>
                                                    <?php echo '<br />('.htmlspecialchars('0').')'; ?>
                                                <?php endif; ?>
                                            </i>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="modal">
                                    <div class="modal-background"></div>
                                    <div class="modal-card" id="modal-body">
                                        <header class="modal-card-head" style="background:none;padding:3%">
                                            <p class="modal-card-title"></p>
                                        </header>
                                        <section class="modal-card-body" style="width:100%;background-color: rgb(231, 236, 239);!important;">
                                            <!-- Content ... -->
                                        </section>
                                </div>
                                <button class="modal-close is-large" style="right:2%;top:6%"
                                aria-label="close" onclick="hideModal(this)"></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="hero-foot" style="height:10%;">
    <?php include_once(dirname(__DIR__)."/views/paginate.php"); ?>
</div>
</section>
</body>


<script>

const currentUser = <?php echo json_encode(htmlspecialchars($_SESSION['name'])); ?>;
const islooged = <?php echo json_encode(htmlspecialchars(isAuth())); ?>;

</script>

<script type="text/javascript" src="/js/commentary_and_likes.js"></script>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
