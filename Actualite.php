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
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        // Chargement en AJAX de la liste des catégories de préferences (exemple : musique, boissons, etc...)
        /*
         Le code à générer est sous la forme suivante :
         <div class="col-md-4">
         <i class="fa fa-glass fa-4x" aria-hidden="true"></i>
         <div><input type="checkbox"/> Vin</div>
         <div><input type="checkbox"/> Bière</div>
         <div><input type="checkbox"/> Whisky</div>
         <div><input type="checkbox"/> Rhum</div>
         <div><input type="checkbox"/> Gin</div>
         <div><input type="checkbox"/> Vodka</div>
         <div><input type="checkbox"/> Tequila</div>
         </div>
         */
        function charger_preferences_utilisateur() {
            $j.ajax({
                type: "GET",
                url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_Preferences_SELECT_ALL&id_utilisateur=<?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>",
                dataType: 'json',
                success: function (data) {
                    var html = "";
                    $j('#preferences_categories').empty();
                    $j.each(data, function (categorie, objet_preference) {
                        var class_tag_i = "";
                        if (categorie != "music")
                            class_tag_i = "glass";
                        else
                            class_tag_i = categorie;
                        html += "<div id='" + categorie + "Preferences' class='col-md-4'> <i class='fa fa-" + class_tag_i + " fa-4x' aria-hidden='true'></i>";
                        $j.each(objet_preference, function (preference, droit) {
                            var html_checkbox_preference = "";
                            if (droit) {
                                html += "<div><input type='checkbox' class='preferences' id='" + preference + "' name='" + preference + "' checked='checked'>" + preference + "</input></div>";
                            }
                            else {
                                html += "<div><input type='checkbox' class='preferences' id='" + preference + "' name='" + preference + "'>" + preference + "</input></div>";
                            }
                        });
                        html += "</div>";
                    });
                    html += "<table class='table borderles'><input type='button' value='Envoyer' class='btn btn-default btn-preference' onclick='modifier_preferences_utilisateur();' /></table>";
                    $j('#preferences_categories').append(html);
                }
            });
        }

        function ReceiptPost() {
            var _idUser =<?=$_COOKIE["utilisateur_id"] > 0 ? $_COOKIE["utilisateur_id"] : 0 ?>;

            $.ajax({
                type: "GET",
                url: host + "/projets/tweevent/api/q/req.php",
                data: {action: "Utilisateur_Posts_SELECT", id_utilisateur: _idUser},
                dataType: 'json',
                success: function (msg) {
                    console.log(msg);
                    $.each(msg.actualites, function (i, item) {
                        $('#cd-timeline').append('<div class="cd-timeline-block">' +
                            '<div class="cd-timeline-img cd-picture">' +
                            '<img src="./img/cd-icon-picture.svg" alt="Picture">' +
                            '</div>' +
                            '<div class="cd-timeline-content">' +
                            '<h2>Unknow a commenté</h2>' +
                            '<p>' + item.message_tweevent_post + '</p>' +
                            '<a href="#0" class="cd-read-more">Read more</a>' +
                            '<span class="cd-date">' + parseJsonDate(item.date_add) + '</span>' +
                            '</div>' +
                            '</div>');
                    })
                }
            });
        }
        $j(document).ready(function (e) {
            $j('#loading').hide();
            $j("#send_post").on('submit', (function (e) {
                if($j("#message").val() != "") {
                e.preventDefault();
                $j("#message_image").empty();
                $j('#loading').show();
                    $j.ajax({
                        url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Post_ADD&id_utilisateur=<?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>&message=" + $j("#message").val(),
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
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
                }
                else {
                    alert("Merci d'écrire un message ! ;-)");
                    return false;
                }
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
        // Modification des préférences de l'utilisateur, on requête le serveur d'API avec les cases cochées et il va nous répondre s'il a bien traiter notre demande (pour afficher un message à l'user)
        // Il faut penser à recharger le bloc en réappelant la fonction après l'UPD (s'il s'est bien déroulé)
        function modifier_preferences_utilisateur(params) {
            var preferences_cochees = "";
            var id_utilisateur = <?=$_COOKIE["utilisateur_id"] > 0 ? $_COOKIE["utilisateur_id"] : 0 ?> ;
            $j('input[type=checkbox]').each(function () {
                var est_cochee = (this.checked ? "1" : "0");
                preferences_cochees += (preferences_cochees == "" ? est_cochee + "_" + this.name : "|" + est_cochee + "_" + this.name);
            });
            // Liste sous la forme 1_Pizza pour à coché 1, ou 0_Pizza pour n'a pas coché pizza
            $j.ajax({
                type: "POST",
                url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php",
                data: {
                    action: "Utilisateur_Preferences_UPD",
                    id_utilisateur: id_utilisateur,
                    preferences: preferences_cochees
                },
                success: function (msg) {
                    alert("Vos préférences ont bien été mise à jour !");
                }
            });

        }


        // Fonction pour localiser un utilisateur lors du clic (natif à html5)
        function localiser() {
            // Si le navigateur le supporte, on execute getCurrentPosition, qui peut appelée montrerPosition ou montrerErreur suivant le callback
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(montrerPosition, montrerErreur);
            } else {
                x.innerHTML = "La géolocalisation n'est pas supportée pour votre terminal.";
            }
        }
        // Affiche un iframe provenant de gmaps avec la position de l'utilisateur
        function montrerPosition(position) {
            var lat_lon = position.coords.latitude + "," + position.coords.longitude;
            var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
                + lat_lon + "&zoom=14&size=400x300&sensor=false";
            document.getElementById("localisation").innerHTML = "<img src='" + img_url + "'>";
        }
        // Si une erreur survient (ex : géo désactivée sur le terminal), on affiche un message
        function montrerErreur(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    document.getElementById("ajout_publication_infos").innerHTML = "User denied the request for Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    document.getElementById("ajout_publication_infos").innerHTML = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    document.getElementById("ajout_publication_infos").innerHTML = "The request to get user location timed out.";
                    break;
                case error.UNKNOWN_ERROR:
                    document.getElementById("ajout_publication_infos").innerHTML = "An unknown error occurred.";
                    break;
            }
        }
    </script>
</head>
<body onload="charger_preferences_utilisateur(); ReceiptPost();">
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
            <!-- sidebar -->
            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#" data-toggle="offcanvas"
                           class="visible-xs text-center">
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav hidden-xs" id="lg-menu">
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#preferenceModal" role="button"
                           data-toggle="modal">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            Préferences
                        </a>
                    </li>
                    <li>
                        <a href="Calendrier.php">
                            <i class="glyphicon glyphicon-list"></i>
                            Calendrier
                        </a>
                    </li>
                    <li>
                        <a id="addEvent" href="#" data-toggle="modal" data-target=".addEvent">
                            <i class="glyphicon glyphicon-paperclip"></i>
                            Ajouter Evenement
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#">
                            <i class="glyphicon glyphicon-refresh"></i>
                            Refresh
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                    <li>
                        <a href="http://www.bootply.com/">
                            <h3>Tweevent</h3>
                            <i class="glyphicon glyphicon-heart-empty"></i>
                            Events
                        </a>
                    </li>
                </ul>

                <!-- tiny only nav-->
                <ul class="nav visible-xs" id="xs-menu">
                    <li>
                        <a href="#preferenceModal" role="button"
                           data-toggle="modal">
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- /sidebar -->
            <!-- main right col -->
            <div class="column col-sm-10 col-xs-11" id="main">
                <!-- top nav -->
                <div class="navbar navbar-blue navbar-static-top">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <img class="logo_tw" src="./img/logotw.png" height="30">
                    </div>
                    <nav class="collapse navbar-collapse" role="navigation">
                        <form class="navbar-form navbar-left">
                            <div class="input-group input-group-sm" style="max-width:360px;">
                                <input type="text" class="form-control" placeholder="Search" name="srch-term"
                                       id="srch-term">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="Actualite.php">
                                    <i class="glyphicon glyphicon-home"></i>
                                    Actualités
                                </a>
                            </li>
                            <li>
                                <a href="http://localhost/projeti4Save/actions.php#postModal" role="button"
                                   data-toggle="modal">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Post
                                </a>
                            </li>
                            <li>
                                <a href="http://localhost/projeti4Save/actions.php#">
                                    <span class="badge">badge</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="http://localhost/projeti4Save/actions.php#" class="dropdown-toggle"
                                   data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Mon profil</a></li>
                                    <li><a href="functions.php?action=disconnect">Déconnexion</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
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

                                    <!--                                <li>-->
                                    <!--                                    <a href="">-->
                                    <!--                                        <i class="glyphicon glyphicon-upload"></i>-->
                                    <!--                                    </a>-->
                                    <!--                                </li>-->
                                    <li>
                                        <div class="upload_photo">
                                            <div id="image_preview" style="display: none;">
                                                <img id="previewing" src="img/noimage.png" height="70%" width="70%"/>
                                            </div>
                                            <div id="selectImage">
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

<script>
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/',
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                        data = $this.data();
                    $this
                        .off('click')
                        .text('Abort')
                        .on('click', function () {
                            $this.remove();
                            data.abort();
                        });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 9999000,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
</body>
</html>