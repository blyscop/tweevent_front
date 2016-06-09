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
    <!-- Style personnalisé pour afficher plus de texte dans le calendrier -->
    <style>
        .fc-time{
            display : none;
        }
    </style>
    <? include("functions_js.php"); ?>

    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body onload="charger_preferences_utilisateur(); charger_preferences_utilisateur_ajout_event(); ">
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
            <!--            INCLURE LE NAVBAR_LEFT ICI-->
            <? include("navbar_left.php"); ?>

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
        <? include('popups.php'); ?>
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
            },
            color: 'yellow',
            textColor: 'black'
        });
    });
</script>
</body>
</html>