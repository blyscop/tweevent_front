<?php include("functions.php");
check_session(); ?>
<!DOCTYPE html>
<!-- saved from url=(0041)http://localhost/projeti4Save/actions.php -->
<html class="no-js">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Tweevent - A Social Network</title>
    <meta name="generator" content="Bootply"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link href="./css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link href="./css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/timelinestyle.css">
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <script src="./js/jquery-1.10.2.js"></script>

    <script src="./js/jquery-ui.js"></script>
    <script src="js/functions.js"></script>
    <?php include("functions_js.php"); ?>
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(document).ready(function (e) {
            $j('#loading').hide();
            $j("#send_post").on('submit', (function (e) {
                e.preventDefault();
                $j("#message_image").empty();
                $j('#loading').show();
                var formData = new FormData(this);
                $j.ajax({
                    url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Post_ADD&id_utilisateur=<?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>&message=" + $j("#message").val(),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    mimeType: "multipart/form-data",
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $j('#loading').hide();
                        var json_data = JSON.parse(data);
                        if (json_data.confirmation) {
                            window.location.reload(true);
                        }
                        else {
                            alert(json_data.msg);
                        }
                    }
                });
            }));

            $j(function () {
                $j("#file").change(function () {
                    $j("#message_image").empty();
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match = ["image/jpeg", "image/png", "image/jpg"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                        $j('#previewing').attr('src', 'noimage.png');
                        $j("#message_image").html("<p id='error'>Merci de sélectionner une image valide</p>" + "<h4>Formats</h4>" + "<span id='error_message'>jpeg, jpg et png autorisés</span>");
                        return false;
                    }
                    else {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
            function imageIsLoaded(e) {
                $j("#image_preview").css("display", "block");
                $j("#file").css("color", "green");
                $j('#image_preview').css("display", "block");
                $j('#previewing').attr('src', e.target.result);
                $j('#previewing').attr('width', '250px');
                $j('#previewing').attr('height', '230px');
            };
        });
    </script>
    <? include("functions_js.php"); ?>
</head>
<body onload="charger_preferences_utilisateur(); ReceiptPost();">
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
            <!--            INCLURE LE NAVBAR_LEFT ICI-->
            <? include("navbar_left.php"); ?>
            <!-- main right col -->
            <div class="column col-sm-10 col-xs-11" id="main">
                <!-- top nav -->
                <? include("navbar_header.php"); ?>
                <!-- /top nav -->
                <div class="full-actu col-sm-12">
                    <!-- content -->
                    <div class="row">


                        <header>
                            <img class="bloc-round" src="./img/profilpic.jpg"/>
                            <h1>Bonjour <?php echo ucfirst($_COOKIE['username']); ?></h1>
                        </header>
                        <section id="cd-timeline" class="cd-container">
                            <!-- Chargement en AJAX de la liste des actualités -->
                            <div id="liste_actualites"></div>
                        </section> <!-- cd-timeline -->


                    </div><!--/row-->
                    <div><!--colsm9-content-->
                    </div>
                    <!-- /main -->
                </div>
            </div>
        </div>


        <!--post modal-->
        <div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="send_post" name="send_post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" id="close_post_area" class="close" data-dismiss="modal"
                                    aria-hidden="true">×
                            </button>
                            <h4 id='loading'>Chargement ...</h4>
                            <div id="message_image"></div>
                            <div id="ajout_publication_infos">Update Status</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                        <textarea id="message" class="form-control input-lg" name="message" autofocus=""
                                  placeholder="Que voulez-vous partager?"></textarea>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <div>
                                <button id="send_post" class="btn btn-primary">Publier
                                </button>
                                <ul class="pull-left list-inline">
                                    <li>
                                        <div class="upload_photo">
                                            <div id="image_preview" style="display: none;">
                                                <img id="previewing" src="img/noimage.png" height="70%" width="70%"/>
                                            </div>
                                            <div id="selectImage">
                                                <i class="glyphicon glyphicon-camera new_btn"></i>
                                                <input type="file" name="file" id="file"/>
                                            </div>

                                        </div>
                                    </li>
                                    <li>
                                        <i onclick="localiser()" class="glyphicon glyphicon-map-marker"></i>
                                        <div id="localisation"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--PREFERENCES-->

        <div id="preferenceModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content col-md-12 preferences">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4>Vos Préférences</h4>
                    </div>
                    <div id="info_preferences_upd"></div> <!-- AJAX message d'informations sur l'UPD -->
                    <form name="preferences_upd" id="preferences_upd" action="functions.php?action=preferences_upd">
                        <div id="preferences_categories"></div>
                        <!-- AJAX bloc de préférence par catégorie avec checkbox -->
                        <input type="hidden" id="id_utilisateur" name="id_utilisateur"
                               value="<?= $_COOKIE['id_utilisateur'] > 0 ? $_COOKIE['id_utilisateur'] : 0; ?>"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade addEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content col-md-12 preferences">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4>Ajouter Evenement</h4>
            </div>
            <form>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="eventName">Nom de l'évènement</label>
                        <input type="text" class="form-control" id="eventName" placeholder="Nom de l'évènement">
                    </div>
                    <div class="col-md-6">
                        <label for="eventDateDebut">Date de début</label>
                        <input type="date" class="form-control" id="eventDateDebut" placeholder="Date de début">
                        <label class="marge_label" for="eventLieu">Lieu</label>
                        <input type="text" class="form-control" id="eventLieu" placeholder="Lieu de l'évènement">
                    </div>
                    <div class="col-md-6">
                        <label for="eventDateFin">Date de fin</label>
                        <input type="date" class="form-control" id="eventDateFin" placeholder="Date de fin">
                        <label class="marge_label" for="exampleInputPassword1">Bonjour</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Bonjour">
                    </div>
                    <div class="form-group">
                        <label for="eventDesc">Description</label>
                        <textarea type="text" class="form-control" id="eventDesc" placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- script references -->

<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/scripts.js"></script>

<script src="js/fileupload/vendor/jquery.ui.widget.js"></script>
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="js/fileupload/jquery.iframe-transport.js"></script>
<script src="js/fileupload/jquery.fileupload.js"></script>
<script src="js/fileupload/jquery.fileupload-process.js"></script>
<script src="js/fileupload/jquery.fileupload-image.js"></script>
<script src="js/fileupload/jquery.fileupload-audio.js"></script>
<script src="js/fileupload/jquery.fileupload-video.js"></script>
<script src="js/fileupload/jquery.fileupload-validate.js"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />

<link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />

<script>

    $j('.new_btn').on("click", function () {
        $j('#file').click();
    });


    $(document).ready(function () {
        $('[data-toggle=offcanvas]').click(function () {
            $(this).toggleClass('visible-xs text-center');
            $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
            $('.row-offcanvas').toggleClass('active');
            $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
            $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
            $('#btnShow').toggle();
        });
    });
</script>
</body>
</html>