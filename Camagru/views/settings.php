<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>

<section class="hero is-light is-fullheight-with-navbar">
    <div class="hero-body" style="align-items: flex-start!important;width:100%;max-width:100%;">
        <div class="container is-fluid">
            <div class="columns is-multiline is-centered is-mobile">
                <div class="mr-t column has-text-centered is-three-quarters-tablet is-three-quarters-mobile is-three-quarters-desktop is-three-quarters-fullhd card is-rounded is-mobile">
                    <div class="has-text-centered card-content mr-t" style="padding:1%;">
                        <h3 class="title is-4 has-text-centered-mobile"
                        style="padding:0!important;margin:0!important;color:#363636!important;">
                        Modifier le mot de passe
                    </h3>
                    <form action="/settings/modifPwd" method="post" class="responsive-form" style="display: inline-block;margin:0;">
                        <hr>
                        <div class="field mr-b-5 mr-t">
                            <p class="control has-icons-left">
                                <input class="input is-primary" name="oldpwd" type="password" placeholder="Ancien mot de passe" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control has-icons-left">
                                <input class="input is-primary input-responsive" name="newpwd" type="password" placeholder="Nouveau mot de passe" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </p>
                        </div>
                        <p class="control">
                            <button type="submit" name="submit" class="button font-responsive-btn is-primary is-medium is-fullwidth is-small-mobile">
                                <i class="fas fa-user-edit mr-r"></i>
                                Modifier
                            </button>
                        </p>
                        <?php if (isset($type) && $type == "USER_WARNING_PWD"): ?>
                            <div class="field mr-t">
                                <div class="message">
                                    <div class="message-body">
                                        <?=$warning;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="has-text-centered card-content mr-t" style="padding:1%;">
                    <h3 class="title is-4 has-text-centered-mobile" style="padding:0!important;margin:0!important;color:#363636!important;">
                        Modifier le nom
                    </h3>
                    <form action="/settings/modifName" method="post" class="responsive-form" style="display: inline-block;margin:0">
                        <hr>
                        <div class="message">
                            <div class="message-body" style="padding:3%;border:none">
                                Nom :
                                <?php if (isset($_SESSION['name'])):?>
                                    <?php echo htmlspecialchars($_SESSION['name']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="field mr-t">
                            <p class="control has-icons-left">
                                <input class="input is-primary" name="newname" type="name" placeholder="Nouveau nom" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-font"></i>
                                </span>
                            </p>
                        </div>
                        <p class="control">
                            <button type="submit" name="submit" class="button font-responsive-btn is-primary is-medium is-fullwidth is-small-mobile">
                                <i class="fas fa-user-edit mr-r"></i>
                                Modifier
                            </button>
                        </p>
                        <?php if (isset($type) && $type == "USER_WARNING_NAME"): ?>
                            <div class="field mr-t">
                                <div class="message">
                                    <div class="message-body">
                                        <?=$warning;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="has-text-centered card-content mr-t mr-b" style="padding:1%;">
                    <h3 class="title is-4 has-text-centered-mobile" style="padding:0!important;margin:0!important;color:#363636!important;">
                        Modifier le mail
                    </h3>
                    <form action="/settings/modifEmail" method="post" class="responsive-form" style="display: inline-block;margin:0">
                        <hr>
                        <?php if (isset($_SESSION['email'])):?>
                            <div class="message">
                                <div class="message-body" style="border:none;padding:1%;">
                                    Mail :
                                    <?php echo htmlspecialchars($_SESSION['email']); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="field mr-t">
                            <p class="control has-icons-left">
                                <input class="input is-primary" name="newemail" type="email" placeholder="Nouveau mail" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </p>
                        </div>
                        <p class="control">
                            <button type="submit" name="submit" class="button font-responsive-btn is-primary is-medium is-fullwidth is-small-mobile">
                                <i class="fas fa-user-edit mr-r"></i>
                                Modifier
                            </button>
                        </p>
                        <?php if (isset($type) && $type == "USER_WARNING_EMAIL"): ?>
                            <div class="field mr-t">
                                <div class="message">
                                    <div class="message-body">
                                        <?=$warning;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="has-text-centered card-content mr-t mr-b" style="padding:1%;">
                    <h3 class="title is-4 has-text-centered-mobile" style="padding:0!important;margin:0!important;color:#363636!important;">
                        Notifications
                    </h3>
                    <form action="/settings/modifNotif" method="post" style="display: inline-block;margin:0">
                        <hr>
                            <label class="checkbox mr-t mr-b-5">
                                    Notification des commentaires
                                    <input id="checkbox" type="checkbox" name="notification" value=""/>
                            </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script type="text/javascript" src="/js/notifications.js"></script>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
