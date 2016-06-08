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

        function changer_password()
        {
            alert("rentre");
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

            if (msg == "") {
                // Modification du mot de passe

            }
            else {
                alert(msg_intro + msg);
                return false;
            }
        }
    </script>
</head>
<body>
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
                        <a href="#" role="button"
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
                    <li>
                        <a id="addEvent" href="#" data-toggle="modal" data-target=".addEvent">
                            <i class="glyphicon glyphicon-paperclip"></i>
                            Ajouter Evenement
                        </a>
                    </li>
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
                        <a href="#" role="button"
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
                                <h1>Modifier votre mot de passe</h1>
                                <form name="changer_mdp" id="changer_mdp" onsubmit="changer_password();">
                                    <label for="old_password">Ancien mot de passe :</label>
                                    <input type="password" name="old_password" id="old_password"/><br/>
                                    <label for="old_password">Nouveau mot de passe :</label>
                                    <input type="password" name="new_password" id="new_password"/><br/>
                                    <label for="old_password">Confirmation nouveau mot de passe :</label>
                                    <input type="password" name="new_password_conf" id="new_password_conf"/><br/>
                                    <input type="submit" name="modifier" id="modifier" value="Modifier"/>
                                </form>
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