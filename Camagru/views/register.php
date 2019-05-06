<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>

<?php if (!isAuth()): ?>
<section class="hero is-light is-fullheight-with-navbar">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered is-mobile">
                <article class="card is-rounded">
                    <div class="columns is-centered is-mobile">
                        <article class="card">
                            <div class="card-content">
                                <form action='/login/register' method='post'>
                                    <h3 class="title is-3 has-text-centered-mobile" style="color:#363636!important;">
                                        Créer votre compte
                                    </h3>
                                    <div class="field mr-b-5">
                                        <p class="control has-icons-left">
                                            <input class="input is-primary" name="name" type="name" placeholder="Name" required>
                                            <span class="icon is-small is-left">
                                                <i class="fa fa-font"></i>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="field mr-b-5">
                                        <p class="control has-icons-left">
                                            <input class="input is-primary" name="email" type="email" placeholder="Email" required>
                                            <span class="icon is-small is-left">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="field mr-b-6">
                                        <p class="control has-icons-left">
                                            <input class="input is-primary" name="password" type="password" placeholder="Password" required>
                                            <span class="icon is-small is-left">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </p>
                                    </div>
                                    <p class="control">
                                        <button type="submit" class="button is-primary is-medium is-fullwidth is-small-mobile">
                                            <i class="fa fa-user mr-r"></i>
                                            Inscription
                                        </button>
                                    </p>
                                    <?php if (isset($type) && $type == "USER_WARNING"): ?>
                                        <article class="message">
                                            <div class="message-body">
                                                <?=$warning; ?>
                                            </div>
                                        </article>
                                    <?php endif;?>
                                </form>
                            </div>
                        </article>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
    <?php redirect('/'); ?>
<?php endif; ?>
<?php include_once(ROOT."/views/footer.php"); ?>
