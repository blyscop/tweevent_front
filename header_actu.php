<header>

    <div>
        <img style="" class="bloc-round" src="./img/profilpic.jpg"/><br/>
        <a style="" href="#imgModifModal" role="button" data-toggle="modal">Modifier mon image</a>
        
    </div>
    <h1 class="username_actu">Bonjour <?php echo ucfirst($_COOKIE['username']); ?></h1>
    <script>
         var $j = jQuery.noConflict();
        $j(document).ready(function (e) {
            $j("#modifImgForm").on('submit', (function (e) {
                e.preventDefault();
                $j("#message_image").empty();
                $j('#loading').show();
                var formData = new FormData(this);
                $j.ajax({
                    url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Post_ADD&id_utilisateur=<?=$_COOKIE['utilisateur_id'] > 0 ? $_COOKIE['utilisateur_id'] : 0?>&message=" + $j("#message").val(),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    mimeType: "multipart/form-data",
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $j('#loading').hide();
                        var json_data = JSON.parse(data);
                        if (json_data.confirmation) {
                            window.location.reload(true);
                        }
                        else {
                            alert(json_data.msg);
                        }
                    }
                });
            }));
        });
    </script>
    <div id="imgModifModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <form id="modifImgForm">
                        <input type="file"/>
                        <h4 id='loading_profil'>Chargement ...</h4>
                        <input type="submit"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</header>