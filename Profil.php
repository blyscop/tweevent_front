<?php include("functions.php");
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
    <script type="text/javascript">
        var $j = jQuery.noConflict();

        function changer_password() {
            var msg = "";
            var msg_intro = "Champs requis : \n";
            if ($j("#old_password").val() == "") {
                msg += "- Ancien mot de passe \n";
                $j("#old_password").css("background-color", "#FF0000");
            }
            else
                $j("#old_password").css("background-color", "");

            if ($j("#new_password").val() == "") {
                msg += "- Nouveau mot de passe \n";
                $j("#new_password").css("background-color", "#FF0000");
            }
            else
                $j("#new_password").css("background-color", "");

            if ($j("#new_password_conf").val() == "") {
                msg += "- Confirmation nouveau mot de passe \n";
                $j("#new_password_conf").css("background-color", "#FF0000");
            }
            else
                $j("#new_password_conf").css("background-color", "");

            if ($j("#new_password").val() != $j("#new_password_conf").val()) {
                msg += "- Les 2 nouveaux mot de passe doivent correspondre. \n";
                $j("#new_password").css("background-color", "#FF0000");
                $j("#new_password_conf").css("background-color", "#FF0000");
            }
            else {
                $j("#new_password_conf").css("background-color", "");
                $j("#new_password").css("background-color", "");
            }

            if($j("#old_password").val() == $j("#new_password").val() ) {
                msg += "- Merci de choisir un nouveau mot de passe différent de votre ancien \n";
            }

            if (msg == "") {
                // Modification du mot de passe avec les 3 champs saisis
                var id_user = <?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>;
                $j.ajax({
                    type: "GET",
                    url: host + "/projets/tweevent/api/q/req.php",
                    data: {action: "Utilisateur_Changer_Mdp", id_utilisateur: id_user, old_password: $j("#old_password").val(), new_password: $j("#new_password").val()},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if (data.confirmation) {
                            $j("#infos_mdp_upd").html("<h1>" + data.message + "</h1>");
                        }
                        else {
                            $j("#infos_mdp_upd").html("<h1>" + data.message+ "</h1>");
                        }
                    }
                });
            }
            else {
                alert(msg_intro + msg);
            }
        }
    </script>
</head>
<body>
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


                    </div><!--/row-->
                    <div><!--colsm9-content-->
                    </div>
                    <!-- /main -->
                </div>
            </div>
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
</body>
</html>