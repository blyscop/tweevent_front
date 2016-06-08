<script src="./js/jquery-1.10.2.js"></script>
<script>
    var $j = jQuery.noConflict();
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
    function connexion()
    {
      var exec = true;
      if (document.frm_connexion.username == "" || document.frm_connexion.password == "") {
        exec = false;
      }
      return exec;
    }
    function isInt(value)
    {
      return !isNaN(value) && 
      parseInt(Number(value)) == value && 
      !isNaN(parseInt(value, 10));
    }
    function isValidCP(cp)
    {
      console.log(cp);
      if (isInt(cp))
      {
        return /^\d{5}(-\d{4})?$/.test(cp);
      }
      else
      {
        return false;
      }
    }
    function verifier_formulaire()
    {
      var msg = "";
      var msg_intro = "Merci de vérifier les champs suivants : \n";
      if($j("#choix_inscription").val() == "par")
      {
                //Verif pseudo
                if($j("#pseudo").val().length < 3 || $j("#pseudo").val().length>35) {
                  msg += "- Pseudo (Doit être compris entre 3 et 35 caracteres)\n";
                  $j("#pseudo").css("background-color", "#FF0000");
                }
                else
                {
                  $j("#pseudo").css("background-color", "");
                }
                //Verif password
                if($j("#password").val().length < 5 || $j("#password").val().length > 25) {
                  msg += "- Mot de passe (Doit être compris entre 5 et 25 caracteres) \n";
                  $j("#password").css("background-color", "#FF0000");
                }
                else
                {
                  $j("#password").css("background-color", "");
                }
              }
              else {
              // Vérif du formulaire pour les pro

              //Verif pseudo
              if($j("#pseudo").val().length < 3 || $j("#pseudo").val().length>35) {
                msg += "- Pseudo (Doit être compris entre 3 et 35 caracteres)\n";
                $j("#pseudo").css("background-color", "#FF0000");
              }
              else
              {
               $j("#pseudo").css("background-color", "");
             }

              //Verif ville
              if($j("#ville").val().length < 3 || $j("#ville").val().length>15) {
                msg += "- Ville (Doit être compris entre 3 et 15 caracteres)\n";
                $j("#ville").css("background-color", "#FF0000");
              }
              else
              {
               $j("#ville").css("background-color", "");
             }

              //Verif code postal
              if($j("#code_postal").val().length != 5 || !isValidCP($j("#code_postal").val())) {
                msg += "- Code postal incorrecte \n";
                $j("#code_postal").css("background-color", "#FF0000");
              }
              else
              {
               $j("#code_postal").css("background-color", "");
             }

              //Verif adresse
              if($j("#adresse").val().length < 7 || $j("#adresse").val().length>25) {
                msg += "- Adresse incorrecte\n";
                $j("#adresse").css("background-color", "#FF0000");
              }
              else
              {
               $j("#adresse").css("background-color", "");
             }

              //Verfi tel
              if($j("#tel").val().length != 10 || !isInt($j("#tel").val())) {
                msg += "- n°tel incorrecte \n";
                $j("#tel").css("background-color", "#FF0000");
              }
              else
              {
               $j("#tel").css("background-color", "");
             }

              //Verif mobile
              if($j("#mob").val().length != 10 || !isInt($j("#mob").val())) {
                msg += "- n°tel mobile incorrecte \n";
                $j("#mob").css("background-color", "#FF0000");
              }
              else
              {
               $j("#mob").css("background-color", "");
             }

              //Verif mail
              if($j("#mail").val().length < 3 || $j("#mail").val().length > 255) {
                msg += "- Mail invalide \n";
                $j("#mail").css("background-color", "#FF0000");
              }
              else
              {
               $j("#mail").css("background-color", "");
             }

              //Verif password
              if($j("#password").val().length < 5 || $j("#password").val().length > 25) {
                msg += "- Mot de passe (Doit être compris entre 5 et 25 caracteres) \n";
                $j("#password").css("background-color", "#FF0000");
              }
              else
              {
               $j("#password").css("background-color", "");
             }
           }

           if(msg == "") {
            return true;
          }
          else {
           alert(msg_intro + " \n" + msg);
           return false;
         }
       }

    function charger_bloc(nom_bloc)
    {
            // Initialisation et suivant le paramètre entrant, on charge le formulaire du bloc correspondant
            var html = "";
            if (nom_bloc == "pro") {
                // Chargement du formulaire d'inscription pour les pro.
                // Chargement du formulaire d'inscription pour les pro.
                // Pseudo
                html += "<div class='form-group'>";
                html += "<label for='pseudo' class='col-sm-3 control-label'>Nom de l'établissement :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='text' id='pseudo' name='pseudo' value=''/>";
                html += "</div>";
                html += "</div>";
                // ville
                html += "<div class='form-group'>";
                html += "<label for='ville' class='col-sm-3 control-label'>Ville :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='text' id='ville' name='ville' value=''/>";
                html += "</div>";
                html += "</div>";

                // Code postal
                html += "<div class='form-group'>";
                html += "<label for='code_postal' class='col-sm-3 control-label'>Code postal:</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='text' id='code_postal' name='code_postal' value=''/>";
                html += "</div>";
                html += "</div>";

                // Adresse
                html += "<div class='form-group'>";
                html += "<label for='adresse' class='col-sm-3 control-label'>Adresse :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='text' id='adresse' name='adresse' value=''/>";
                html += "</div>";
                html += "</div>";

                // Téléphone
                html += "<div class='form-group'>";
                html += "<label for='telephone' class='col-sm-3 control-label'>Téléphone :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='text' id='tel' name='tel' value=''/>";
                html += "</div>";
                html += "</div>";

                // Téléphone cellulaire
                html += "<div class='form-group'>";
                html += "<label for='cellulaire' class='col-sm-3 control-label'>Téléphone cellulaire :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='text' id='mob' name='mob' value=''/>";
                html += "</div>";
                html += "</div>";


                // Pseudo
                html += "<div class='form-group'>";
                html += "<label for='pseudo' class='col-sm-3 control-label'>Email :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='email' id='mail' name='mail' value=''/>";
                html += "</div>";
                html += "</div>";
                // Mot de passe
                html += "<div class='form-group'>";
                html += "<label for='password' class='col-sm-3 control-label'>Password :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='password' id='password' name='password' value=''/>";
                html += "</div>";
                html += "</div>";

                $j("#afficher_btn_retour").css("display", "block");
              }
              if (nom_bloc == "par") {
                // Chargement du formulaire d'inscription pour les par.
                // Pseudo
                html += "<div class='form-group'>";
                html += "<label for='pseudo' class='col-sm-3 control-label'>Email :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='email' id='pseudo' name='pseudo' value=''/>";
                html += "</div>";
                html += "</div>";

                // Mot de passe
                html += "<div class='form-group'>";
                html += "<label for='password' class='col-sm-3 control-label'>Password :</label>";
                html += "<div class='col-sm-4'>";
                html += "<input required class='form-control' type='password' id='password' name='password' value=''/>";
                html += "</div>";
                html += "</div>";

                $j("#afficher_btn_retour").css("display", "block");
              }
              if (nom_bloc == "choix")
              {
                $j("#afficher_btn_retour").css("display",  "none");
                html += "Vous êtes : <br/> <input id='pro' type='radio' name='choix_inscription' onclick='charger_bloc(this.id);' value='pro'><label for='pro'>Un professionnel</label>";
                html += "<input id='par' type='radio' name='choix_inscription' onclick='charger_bloc(this.id);' value='par'><label for='par'>Un particulier</label><br/><br/>";
              }

            // Remplissage html
            html += "<input type='hidden' name='choix_inscription' id='choix_inscription' value='" + nom_bloc + "'/>";
            $j("#content_inscription").empty();
            $j("#content_inscription").append(html+"<span style='color:Red;' id='form_error'></span>");
          }

    function mdp_oublie()
    {
            var email_saisi = $j("#email_oublie").val();

            $j.ajax({
              type: "GET",
              url: host + "/projets/tweevent/api/q/req.php",
              data: {action: "Utilisateur_Rein_Mdp", email: email_saisi},
              dataType: 'json',
              success: function (data) {
                if (data.confirmation) {
                  $j(location).attr('href',"http://martinfrouin.fr/projets/tweevent/index.html#email_envoye");
                  window.location.reload(true);
                }
                else {
                  $j(location).attr('href',"http://martinfrouin.fr/projets/tweevent/index.html#email_nnenvoye");
                  window.location.reload(true);
                }
              }
            });
          }
</script>