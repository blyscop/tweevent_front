<? include("functions.php");
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
    <link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen"/>
    <link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css"
    media="screen"/>
    <link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css"
    media="screen"/>
    <link rel="stylesheet" href="./css/timelinestyle.css">
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <script src="./js/jquery-1.10.2.js"></script>

    <script src="./js/jquery-ui.js"></script>
    <script src="js/functions.js"></script>
    <? include("functions_js.php"); ?>
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
</head>
<body onload="charger_preferences_utilisateur(); charger_preferences_utilisateur_ajout_event();">
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
                            <? include('header_actu.php'); ?>

                            <section id="suggestions" class="suggestions">
                            <button type="button" id="suggest_close" class="close">×
                                </button>
                                <div class="col-md-12">
                                    <h3 class="f-left no-p-right suggest_title">UNKNOWN -</h3>
                                    <h4 class="f-left no-p-left">DATE DE LEVENT</h4>
                                </div>
                                <p class="f-left">Description DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT DESCRIPTION DE LEVENT </p>
                                <input type="submit" class="btn btn-default" value="Suivre l'évènement"/>
                            </section>

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
            <? include('popups.php'); ?>
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
    <script type="text/javascript" src="js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="./js/jquery.bpopup.min.js"></script>
    <script>

        var _idUser =<?=$_COOKIE["utilisateur_id"] > 0 ? $_COOKIE["utilisateur_id"] : 0 ?>;

        $j.ajax({
            type: "GET",
            url: host + "/projets/tweevent/api/q/req.php",
            data: {action: "Utilisateur_Posts_SELECT", id_utilisateur: _idUser},
            dataType: 'json',
            success: function (msg) {
                console.log(msg);
                $j.each(msg.liste_actualites, function (i, item) {
                    var bloc_image = bloc_popup = "";
                    bloc_popup = 
                    '<div id="contenu_' + item.id_tweevent_post + '"> \
                        <div class="popup_actu_img">       \
                            \
                        </div> \
                        <a class="b-close">x<a/>Url de l"image : ' + item.image + ' | Date de creation : ' + item.date_creation + ' \
                    </div>';
                    if (item.possede_image) {
                        bloc_image = '<a class="fancybox" rel="group" href="' + item.image + '">' +
                        '<div class="cd-timeline-img cd-picture" style="background-image:' + item.image + '; background-size: cover;">' +
                        '</div>' +
                        '</a>';
                    }
                    else {
                        bloc_image = '<div class="cd-timeline-img cd-picture">' +
                        '</div>';
                    }
                    $j('#cd-timeline').append(
                        '<div class="cd-timeline-block">' + bloc_image +
                        '<div class="cd-timeline-content">' +
                        '<h2>' + msg.utilisateur.nom_tweevent_user + ' a commenté</h2>' +
                        '<p>' + item.message_tweevent_post + '</p>' +
                        '<button class="btn btn-default actu_button" id="button_' + item.id_tweevent_post + '" >Voir</button>' +
                        '<span class="cd-date">' + item.date_creation + '</span>' +
                        '</div>' +
                        '</div>' + bloc_popup);


                    $j('#contenu_' + item.id_tweevent_post).css("display", "none");
                    $j('#button_' + item.id_tweevent_post).bind('click', function (e) {
                        $('#contenu_' + item.id_tweevent_post).bPopup();
                    });
                });
            }
        });
        $j(".fancybox").fancybox();
        $j('.new_btn').on("click", function () {
            $j('#file').click();
        });

        $j('#suggest_close').on("click", function () {
            $j('#suggestions').hide();
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