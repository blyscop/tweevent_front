<? session_start(); include("functions.php"); check_session(); ?>
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
<body>
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
                    <li class="active">
                        <a href="http://localhost/projeti4Save/actions.php#preferenceModal" role="button"
                           data-toggle="modal">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            Préferences
                        </a>
                    </li>
                    <li>
                        <a href="Calendrier.php">
                            <i class="glyphicon glyphicon-list"></i>
                            Stories
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#">
                            <i class="glyphicon glyphicon-paperclip"></i>
                            Saved
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
                        <a href="http://localhost/projeti4Save/actions.php#featured" class="text-center">
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#stories" class="text-center">
                            <i class="glyphicon glyphicon-list"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#" class="text-center">
                            <i class="glyphicon glyphicon-paperclip"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/projeti4Save/actions.php#" class="text-center">
                            <i class="glyphicon glyphicon-refresh"></i>
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
                                <a href="Actualite.html">
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
                                    &nbsp;&nbsp;&nbsp;
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Mon profil</a></li>
                                    <li><a href="">Déconnexion</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
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
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        Update Status
                    </div>
                    <form class="form center-block" method="post" action="http://localhost/projeti4Save/actions.php">
                        <div class="modal-body">
                            <!--<form class="form center-block">
                              <div class="form-group">

                                <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
                              </div>
                            </form>-->
                            <div class="form-group">
                                <textarea class="form-control input-lg" name="post" autofocus=""
                                          placeholder="What do you want to share?"></textarea>
                            </div>
                            <input type="hidden" name="action" value="Publier_Statut"/>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary">Publier</button>
                                <ul class="pull-left list-inline">
                                    <li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li>
                                    <li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li>
                                    <li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li>
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
                    <div class="col-md-4">
                        <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                        <div><input type="checkbox"/> Rock</div>
                        <div><input type="checkbox"/> Techno/House</div>
                        <div><input type="checkbox"/> Rap</div>
                        <div><input type="checkbox"/> Pop</div>
                        <div><input type="checkbox"/> Reggae/Dancehall</div>
                        <div><input type="checkbox"/> Variétés</div>
                        <div><input type="checkbox"/> Jazz</div>
                    </div>
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
                    <div class="col-md-4">
                        <i class="fa fa-cutlery fa-4x" aria-hidden="true"></i>
                        <table class="table borderless">
                            <div><input type="checkbox"/> Tapas</div>
                            <div><input type="checkbox"/> Burger</div>
                            <div><input type="checkbox"/> Crêperie</div>
                            <div><input type="checkbox"/> Régional</div>
                            <div><input type="checkbox"/> Asiatique</div>
                            <div><input type="checkbox"/> Pizzeria</div>
                            <div><input type="checkbox"/> Gastronome</div>
                            <br><br><input type="button" value="Envoyer" class="btn btn-default btn-preference"
                                           style="float: right"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script references -->

<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/scripts.js"></script>
<script src='./js/moment.min.js'></script>
<script src='./js/fullcalendar.min.js'></script>
<script type='text/javascript' src='./js/gcal.js'></script>
<script type="text/javascript">
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
                error: function(msg) {
                    console.log(msg);
                    alert('there was an error while fetching events!');
                }
            }
    });
});
</script>
</body>
</html>