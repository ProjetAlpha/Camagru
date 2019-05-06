
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<?php include_once(dirname(__DIR__)."/views/nav.php"); ?>

<body>
    <section class="hero is-light is-fullheight-with-navbar" style="align-items: flex-start!important;">
        <div class="hero-body" style="align-items: flex-start!important;width:100%;max-width:100%;">
            <div class="container is-fluid">
                <div class="columns is-multiline is-mobile">
                    <div class="column is-two-thirds-tablet is-two-thirds-mobile is-two-thirds-desktop is-two-thirds-fullhd">
                        <video class="mr-l-4" id="video">
                        </video>
                        <canvas id="canvas" style="display:none!important;"></canvas>
                        <img id="img-display" src="" style="display:none!important;"></img>
                        <div class="card mr-t column" id="card-filter">
                                <header class="card-header">
                                    <p class="card-header-title has-text-centered txt-responsive">
                                        Sélectionner une image
                                    </p>
                                </header>
                                <div class="card-content">
                                    <div class="columns is-multiline is-mobile">
                                        <div class="column is-one-fifth">
                                            <figure class="image" style="z-index:999!important">
                                                <img src="/ressources/images/custom/pomme.png" id="pomme-img"
                                                onmousedown="startImg(event, this)" style="background: none;"/>
                                            </figure>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <figure class="image" style="z-index:999!important;">
                                                <img src="/ressources/images/custom/heart.png" id="heart-img" onmousedown="startImg(event, this)"/>
                                            </figure>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <figure class="image" style="z-index:999!important;">
                                                <img src="/ressources/images/custom/poop.png" id="poop-img" onmousedown="startImg(event, this)"/>
                                            </figure>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <figure class="image" style="z-index:999!important;">
                                                <img src="/ressources/images/custom/champ_png.png" id="champ-img" onmousedown="startImg(event, this)"/>
                                            </figure>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <figure class="image" style="z-index:999!important;">
                                                <img src="/ressources/images/custom/star2.png" id="start-img" onmousedown="startImg(event, this)"/>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                        </div>
                        <div class="column mr-l is-one-quarter mr-t">
                            <button class="button is-primary is-small-mobile" id="startbutton">Prendre une photo</button>
                        </div>
                        <!-- Ajouter une image si pas de webcam -->
                        <div class="column is-one-quarter mr-t mr-l">
                            <input id="findImg" type='file' accept='image/*' onchange='openFile(event)' style="display:none;"><br>
                            <button class="button is-primary is-small-mobile" id="addImg" style="display:none;">Ajouter une image</button>
                        </div>
                    </div>
                    <div class="column is-one-third-tablet is-one-third-desktop is-one-third-fullhd is-one-third-mobile" style="height:80%;overflow: auto !important;overflow-x: hidden;" id="user-img">

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script type="text/javascript" src="/js/xml_handler.js"></script>
<script type="text/javascript" src="/js/drag_drop.js"></script>
<script type="text/javascript" src="/js/webcam_handler.js"></script>
<!-- <script type="text/javascript" src="/js/.js"></script> -->

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
