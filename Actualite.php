<?php session_start(); ?>
<!DOCTYPE html>
<!-- saved from url=(0041)http://localhost/projeti4Save/actions.php -->
<html class="no-js">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Tweevent - A Social Network</title>
  <meta name="generator" content="Bootply" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link href="./css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
  <link href="./css/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/timelinestyle.css">
  <script src="js/functions.js"></script>
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

    </head>
    <body>
      <script>
//        window.onload = function() {
//            getPreferencesTypes("music");
//            getPreferencesTypes("drink");
//            getPreferencesTypes("food");
//        }
      </script>
      <div class="wrapper">
        <div class="box">
          <div class="row row-offcanvas row-offcanvas-left">
            <!-- sidebar -->
            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">
             <ul class="nav">
               <li>
                 <a href="http://localhost/projeti4Save/actions.php#" data-toggle="offcanvas" class="visible-xs text-center">
                   <i class="glyphicon glyphicon-chevron-right"></i>
                 </a>
               </li>
             </ul>
             <ul class="nav hidden-xs" id="lg-menu">
              <li class="active">
                <a href="http://localhost/projeti4Save/actions.php#preferenceModal" role="button" data-toggle="modal">
                  <i class="glyphicon glyphicon-list-alt"></i>
                  Préferences
                </a>
              </li>
              <li>
                <a href="./Calendrier.html">
                  <i class="glyphicon glyphicon-list"></i>
                  Calendrier
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
              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
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
                  <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
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
                  <a href="http://localhost/projeti4Save/actions.php#postModal" role="button" data-toggle="modal">
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
                  <a href="http://localhost/projeti4Save/actions.php#" class="dropdown-toggle" data-toggle="dropdown">
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



              <header>
                <img class="bloc-round" src="./img/profilpic.jpg"/>
                <h1>Bonjour <?php echo $_SESSION['username']; ?></h1>
              </header>
              <section id="cd-timeline" class="cd-container">
                <div class="cd-timeline-block">
                  <div class="cd-timeline-img cd-picture">
                    <img src="./img/cd-icon-picture.svg" alt="Picture">
                  </div> <!-- cd-timeline-img -->

                  <div class="cd-timeline-content">
                    <h2>Title of section 1</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>
                    <a href="#0" class="cd-read-more">Read more</a>
                    <span class="cd-date">Jan 14</span>
                  </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                  <div class="cd-timeline-img cd-movie">
                    <img src="./img/cd-icon-movie.svg" alt="Movie">
                  </div> <!-- cd-timeline-img -->

                  <div class="cd-timeline-content">
                    <h2>Title of section 2</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde?</p>
                    <a href="#0" class="cd-read-more">Read more</a>
                    <span class="cd-date">Jan 18</span>
                  </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                  <div class="cd-timeline-img cd-picture">
                    <img src="./img/cd-icon-picture.svg" alt="Picture">
                  </div> <!-- cd-timeline-img -->

                  <div class="cd-timeline-content">
                    <h2>Title of section 3</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, obcaecati, quisquam id molestias eaque asperiores voluptatibus cupiditate error assumenda delectus odit similique earum voluptatem doloremque dolorem ipsam quae rerum quis. Odit, itaque, deserunt corporis vero ipsum nisi eius odio natus ullam provident pariatur temporibus quia eos repellat consequuntur perferendis enim amet quae quasi repudiandae sed quod veniam dolore possimus rem voluptatum eveniet eligendi quis fugiat aliquam sunt similique aut adipisci.</p>
                    <a href="#0" class="cd-read-more">Read more</a>
                    <span class="cd-date">Jan 24</span>
                  </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                  <div class="cd-timeline-img cd-location">
                    <img src="./img/cd-icon-location.svg" alt="Location">
                  </div> <!-- cd-timeline-img -->

                  <div class="cd-timeline-content">
                    <h2>Title of section 4</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>
                    <a href="#0" class="cd-read-more">Read more</a>
                    <span class="cd-date">Feb 14</span>
                  </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                  <div class="cd-timeline-img cd-location">
                    <img src="./img/cd-icon-location.svg" alt="Location">
                  </div> <!-- cd-timeline-img -->

                  <div class="cd-timeline-content">
                    <h2>Title of section 5</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum.</p>
                    <a href="#0" class="cd-read-more">Read more</a>
                    <span class="cd-date">Feb 18</span>
                  </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                  <div class="cd-timeline-img cd-movie">
                    <img src="./img/cd-icon-movie.svg" alt="Movie">
                  </div> <!-- cd-timeline-img -->

                  <div class="cd-timeline-content">
                    <h2>Final Section</h2>
                    <p>This is the content of the last section</p>
                    <span class="cd-date">Feb 26</span>
                  </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
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
            <div class="modal-header">
              <button type="button" id="close_post_area" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              Update Status
            </div>
              <div class="modal-body">
          <!--<form class="form center-block">
            <div class="form-group">

              <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
            </div>
          </form>-->
          <script>
            window.onload = function() {
//                $('#post_area').change(function(){
//                    try{
//                        $.ajax({
//                              url: $('#post_area').val(),
//                              complete: function(data) {
//                                alert(data.responseText);
//                              }
//                        });
//                    }
//                    catch (e)
//                    {
//                    }
//                    try{
//                        var r = /:\/\/(.[^/]+)/;
//                        var infos =  $('#post_area').val().match(r)[1];
//                        console.log(infos);
//                    }
//                    catch (e)
//                    {
//                    }
//                });
                
            }
          </script>
          <div class="form-group">
            <textarea id="post_area" class="form-control input-lg" name="post" autofocus="" placeholder="What do you want to share?"></textarea>
          </div>
          <input type="hidden" name="action" value="Publier_Statut" />
        </div>
        <div class="modal-footer">
          <div>
            <button type="submit"  onclick="send_post();" class="btn btn-primary">Publier</button>
            <ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
          </div>	
        </div>
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
          <div id="musicPreferences" class="col-md-4">
            <i class="fa fa-music fa-4x" aria-hidden="true"></i>
          </div>
          <div id="drinkPreferences" class="col-md-4">
            <i class="fa fa-glass fa-4x" aria-hidden="true"></i>
          </div>
          <div id="foodPreferences" class="col-md-4">
            <i class="fa fa-glass fa-4x" aria-hidden="true"></i>
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
  <input type="hidden" value="<?php echo $_SESSION['id_utilisateur']; ?>" id="id_utilisateur" />
</body>
</html>