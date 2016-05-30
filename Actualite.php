<?php include("functions.php"); check_session(); ?>
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
        window.onload = function() {
            ReceiptPost();
        }
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
        <li>
          <a href="http://localhost/projeti4Save/actions.php#preferenceModal" role="button" data-toggle="modal">
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
          <h1>Bonjour <?php echo ucfirst($_SESSION['username']); ?></h1>
        </header>
        <section id="cd-timeline" class="cd-container">

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
<input type="hidden" value="<?php echo $_SESSION['utilisateur_id']; ?>" id="id_utilisateur" />
</body>
</html>
