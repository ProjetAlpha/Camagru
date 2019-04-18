
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>


<?php if (isset($type) && $type == "USER_CONFIRMATION" && isset($confirmation)): ?>
    <section class="hero is-light is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container has-text-centered">
                <article class="message is-info is-medium">
                    <div class="message-body is-large">
                        <?=$confirmation;?>
                    </div>
                </article>
            </div>
        </div>
    </section>
<?php elseif (!isAuth()): ?>
    <section class="hero is-light is-fullheight-with-navbar">
        <div class="hero-body">
            <?php include_once(dirname(__DIR__)."/views/login.php"); ?>
        </div>
    </section>
<?php else: ?>

    <?php redirect('/'); ?>

<?php endif; ?>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
