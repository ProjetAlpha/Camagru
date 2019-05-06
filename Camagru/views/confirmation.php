<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>


<section class="hero is-light is-fullheight-with-navbar">
    <div class="hero-body">
        <div class="container has-text-centered">
            <article class="message is-info is-medium">
                <div class="message-body is-large">
                    <?php if (isset($type) && $type == "confirmed"): ?>
                        Votre inscription au site est confirmée.
                    <?php else: ?>
                        Votre inscription au site est déjà confirmée.
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </div>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
