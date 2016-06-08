<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tweevent</title>
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="./css/jquery-ui.css">
  <script src="./js/jquery-1.10.2.js"></script>
  <script src="./js/jquery-ui.js"></script>
  <script src="./js/functions.js"></script>
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <?php include("functions_js.php"); ?>
      </head>
      <body class="">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="slide-nav">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="navbar-brand" href="index.html"><img width="180" src="./img/logo.png"></a>
            </div>
            <div id="slidemenu">
              <form class="navbar-form navbar-right" method="post" action="functions.php?action=connexion" name="frm_connexion">
                <div class="form-group">
                  <input type="text" id="connection_username" name="username" placeholder="Adresse email"
                  class="form-control">
                  <input type="password" id="connection_pwd" name="password" placeholder="Mot de passe"
                  class="form-control">
                </div>
                <button type="submit" id="connection_validation" class="btn btn-primary icon-user"
                onclick="return connexion()">Connexion
              </button>
              <button type="button" id="btn_mdp_oublie" class="btn btn-primary icon-user" >
                <a href="#mdp_oublie" role="button" data-toggle="modal" id="mdp_oublieBtn">Mdp oublié ? </a>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="inverse" id="navbar-height-col"></div>
      <div class="block_home center vcenter" style="height: 641px;">
        <div class="title_home inner">
          <h1>Bienvenue sur<br>Tweevent</h1>
          <div class="about">
            <h3><a href="#inscriptionModal" role="button" data-toggle="modal">S'inscrire</a></h3>
            <h3><a href="#errorModal" id="errorBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#errorModal2" id="errorBtn2" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#inscrOk" id="inscrBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#errorEmail" id="errorMailBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#emailNonValide" id="emailNonValideBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#erreurValidation" id="errorValidationBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#confValidation" id="confValidationBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#erreurCatpcha" id="erreurCatpchaBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#erreur_captchaNonSaisi" id="erreur_captchaNonSaisiBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#erreur_captchaRequete" id="erreur_captchaRequeteBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#reinit_ok" id="mdpReinitOkBtn" role="button" data-toggle="modal"></a></h3>
            <h3><a href="#reinit_ko" id="mdpReinitKoBtn" role="button" data-toggle="modal"></a></h3>
          </div>

        </div>
      </div>

      <script>
        window.onload = function () {
          if (window.jQuery) {
            $("#validationInscription").trigger("click");
          }
          if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            if (hash == "login_error") {
              $("#errorBtn").trigger("click");
            }

            else if (hash == "insc_error") {
              $("#errorBtn2").trigger("click");
            }
            else if (hash == "insc_ok") {
              $("#inscrBtn").trigger("click");
            }
            else if (hash == "email_error") {
              $("#errorMailBtn").trigger("click");
            }
            else if (hash == "email_invalide") {
              $("#emailNonValideBtn").trigger("click");
            }
            else if (hash == "erreur_validation") {
              $("#errorValidationBtn").trigger("click");
            }
            else if (hash == "conf_validation") {
              $("#confValidationBtn").trigger("click");
            }
            else if (hash == "erreur_captchaNonSaisi") {
              $("#erreurCatpchaBtn").trigger("click");
            }
            else if (hash == "erreur_captchaRequete") {
              $("#erreur_captchaRequeteBtn").trigger("click");
            }
            else if (hash == "email_envoye") {
              $("#mdpReinitOkBtn").trigger("click");
            }
            else if (hash == "email_nnenvoye") {
              $("#mdpReinitKoBtn").trigger("click");
            }

          } else {
            // No hash found
          }
        }
      </script><!-- Validation inscription modal -->

      <!--inscription modal-->
      <div id="inscriptionModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h5>Formulaire d'inscription</h5>
            </div>
            <div id="info_inscription">

            </div>
            <form class="form-horizontal" id="register_form" name="frm_ajout_utilisateur"
            action="functions.php?action=inscription" method="post" onsubmit="return verifier_formulaire();">
            <!-- Chargement conditionnel du formulaire d'inscription en AJAX -->
            <div id="content_inscription" class="form-group modal-body">
              Vous êtes : <br/>
              <div class="col-xs-12">
                <input type="radio" id="pro" name="choix_inscription" onclick="charger_bloc(this.id);" value="pro"/><label for="pro">Un professionnel</label>
              </div>
              <div class="col-xs-12">

                <input type="radio" id="par" name="choix_inscription" onclick="charger_bloc(this.id);" value="par"/><label for="par">Un particulier</label> <br/>
              </div>
            </div>
            <div class="g-recaptcha" data-sitekey="6LcDniETAAAAAFiX24Mw5sHqL2j0IqGJFGXqWkB0" style ="text-align: -moz-center;"></div>
            <div class="modal-footer">
              <div>
                <div id="afficher_btn_retour" style="display: none;text-align: left;" class="col-md-1" >
                  <input class="btn btn-default" type="button" onclick="charger_bloc('choix');" name="chk"
                  value="Retour" />
                </div>
                <div>
                  <input class="btn btn-default" type="submit" name="chk" value="Valider"/>
                </div>
                
              </div>
              
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--error modal-->
    <div>
      <div id="errorModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h5>Oups, une erruer est survenue. Merci de vérifier les données renseignées.(</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div id="errorModal2" class="modal fade" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h5>Oups, cet email est déjà utilisé, merci d'en saisir un autre.</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div id="inscrOk" class="modal fade" tabindex="-3" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h5>Votre compte a bien été créer et nous sommes heureux de vous accueilir ! Mais avant de commencer
                notre histoire, merci de valider votre adresse email en cliquant sur le lien reçu.</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div id="errorEmail" class="modal fade" tabindex="-4" role="dialog" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5>Une erreur est survenue lors de l'envoi de l'email de confirmation, et nous sommes désolés pour
                  ce gêne.</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="emailNonValide" class="modal fade" tabindex="-5" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Merci de valider votre email pour pouvoir vous connecter.</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="erreurValidation" class="modal fade" tabindex="-6" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>La clé saisie n'est pas correcte.</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="erreurCatpcha" class="modal fade" tabindex="-7" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Merci d'approuver le captcha !</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="erreur_captchaNonSaisi" class="modal fade" tabindex="-8" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Merci de valider que vous n'êtes pas un robot grâce au Re-Captcha de Google !</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="erreur_captchaRequete" class="modal fade" tabindex="-9" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Merci de valider que vous n'êtes pas un robot grâce au Re-Captcha de Google !</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="confValidation" class="modal fade" tabindex="-10" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Merci d'avoir validé votre email ! Vous pouvez désormais vous connecter</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="mdp_oublie" class="modal fade" tabindex="-11" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Merci de saisir votre email :</h5>
                  <div class='form-group'>
                    <input required class="form-control" type="email" id="email_oublie" name="email_oublie" value=""/> <br/>
                    <button type="submit" id="mdp_oublie_btn" onclick="mdp_oublie();" class="btn btn-primary icon-user" >Envoyer</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="reinit_ok" class="modal fade" tabindex="-12" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Votre mot de passe a bien été réinitialisé ! Merci de cliquer sur le lien dans l-email reçu afin de procéder au changement de mot de passe.</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div id="reinit_ko" class="modal fade" tabindex="-13" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5>Une erreur est survenue ! Est-ce que l'email saisi correspond bien à votre compte ?</h5>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script src="./js/jquery.min.js"></script>
        <script src="./js/scripts.js"></script>
        <!-- fin modal-->

        <!-- Scripts -->

        <!-- Scripts -->
        <script src="./js/jquery.min(1).js"></script>
        <script src="./js/bootstrap.min.js"></script> <!-- mal inclus -->
        <script src="js/md5.min.js"></script>
        <script type="text/javascript">

          $(document).ready(function () {
        //stick in the fixed 100% height behind the navbar but don't wrap it
        $('#slide-nav.navbar-inverse').after($('<div class="inverse" id="navbar-height-col"></div>'));

        $('#slide-nav.navbar-default').after($('<div id="navbar-height-col"></div>'));

        // Enter your ids or classes
        var toggler = '.navbar-toggle';
        var pagewrapper = '#page-content';
        var navigationwrapper = '.navbar-header';
        var menuwidth = '100%'; // the menu inside the slide menu itself
        var slidewidth = '80%';
        var menuneg = '-100%';
        var slideneg = '-80%';

        $("#slide-nav").on("click", toggler, function (e) {
          var selected = $(this).hasClass('slide-active');

          $('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
          });

          $('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
          });

          $(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
          });

          $(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
          });
          $(this).toggleClass('slide-active', !selected);
          $('#slidemenu').toggleClass('slide-active');
          $('#page-content, .navbar, body, .navbar-header').toggleClass('slide-active');
        });
        var selected = '#slidemenu, #page-content, body, .navbar, .navbar-header';
        $(function () {
          $(window).resize(function () {
            $('.block_home').height($(window).height() - $('.block_home').offset().top);
          });
          $(window).resize();

          $(window).on("resize", function () {
            if ($(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
              $(selected).removeClass('slide-active');
            }
          });
        });
      });
    </script>

  </body>
  </html>
