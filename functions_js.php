<script src="./js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="./js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="./js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="./js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript" src="./js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

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
    function charger_preferences_utilisateur_ajout_event() {
        $j.ajax({
            type: "GET",
            url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_Preferences_SELECT_ALL&id_utilisateur=<?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>",
            dataType: 'json',
            success: function (data) {
                var html = "";
                $j('#preferences_categories_event').empty();
                $j.each(data, function (categorie, objet_preference) {
                    var class_tag_i = "";
                    if (categorie != "music")
                        class_tag_i = "glass";
                    else
                        class_tag_i = categorie;
                    html += "<div id='" + categorie + "Preferences' class='col-md-4'> <i class='fa fa-" + class_tag_i + " fa-4x' aria-hidden='true'></i>";
                    $j.each(objet_preference, function (preference, droit) {
                        html += "<div><input type='checkbox' class='preferences_event' id='" + preference + "' name='" + preference + "'>" + preference + "</input></div>";
                    });
                    html += "</div>";
                });
                html += "<table class='table borderles'></table>";
                $j('#preferences_categories_event').append(html);
            }
        });
    }

    function connexion() {
        var exec = true;
        if (document.frm_connexion.username == "" || document.frm_connexion.password == "") {
            exec = false;
        }
        return exec;
    }
    function isInt(value) {
        return !isNaN(value) &&
            parseInt(Number(value)) == value && !isNaN(parseInt(value, 10));
    }
    function isValidCP(cp) {
        console.log(cp);
        if (isInt(cp)) {
            return /^\d{5}(-\d{4})?$/.test(cp);
        }
        else {
            return false;
        }
    }
    function verifier_formulaire() {
        var msg = "";
        var msg_intro = "Merci de vérifier les champs suivants : \n";
        if ($j("#choix_inscription").val() == "par") {
            //Verif pseudo
            if ($j("#pseudo").val().length < 3 || $j("#pseudo").val().length > 35) {
                msg += "- Nom (Doit être compris entre 3 et 35 caracteres)\n";
                $j("#pseudo").css("background-color", "#FF0000");
            }
            else {
                $j("#pseudo").css("background-color", "");
            }
            //Verif email
            if ($j("#email").val().length < 3 || $j("#email").val().length > 35) {
                msg += "- Email (Doit être compris entre 3 et 35 caracteres)\n";
                $j("#email").css("background-color", "#FF0000");
            }
            else {
                $j("#email").css("background-color", "");
            }
            //Verif password
            if ($j("#password").val().length < 5 || $j("#password").val().length > 25) {
                msg += "- Mot de passe (Doit être compris entre 5 et 25 caracteres) \n";
                $j("#password").css("background-color", "#FF0000");
            }
            else {
                $j("#password").css("background-color", "");
            }
        }
        else {
            // Vérif du formulaire pour les pro

            //Verif pseudo
            if ($j("#nom").val().length < 3 || $j("#nom").val().length > 35) {
                msg += "- Le nom (Doit être compris entre 3 et 35 caracteres)\n";
                $j("#nom").css("background-color", "#FF0000");
            }
            else {
                $j("#nom").css("background-color", "");
            }

            //Verif ville
            if ($j("#ville").val().length < 3 || $j("#ville").val().length > 15) {
                msg += "- Ville (Doit être compris entre 3 et 15 caracteres)\n";
                $j("#ville").css("background-color", "#FF0000");
            }
            else {
                $j("#ville").css("background-color", "");
            }

            //Verif code postal
            if ($j("#code_postal").val().length != 5 || !isValidCP($j("#code_postal").val())) {
                msg += "- Code postal incorrecte \n";
                $j("#code_postal").css("background-color", "#FF0000");
            }
            else {
                $j("#code_postal").css("background-color", "");
            }

            //Verif adresse
            if ($j("#adresse").val().length < 7 || $j("#adresse").val().length > 25) {
                msg += "- Adresse incorrecte\n";
                $j("#adresse").css("background-color", "#FF0000");
            }
            else {
                $j("#adresse").css("background-color", "");
            }

            //Verfi tel
            if ($j("#tel").val().length != 10 || !isInt($j("#tel").val())) {
                msg += "- n°tel incorrecte \n";
                $j("#tel").css("background-color", "#FF0000");
            }
            else {
                $j("#tel").css("background-color", "");
            }

            //Verif mobile
            if ($j("#mob").val().length != 10 || !isInt($j("#mob").val())) {
                msg += "- n°tel mobile incorrecte \n";
                $j("#mob").css("background-color", "#FF0000");
            }
            else {
                $j("#mob").css("background-color", "");
            }

            //Verif siret
            if ($j("#siret").val().length != 14 || !isInt($j("#siret").val())) {
                msg += "- Le code siret est incorrect \n";
                $j("#siret").css("background-color", "#FF0000");
            }
            else {
                $j("#siret").css("background-color", "");
            }

            //Verif mail
            if ($j("#mail").val().length < 3 || $j("#mail").val().length > 255) {
                msg += "- Mail invalide \n";
                $j("#mail").css("background-color", "#FF0000");
            }
            else {
                $j("#mail").css("background-color", "");
            }

            //Verif password
            if ($j("#password").val().length < 5 || $j("#password").val().length > 25) {
                msg += "- Mot de passe (Doit être compris entre 5 et 25 caracteres) \n";
                $j("#password").css("background-color", "#FF0000");
            }
            else {
                $j("#password").css("background-color", "");
            }
        }

        if (msg == "") {
            return true;
        }
        else {
            alert(msg_intro + " \n" + msg);
            return false;
        }
    }

    function charger_bloc(nom_bloc) {
        // Initialisation et suivant le paramètre entrant, on charge le formulaire du bloc correspondant
        var html = "";
        if (nom_bloc == "pro") {
            // Chargement du formulaire d'inscription pour les pro.
            // Nom
            html += "<div class='form-group'>";
            html += "<label for='nom' class='col-sm-3 control-label'>Nom de l'établissement :</label>";
            html += "<div class='col-sm-4'>";
            html += "<input required class='form-control' type='text' id='nom' name='nom' value=''/>";
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

            // SIRET
            html += "<div class='form-group'>";
            html += "<label for='siret' class='col-sm-3 control-label'>Code siret :</label>";
            html += "<div class='col-sm-4'>";
            html += "<input required class='form-control' type='text' id='siret' name='siret' value=''/>";
            html += "</div>";
            html += "</div>";


            // Pseudo
            html += "<div class='form-group'>";
            html += "<label for='email' class='col-sm-3 control-label'>Email :</label>";
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
            html += "<label for='pseudo' class='col-sm-3 control-label'>Nom :</label>";
            html += "<div class='col-sm-4'>";
            html += "<input required class='form-control' type='text' id='pseudo' name='pseudo' value=''/>";
            html += "</div>";
            html += "</div>";

            html += "<div class='form-group'>";
            html += "<label for='email' class='col-sm-3 control-label'>Email :</label>";
            html += "<div class='col-sm-4'>";
            html += "<input required class='form-control' type='email' id='email' name='email' value=''/>";
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
        if (nom_bloc == "choix") {
            $j("#afficher_btn_retour").css("display", "none");
            html += "Vous êtes : <br/> <input id='pro' type='radio' name='choix_inscription' onclick='charger_bloc(this.id);' value='pro'><label for='pro'>Un professionnel</label>";
            html += "<input id='par' type='radio' name='choix_inscription' onclick='charger_bloc(this.id);' value='par'><label for='par'>Un particulier</label><br/><br/>";
        }

        // Remplissage html
        html += "<input type='hidden' name='choix_inscription' id='choix_inscription' value='" + nom_bloc + "'/>";
        $j("#content_inscription").empty();
        $j("#content_inscription").append(html + "<span style='color:Red;' id='form_error'></span>");
    }

    function charger_bloc_modif_profil(nom_bloc, id_utilisateur) {
        // Initialisation et suivant le paramètre entrant, on charge le formulaire de modif du bloc correspondant
        var html = "";

        $j.ajax({
            type: "GET",
            url: host + "/projets/tweevent/api/q/req.php",
            data: {action: "Utilisateur_GET", id_utilisateur: id_utilisateur},
            dataType: 'json',
            success: function (data) {
                var nom = data.utilisateur.nom_tweevent_user;
                var pseudo = data.utilisateur.pseudo_tweevent_user;
                var email = data.utilisateur.email_tweevent_user;
                var ville = data.utilisateur.ville_tweevent_user;
                var code_postal = data.utilisateur.code_postal_tweevent_user;
                var adresse = data.utilisateur.adresse_1_tweevent_user;
                var tel = data.utilisateur.tel_tweevent_user;
                var mob = data.utilisateur.mob_tweevent_user;
                var siret = data.utilisateur.siret;

                if (nom_bloc == "pro") {
                    // Chargement du formulaire d'upd (mon profil) pour les pro.
                    // Pseudo
                    html += "<label for='pseudo'>Nom :<br />";
                    html += "<input required type='text' id='pseudo' name='pseudo' value='" + pseudo + "'/>";
                    html += "</label><br />";

                    html += "<label for='email' >Email :<br />";
                    html += "<input required type='email' id='email' name='email' value='" + email + "'/>";
                    html += "</label><br />";

                    // ville
                    html += "<label for='ville'>Ville :<br />";
                    html += "<input required type='text' id='ville' name='ville' value='" + ville + "'/>";
                    html += "</label><br />";

                    // Code postal
                    html += "<label for='code_postal'>Code postal:<br />";
                    html += "<input required type='text' id='code_postal' name='code_postal' value='" + code_postal + "'/>";
                    html += "</label><br />";

                    // Adresse
                    html += "<label for='adresse'>Adresse :<br />";
                    html += "<input required type='text' id='adresse' name='adresse' value='" + adresse + "'/>";
                    html += "</label><br />";

                    // Téléphone
                    html += "<label for='telephone'>Téléphone :<br />";
                    html += "<input required type='text' id='tel' name='tel' value='" + tel + "'/>";
                    html += "</label><br />";

                    // Téléphone cellulaire
                    html += "<label for='cellulaire'>Téléphone cellulaire :<br />";
                    html += "<input required type='text' id='mob' name='mob' value='" + mob + "'/>";
                    html += "</label><br />";

                    // SIRET
                    html += "<label for='siret'>Code siret :<br />";
                    html += "<input required type='text' id='siret' name='siret' value='" + siret + "'/>";
                    html += "</label><br />";


                    $j("#afficher_btn_retour").css("display", "block");
                }
                if (nom_bloc == "par") {
                    // Chargement du formulaire d'upd (mon profil) pour les par.
                    // Nom
                    html += "<label for='pseudo'>Nom :<br />";
                    html += "<input required type='text' id='pseudo' name='pseudo' value='" + pseudo + "'/>";
                    html += "</label><br />";

                    // Pseudo
                    html += "<label for='pseudo'>Email :<br />";
                    html += "<input required type='email' id='email' name='email' value='" + email + "'/>";
                    html += "</label><br />";

                    html += "<label for='email' >Email :<br />";
                    html += "<input required type='email' id='email' name='email' value='" + email + "'/>";
                    html += "</label><br />";

                    $j("#afficher_btn_retour").css("display", "block");
                }


                // Remplissage html
                html += "<input type='hidden' name='choix_inscription' id='choix_inscription' value='" + nom_bloc + "'/>";
                $j("#content_inscription_maj").empty();
                $j("#content_inscription_maj").append(html + "<span style='color:Red;' id='form_error'></span>");
            }
        });
    }

    function modifier_infos_utilisateur() {
        alert("btn");
    }
    function mdp_oublie() {
        var email_saisi = $j("#email_oublie").val();

        $j.ajax({
            type: "GET",
            url: host + "/projets/tweevent/api/q/req.php",
            data: {action: "Utilisateur_Rein_Mdp", email: email_saisi},
            dataType: 'json',
            success: function (data) {
                if (data.confirmation) {
                    $j(location).attr('href', "http://martinfrouin.fr/projets/tweevent/index.html#email_envoye");
                    window.location.reload(true);
                }
                else {
                    $j(location).attr('href', "http://martinfrouin.fr/projets/tweevent/index.html#email_nnenvoye");
                    window.location.reload(true);
                }
            }
        });
    }
    // Modification des préférences de l'utilisateur, on requête le serveur d'API avec les cases cochées et il va nous répondre s'il a bien traiter notre demande (pour afficher un message à l'user)
    // Il faut penser à recharger le bloc en réappelant la fonction après l'UPD (s'il s'est bien déroulé)
    function modifier_preferences_utilisateur(params) {
        var preferences_cochees = "";
        var id_utilisateur = <?=$_COOKIE["utilisateur_id"] > 0 ? $_COOKIE["utilisateur_id"] : 0 ?> ;
        $j('.preferences').each(function () {
            var est_cochee = (this.checked ? "1" : "0");
            preferences_cochees += (preferences_cochees == "" ? est_cochee + "_" + this.name : "|" + est_cochee + "_" + this.name);
        });
        // Liste sous la forme 1_Pizza pour à coché 1, ou 0_Pizza pour n'a pas coché pizza
        $j.ajax({
            type: "POST",
            url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php",
            data: {
                action: "Utilisateur_Preferences_UPD",
                id_utilisateur: id_utilisateur,
                preferences: preferences_cochees
            },
            success: function (msg) {
                alert("Vos préférences ont bien été mise à jour !");
            }
        });
    }


    // Fonction pour localiser un utilisateur lors du clic (natif à html5)
    function localiser() {
        // Si le navigateur le supporte, on execute getCurrentPosition, qui peut appelée montrerPosition ou montrerErreur suivant le callback
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(montrerPosition, montrerErreur);
        } else {
            x.innerHTML = "La géolocalisation n'est pas supportée pour votre terminal.";
        }
    }
    // Affiche un iframe provenant de gmaps avec la position de l'utilisateur
    function montrerPosition(position) {
        var lat_lon = position.coords.latitude + "," + position.coords.longitude;
        var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
            + lat_lon + "&zoom=14&size=400x300&sensor=false";
        document.getElementById("localisation").innerHTML = "<img src='" + img_url + "'>";
    }
    // Si une erreur survient (ex : géo désactivée sur le terminal), on affiche un message
    function montrerErreur(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                document.getElementById("ajout_publication_infos").innerHTML = "User denied the request for Geolocation.";
                break;
            case error.POSITION_UNAVAILABLE:
                document.getElementById("ajout_publication_infos").innerHTML = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                document.getElementById("ajout_publication_infos").innerHTML = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                document.getElementById("ajout_publication_infos").innerHTML = "An unknown error occurred.";
                break;
        }
    }
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

        if ($j("#old_password").val() == $j("#new_password").val()) {
            msg += "- Merci de choisir un nouveau mot de passe différent de votre ancien \n";
        }

        if (msg == "") {
            // Modification du mot de passe avec les 3 champs saisis
            var id_user = <?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>;
            $j.ajax({
                type: "GET",
                url: host + "/projets/tweevent/api/q/req.php",
                data: {
                    action: "Utilisateur_Changer_Mdp",
                    id_utilisateur: id_user,
                    old_password: $j("#old_password").val(),
                    new_password: $j("#new_password").val()
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.confirmation) {
                        $j("#infos_mdp_upd").html("<h1>" + data.message + "</h1>");
                    }
                    else {
                        $j("#infos_mdp_upd").html("<h1>" + data.message + "</h1>");
                    }
                }
            });
        }
        else {
            alert(msg_intro + msg);
        }
    }

    function ajouter_evenement() {
        var msg = "";
        var msg_intro = "Champs requis : \n";

        if ($j("#eventName").val() == "") {
            msg += "- Nom de l'évènement \n";
            $j("#eventName").css("background-color", "#FF0000");
        }
        else
            $j("#eventName").css("background-color", "");

        if ($j("#eventLieu").val() == "") {
            msg += "- Lieu de l'évènement \n";
            $j("#eventLieu").css("background-color", "#FF0000");
        }
        else
            $j("#eventLieu").css("background-color", "");

        if ($j("#eventDateDebut").val() == "") {
            msg += "- Date de début de l'évènement \n";
            $j("#eventDateDebut").css("background-color", "#FF0000");
        }
        else
            $j("#eventDateDebut").css("background-color", "");

        if ($j("#eventDateFin").val() == "") {
            msg += "- Date de fin de l'évènement \n";
            $j("#eventDateFin").css("background-color", "#FF0000");
        }
        else
            $j("#eventDateFin").css("background-color", "");

        if ($j("#eventHeure").val() == "") {
            msg += "- Heure de l'évènement \n";
            $j("#eventHeure").css("background-color", "#FF0000");
        }
        else
            $j("#eventHeure").css("background-color", "");

        if ($j("#eventDesc").val() == "") {
            msg += "- Description de l'évènement \n";
            $j("#eventDesc").css("background-color", "#FF0000");
        }
        else
            $j("#eventDesc").css("background-color", "");

        var au_moins_une_preference = $j('.preferences_event:checked').length;
        var preferences = "";
        $j(".preferences_event:checked").each(function () {
            if (preferences == "")
                preferences += this.name;
            else
                preferences += "," + this.name;
        });

        if (!au_moins_une_preference)
            msg += "- Au moins une préférénce \n";

        if (msg == "") {
            var id_utilisateur = <?=$_COOKIE["utilisateur_id"] > 0 ? $_COOKIE["utilisateur_id"] : 0 ?> ;
            // Création de l'évènement grâce à une requête AJAX sur l'api
            $j.ajax({
                type: "POST",
                url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php",
                dataType: 'json',
                data: {
                    action: "Utilisateur_Evenement_ADD",
                    id_utilisateur: id_utilisateur,
                    eventName: $j("#eventName").val(),
                    eventLieu: $j("#eventLieu").val(),
                    eventDateDebut: $j("#eventDateDebut").val(),
                    eventDateFin: $j("#eventDateFin").val(),
                    eventHeure: $j("#eventHeure").val(),
                    eventDesc: $j("#eventDesc").val(),
                    preferences: preferences
                },
                success: function (data) {
                    console.log(data);
                    if (data.confirmation) {
                        alert("Votre evenement a bien été ajouté !");
                        $j(location).attr('href', "http://martinfrouin.fr/projets/tweevent/Calendrier");
                        window.location.reload(true);

                    }
                    else {
                        alert("Une erreur est survenue lors de l'ajout de l'évènement : \n " + data.msg);
                    }
                }
            });
        }
        else {
            alert(msg_intro + msg);
            return false;
        }
    }
    $j(document).ready(function (e) {
        $j('#loading').hide();
    });
</script>