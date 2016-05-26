var host="http://martinfrouin.fr";
function getPreferencesTypes(type)
{
    var action="";
    var divID="";
    if(type=="music")
    {
        action="get_musics";
        divID="#musicPreferences";
    }
    if(type=="drink")
    {
        action="get_drinks";
        divID="#drinkPreferences";
    }
    if(type=="food")
    {
        action="get_foods";
        divID="#foodPreferences";
    }
    $.ajax({
        type: 'GET',
        url: 'http://localhost/Tweevent_Session2/tweevent_front-master/test.php?action='+action,
        data: { get_param: 'libelle' },
        dataType: 'json',
        success: function (data) {
            $.each(data, function(index, element) {
                console.log(element);
                $(divID).append("<div><input type='checkbox'/> "+element.libelle+"</div>");
            });
        }
    });
    console.log('http://localhost/Tweevent_Session2/tweevent_front-master/test.php?action='+action);
}

function inscription()
{
    var _pseudo=$('#pseudo').val();
    var _password=$('#password').val();
    var _action="Utilisateur_ADD";
    var _chk="enregistrer";

    $.ajax({
        type: "POST",
        url: "http://martinfrouin.fr/projets/tweevent/q/req.php?",
        data: {pseudo:_pseudo,password:_password,action:_action,chk:_chk},
        success: function(msg) {
            var msg = $.parseJSON(msg);
            if(msg.utilisateur!=null) {
                console.log(msg.utilisateur);
                connect(_pseudo,_password)
            }
            else
            {
                $('#info_inscription').empty();
                $('#info_inscription').append('<div class="form-group col-sm-12"><label for="pseudo" class="col-sm-3 control-label">Information : </label><div class="col-sm-6"><p style="color:red;">'+msg.message+'</p></div></div>');
            }

        }
    });
}

function connect(_username,_pwd)
{
    $.ajax({
        type: "POST",
        url: "session.php",
        data: {username:_username,password:_pwd},
        success: function(msg) {
            console.log(msg);
            document.location.replace("Actualite.php");
        }
    });
}

function send_post()
{
    var _idUser=$("#id_utilisateur").val();
    var _message=$("#post_area").val();
    $.ajax({
        type: "POST",
        url: host+"/projets/tweevent/q/req.php",
        data: {action:"Post_ADD",id_utilisateur:_idUser,message:_message},
        success: function(msg) {alert(msg);}
    });
}