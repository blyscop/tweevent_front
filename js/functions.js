var salt="bonjour";
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
    /*$.ajax({
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
    });*/
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
       url: "http://martinfrouin.fr/projets/tweevent/api/q/req.php?",
       data: {pseudo:_pseudo,password:_password,action:_action,chk:_chk},
       success: function(msg) {
           var msg = $.parseJSON(msg);
           if(msg.utilisateur!=null) {
               console.log(msg.utilisateur);
               connect(msg.utilisateur);
           }
           else
           {
               $('#info_inscription').empty();
               $('#info_inscription').append('<div class="form-group col-sm-12"><label for="pseudo" class="col-sm-3 control-label">Information : </label><div class="col-sm-6"><p style="color:#66fffd;">'+msg.message+'</p></div></div>');
           }
       }
   });
}

function connect(user)
{
    //pseudo_tweevent_user: "mousse", password_tweevent_user: "f80c211bf2b7e7441c73c22f46d7f4cb"
    $("#connection_username").val(user.pseudo_tweevent_user);
    $("#connection_pwd").val($("#password").val());
    $('#connection_validation').trigger('click');
}



function ReceiptPost()
{
    var _idUser=$("#id_utilisateur").val();
    $.ajax({
        type: "GET",
        url: host+"/projets/tweevent/api/q/req.php",
        data: { action:"Utilisateur_Posts_SELECT",id_utilisateur:_idUser },
        dataType: 'json',
        success: function(msg) {
            console.log(msg);
            $.each(msg.actualites, function(i, item) {
                $('#cd-timeline').append('<div class="cd-timeline-block">'+
                    '<div class="cd-timeline-img cd-picture">'+
                    '<img src="./img/cd-icon-picture.svg" alt="Picture">'+
                    '</div>'+
                    '<div class="cd-timeline-content">'+
                    '<h2>Unknow a commenté</h2>'+
                    '<p>'+item.message_tweevent_post+'</p>'+
                    '<a href="#0" class="cd-read-more">Read more</a>'+
                    '<span class="cd-date">'+parseJsonDate(item.date_add)+'</span>'+
                    '</div>'+
                    '</div>');
            })
        }
    });
}


function send_post()
{
    var _idUser=$("#id_utilisateur").val();
    var _message=$("#post_area").val();
    $.ajax({
        type: "POST",
        url: host+"/projets/tweevent/api/q/req.php",
        data: {action:"Post_ADD",id_utilisateur:_idUser,message:_message},
        success: function(msg) {
            $("#close_post_area").trigger("click");
        }
    });
}

function parseJsonDate(jsonDateString){
    var date = new Date(parseInt(jsonDateString));
    return date;
}

