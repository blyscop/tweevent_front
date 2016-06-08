<!DOCTYPE html>
<html class="no-js">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Tweevent - A Social Network</title>
    <meta name="generator" content="Bootply"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link href="../../css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link href="../../css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/timelinestyle.css">
    <link rel='stylesheet' href='../../css/fullcalendar.min.css'/>
</head>
<body onload="charger_preferences_utilisateur(); ReceiptPost();">
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
            <!-- main right col -->
            <div class="column col-sm-10 col-xs-11" id="main">
                <div class="full-actu col-sm-12">
                    <!-- content -->
                    <div class="row">
                        <!-- Contenu du template -->
                        <form name="change_mdp" id="change_mdp" action="req.php?action=Changement_Mdp_UPD">
                            <label for="password">Nouveau mot de passe :</label>
                            <input type="password" name="password" id="password"/>
                            <input type="hidden" name="id_utilisateur" id="id_utilisateur" value="<?=$data_out['id_utilisateur'] > 0 ? $data_out['id_utilisateur'] : 0 ?>">
                        </form>
                        <!-- Fin contenu template -->
                    </div><!--/row-->
                    <div><!--colsm9-content-->
                    </div>
                    <!-- /main -->
                </div>
            </div>
        </div>


    </div>
</div>
</body>
</html>