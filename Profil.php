<? include("functions.php");
check_session(); ?>
<!DOCTYPE html>
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
    <?php include("functions_js.php"); ?>
</head>
<body onload="charger_bloc_pro('<?= $_COOKIE['utilisateur_type']; ?>');">
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
                            <h1>Bonjour <?= ucfirst($_COOKIE['username']); ?></h1>
                        </header>
                        <section id="cd-timeline" class="cd-container">
                            <div class="cd-timeline-block">
                                <h1 id="infos_mdp_upd">Modifier votre mot de passe</h1>
                                <label for="old_password">Ancien mot de passe :<br/>
                                    <input type="password" name="old_password" id="old_password"/></label><br/>
                                <label for="old_password">Nouveau mot de passe :<br/>
                                    <input type="password" name="new_password" id="new_password"/></label><br/>
                                <label for="old_password">Confirmation nouveau mot de passe :<br/>
                                    <input type="password" name="new_password_conf"
                                           id="new_password_conf"/></label><br/>
                                <input type="button" name="modifier" id="modifier" onclick="changer_password();"
                                       value="Modifier"/>
                            </div>
                        </section> <!-- cd-timeline -->

                        <form class="form-horizontal" id="register_form" name="frm_ajout_utilisateur"
                              action="functions.php?action=inscription" method="post" onsubmit="return verifier_formulaire();">
                            <div id="content_inscription_maj"  class="form-group modal-body">

                            </div>
                            </form>


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
</body>
</html>