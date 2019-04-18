
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>

<!-- <div class="card-content is-overlay is-clipped">
              <span class="tag is-info">
                Photo Title
              </span>
            </div>is-half-desktop is-two-quarter-fullhd is-half-tablet is-two-quarter-mobile
--->

<body>
    <section class="hero is-light is-fullheight-with-navbar" style="align-items: flex-start!important;">
        <div class="hero-body" style="align-items: flex-start!important;width:100%;max-width:100%;">
            <div class="container is-fluid">
                <div class="columns is-multiline is-mobile">
                    <div class="column is-two-quarter-mobile">
                        <video id="video">
                        </video>
                        <canvas id="canvas" style="display:none!important;"></canvas>
                        <div class="colum is-one-quarter mr-t">
                            <button class="button is-primary is-small-mobile" id="startbutton">Prendre une photo</button>
                        </div>
                    </div>
                    <div class="column is-one-quarter is-three-quarter-mobile" style="height:80%;overflow: auto !important;overflow-x: hidden;" id="user-img">

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script type="text/javascript" src="/js/xml_handler.js"></script>
<script type="text/javascript" src="/js/webcam_handler.js"></script>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
