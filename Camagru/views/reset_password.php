<?php require_once(dirname(__DIR__).'/views/header.php'); ?>


<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>


<section class="hero is-light is-fullheight-with-navbar">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered is-mobile">
                <article class="card is-rounded">
                    <div class="columns is-centered is-mobile">
                        <article class="card">
                            <div class="card-content">
                                <form action='/reset/send' method='post'>
                                    <h3 class="title is-3 has-text-centered-mobile" style="color:#363636!important;">
                                        Modifier son mot de passe
                                    </h3>
                                    <?php if (isset($reset) && $reset == "mailing"): ?>
                                        <div class="field mr-b-5">
                                            <p class="control has-icons-left">
                                                <input class="input is-primary" name="email" type="email" placeholder="Email" required>
                                                <span class="icon is-small is-left">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($reset) && $reset == "confirmed"): ?>
                                        <div class="field mr-b-5">
                                            <p class="control has-icons-left">
                                                <input class="input is-primary" name="new_password" type="password" placeholder="Password" required>
                                                <span class="icon is-small is-left">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <p class="control">
                                        <button type="submit" class="button is-primary is-medium is-fullwidth is-small-mobile">
                                            <i class="fa fa-user mr-r"></i>
                                            Confirmer
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

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
