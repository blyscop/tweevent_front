<!-- AJOUT DE POSTS -->
<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="send_post" name="send_post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" id="close_post_area" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                    <h4 id='loading'>Chargement ...</h4>
                    <div id="message_image"></div>
                    <div id="ajout_publication_infos">Update Status</div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea id="message" class="form-control input-lg" name="message" autofocus=""
                                  placeholder="Que voulez-vous partager?"></textarea>

                    </div>
                </div>

                <div class="modal-footer">
                    <div>
                        <button id="send_post" class="btn btn-primary">Publier
                        </button>
                        <ul class="pull-left list-inline">
                            <li>
                                <div class="upload_photo">
                                    <div id="image_preview" style="display: none;">
                                        <img id="previewing" src="img/noimage.png" height="70%" width="70%"/>
                                    </div>
                                    <div id="selectImage">
                                        <i class="glyphicon glyphicon-camera new_btn"></i>
                                        <input type="file" name="file" id="file"/>
                                    </div>

                                </div>
                            </li>
                            <li>
                                <i onclick="localiser()" class="glyphicon glyphicon-map-marker"></i>
                                <div id="localisation"></div>
                            </li>
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
            <div id="info_preferences_upd"></div> <!-- AJAX message d'informations sur l'UPD -->
            <form name="preferences_upd" id="preferences_upd" action="functions.php?action=preferences_upd">
                <div id="preferences_categories"></div>
                <!-- AJAX bloc de préférence par catégorie avec checkbox -->
                <input type="hidden" id="id_utilisateur" name="id_utilisateur"
                       value="<?= $_COOKIE['id_utilisateur'] > 0 ? $_COOKIE['id_utilisateur'] : 0; ?>"/>
            </form>
        </div>
    </div>
</div>

<? if($_COOKIE['utilisateur_type'] == "pro") { ?>
<!-- POPUP AJOUT EVENEMENTS POUR LES PRO -->
<div class="modal fade addEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content col-md-12 preferences">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4>Ajouter Evenement</h4>
            </div>
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
                        <label class="marge_label" for="eventHeure">Heure</label>
                        <input type="time" class="form-control" id="eventHeure" placeholder="Heure de l'évènement">
                    </div>
                    <div class="form-group">
                        <label for="eventDesc">Description</label>
                        <textarea type="text" class="form-control" id="eventDesc" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="preferences_event">Préférences de l'évènement :</label>
                        <div id="preferences_categories_event"></div>
                    </div>
                    <button type="button" onclick="ajouter_evenement();" class="btn btn-default">Enregistrer</button>
                </div>
        </div>
    </div>
</div>
<? } ?>
