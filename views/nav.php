<nav class="navbar is-white" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="/">
            <span class="logo" width="112" height="28">CAMAGRU</span>
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a href="/" class="navbar-item mr-r">
                <i class="fas fa-home fa-lg"></i>
            </a>

            <a href="/image" class="navbar-item mr-r">
                <i class="fas fa-images fa-lg"></i>
            </a>

            <?php if (isset($_SESSION, $_SESSION['token'], $_SESSION['name']) && isAuth()): ?>
                <a href="/profil" class="navbar-item mr-r">
                    <i class="fas fa-user fa-lg"></i>
                </a>
            <?php endif; ?>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <?php if (isset($_SESSION, $_SESSION['token'], $_SESSION['name']) && isAuth()): ?>
                        <a href="/logout" class="button is-primary">
                            <strong>Déconnexion</strong>
                        </a>
                    <? endif; ?>
                <?php else: ?>
                    <a href="/register" class="button is-primary">
                        <strong>Inscription</strong>
                    </a>
                    <a href="/login" class="button is-light">
                        Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</nav>
<script>
(function() {
    var burger = document.querySelector('.burger');
    var nav = document.querySelector('#'+burger.dataset.target);

    burger.addEventListener('click', function(){
        burger.classList.toggle('is-active');
        nav.classList.toggle('is-active');
    });
})();
</script>
