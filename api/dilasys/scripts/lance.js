function lance(){   
  var form="formulaire";
  var reg=new RegExp("[=]","g");
  var tab=lance.arguments[0].split(reg);

  if (tab[0] == "form") 
     form=tab[1];
  else
     document.forms[form].elements[tab[0]].value=tab[1];

  for (var i=1;i<lance.arguments.length; i++) {
     var tab=lance.arguments[i].split(reg);
     document.forms[form].elements[tab[0]].value=tab[1];
  }

  document.forms[form].submit();
}