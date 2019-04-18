<div class="container">
    <div class="columns is-centered is-mobile">
        <article class="card is-rounded">
            <div class="columns is-centered is-mobile">
                <article class="card">
                    <div class="card-content">
                        <form action="/login" method="post">
                            <h3 class="title is-3 has-text-centered-mobile" style="color:#363636!important;">
                                Se connecter à Camagru
                            </h3>
                            <div class="field mr-b-5">
                                <p class="control has-icons-left">
                                    <input class="input is-primary" name="email" type="email" placeholder="Email" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="field">
                                <p class="control has-icons-left">
                                    <input class="input is-primary" name="password" type="password" placeholder="Password" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </p>
                            </div>
                            <a href="/reset">
                                <div class="mr-l-1 mr-b-6 under-black is-size-7 has-text-weight-normal is-family-primary field">
                                    Mot de passe oublie ?
                                </div>
                            </a>
                            <p class="control">
                                <button type="submit" name="submit" class="button is-primary is-medium is-fullwidth is-small-mobile">
                                    <i class="fa fa-user mr-r"></i>
                                    Connexion
                                </button>
                            </p>
                            <?php if (isset($type) && $type == "USER_CREDENTIAL"): ?>
                                <article class="message">
                                    <div class="message-body">
                                        <?=$credential;?>
                                    </div>
                                </article>
                            <?php endif; ?>
                        </form>
                    </div>
                </article>
            </div>
        </article>
    </div>
</div>
