<? session_start();
include("functions.php");
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
    <link rel='stylesheet' href='./css/fullcalendar.min.css'/>


    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body onload="charger_preferences_utilisateur(); ReceiptPost();">
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <!-- sidebar -->
                <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li>
                            <a href="#" data-toggle="offcanvas"
                            class="visible-xs text-center">
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav hidden-xs" id="lg-menu">
                    <li>
                        <a href="#preferenceModal" role="button"
                        data-toggle="modal">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Préferences
                    </a>
                </li>
                <li>
                    <a href="Calendrier">
                        <i class="glyphicon glyphicon-list"></i>
                        Calendrier
                    </a>
                </li>
                <?php if($_COOKIE['utilisateur_type']=="pro"){?>
                <li>
                    <a id="addEvent" href="#" data-toggle="modal" data-target=".addEvent">
                        <i class="glyphicon glyphicon-paperclip"></i>
                        Ajouter Evenement
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-refresh"></i>
                        Refresh
                    </a>
                </li>
            </ul>
            <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                <li>
                    <a href="#">
                        <h3>Tweevent</h3>
                        <i class="glyphicon glyphicon-heart-empty"></i>
                        Events
                    </a>
                </li>
            </ul>

            <!-- tiny only nav-->
            <ul class="nav visible-xs" id="xs-menu">
                <li>
                    <a href="#preferenceModal" class="text-center" role="button" data-toggle="modal">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </a>
                </li>
                <li><a href="Calendrier" class="text-center"><i class="glyphicon glyphicon-list"></i></a></li>
                <li><a id="addEvent" href="#" class="text-center" data-toggle="modal" data-target=".addEvent"><i class="glyphicon glyphicon-paperclip"></i></a></li>
                <li><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
            </ul>
        </div>
        <!-- /sidebar -->
        <!-- main right col -->
        <div class="column col-sm-10 col-xs-11" id="main">
            <!-- top nav -->
            <? include('navbar_header.php'); ?>
            <!-- /top nav -->
            <div class="full-actu col-sm-12">
                <!-- content -->
                <div class="row">
                    <!-- Contenu du template -->
                    <div id='calendar'></div>
                    <!-- Fin contenu template -->
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
                        <div id="files" class="files"></div>
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
<script src='./js/moment.min.js'></script>
<script src='./js/fullcalendar.min.js'></script>

<script src="./js/fileupload/vendor/jquery.ui.widget.js"></script>
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="./js/fileupload/jquery.iframe-transport.js"></script>
<script src="./js/fileupload/jquery.fileupload.js"></script>
<script src="./js/fileupload/jquery.fileupload-process.js"></script>
<script src="./js/fileupload/jquery.fileupload-image.js"></script>
<script src="./js/fileupload/jquery.fileupload-audio.js"></script>
<script src="./js/fileupload/jquery.fileupload-video.js"></script>
<script src="./js/fileupload/jquery.fileupload-validate.js"></script>
<script type='text/javascript' src='./js/gcal.js'></script>
<script>
    $('.new_btn').on("click", function () {
        $('#file').click();
    });

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
        $('#file').fileupload({
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

    $(document).ready(function () {
        $('#calendar').fullCalendar({
            events: {
                url: '/projets/tweevent/api/q/req.php',
                type: 'POST',
                data: {
                    action: "Utilisateur_Calendrier_SELECT_ALL",
                    utilisateur_id: "<?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>"
                },
                success: function (msg) {
                    console.log(msg);
                },
                error: function (msg) {
                    console.log(msg);
                    alert('there was an error while fetching events!');
                }
            }
        });
    });
</script>
</body>
</html>