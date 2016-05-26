<?

function Arbo_afficher($liste_elements, $html = ''){
	if(!empty($liste_elements)){
		echo '<ol class="dd-list">';
		foreach($liste_elements as $element){
			echo '<li class="dd-item" data-id="'.$element['id_arbo'].'">';
			if($element['id_arbo_pere'] != 0)
				echo '<div class="dd-handle">Dossier '.$element['intitule'].'</div>';
			else
				echo '<div class="dd-handle">Fichier '.$element['intitule'].'</div>';
			Arbo_afficher($element['liste_fils'], $html);
			echo '</li>';
		}
		echo '</ol>';
	}
}

function Arbo_afficher2($liste_elements, $html = ''){
	if(!empty($liste_elements)){
		echo '<ol class="dd-list">';
		foreach($liste_elements as $element){
			echo '<li class="dd-item" data-id="'.$element['id_arbo'].'">';
			echo '<div class="dd-handle">';
			if($element['id_arbo_pere'] == 0){
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20" align="center" valign="top">';
					if ($element['etat'] == 'inactif') {
						echo '<a href="arbo_actions.php?action=Page_Etat&id_article='.$element['id_pere'].'&code_arbo='.$data_out['code_arbo'].'"><img src="../img/ico_ko.png" alt="Non publi&eacute;" width="16" height="16" border="0" align="absmiddle"	title="Non publi&eacute;" class="toolt" /></a>';
					}
					echo '	</td>';
					echo '	<td width="25" align="center" valign="top">
								<a href="site_dynamique_actions.php?action=Site_Apercu&id_article='.$element['id_pere'].'&tmsp='.time().'&code_arbo='.$data_out['code_arbo'].'">
									<img src="../img/ico_Modifier.gif" alt="Editer la page" title="Editer la page" width="16" height="16" border="0" align="absmiddle" class="toolt" />
								</a>
							</td>';
					echo '	<td align="left" valign="top">&nbsp;
								'.$element['id_pere'].'&nbsp;- &nbsp;
								'.$element['intitule'].' 
							</td>';
					echo '	<td width="50">
								<div class="cat_sup">';
								if(count($element['liste_fils']) == 0) {
									echo '<a href=\'javascript: if(confirm("%%ConfirmerSuppressionArticle%% ?"))  location.href= "arbo_actions.php?tmsp='.time().'&action=Element_DEL&id_arbo='.$element['id_arbo'].'&id_arbo_pere='.$element['id_arbo_pere'].'&id_pere='.$element['id_pere'].'&type_pere='.$element['type_pere'].'&code_arbo='.$data_out['code_arbo'].'"\'>
										<img src="../img/sup1.gif" alt="Supprimer" border="0" title="Supprimer" /></a>';
								 } 
					echo '		</div>
							</td>
						</tr>
					</table>';
			}else{
				$etat = $element['etat'] == 'actif' ? 'ok' : 'ko';
				$intitule = $element['intitule'] != '' ? $element['intitule'] : 'Sans intitul&eacute;';
				echo '<img src="../img/ico_'.$etat.'.png" alt="Actif" width="16" height="16" border="0" align="absmiddle" title="Actif" class="toolt" />';
				echo '<a href=\'site_dynamique_actions.php?action=Site_Apercu&id_article='.$element['id_pere'].'&tmsp='.time().'&code_arbo='.$data_out['code_arbo'].'\'><img src="../img/ico_Modifier.gif" alt="Editer la page de la cat&eacute;gorie" title="Editer la page de la cat&eacute;gorie" width="16" height="16" border="0" align="absmiddle" class="toolt" /></a>
			<a href=\'javascript: document.frm_categorie_upd.intitule.value='.addslashes($element['intitule']).'; document.frm_categorie_upd.id_arbo.value='.$categorie['id_arbo'].'; App2("ModifCat");\'>'.$intitule.'</a>';
				echo '<div class="cat_ajout"><a href=\'javascript: document.frm_ss_categorie_add.id_arbo_pere.value='.$element['id_arbo_pere'].'; App("AjoutSsCat_WD");\'><img  src="../img/bt_add.png" alt="Ajouter une sous-cat&eacute;gorie" width="16" height="16" border="0" align="absmiddle" />Ajouter une sous-cat&eacute;gorie</a></div>';
				echo '<div class="cat_sup">';
				if(count($element['liste_fils']) == 0){
					echo '<a href=\'javascript: if(confirm("%%ConfirmerSuppressionCategorie%% ?"))  location.href="arbo_actions.php?tmsp='.time().'&action=Element_DEL&id_arbo='.$element['id_arbo'].'&id_arbo_pere='.$element['id_arbo_pere'].'&id_pere='.$element['id_pere'].'&type_pere='.$element['type_pere'].'&code_arbo='.$data_out['code_arbo'].'"\'><img src="../img/sup1.gif" alt="Supprimer" width="13" height="13" border="0" title="Supprimer" class="toolt" /></a>';
				}
				echo '</div>';
			}
			echo '</div>';
			Arbo_afficher($element['liste_fils'], $html);
			echo '</li>';
		}
		echo '</ol>';
	}
}
 
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="en" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="en" class="lt-ie9"> <![endif]-->
<!--[if IE 9]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Nestable</title>
    <style type="text/css">

.cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
* html .cf { zoom: 1; }
*:first-child+html .cf { zoom: 1; }

html { margin: 0; padding: 0; }
body { font-size: 100%; margin: 0; padding: 1.75em; font-family: 'Helvetica Neue', Arial, sans-serif; }

h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }

a { color: #2996cc; }
a:hover { text-decoration: none; }

p { line-height: 1.5em; }
.small { color: #666; font-size: 0.875em; }
.large { font-size: 1.25em; }

/**
 * Nestable
 */

.dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }

.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), 
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), 
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), 
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

/**
 * Nestable Extras
 */

.nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

#nestable-menu { padding: 0; margin: 20px 0; }

#nestable-output,
#nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

#nestable2 .dd-handle {
    color: #fff;
    border: 1px solid #999;
    background: #bbb;
    background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
    background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
    background:         linear-gradient(top, #bbb 0%, #999 100%);
}
#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 .dd-item > button:before { color: #fff; }

@media only screen and (min-width: 700px) { 

    .dd { float: left; width: 48%; }
    .dd + .dd { margin-left: 2%; }

}

.dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

.dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd3-content:hover { color: #2ea8e5; background: #fff; }

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-item > button { margin-left: 30px; }

.dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:         linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
.dd3-handle:hover { background: #ddd; }

    </style>
</head>
<body>

    <h1>Nestable</h1>

    <p>Drag &amp; drop hierarchical list with mouse and touch compatibility (jQuery plugin)</p>

    <p><strong><a href="https://github.com/dbushell/Nestable">Code on GitHub</a></strong></p>

<p><strong>PLEASE NOTE: I cannot provide any support or guidance beyond this README. If this code helps you that's great but I have no plans to develop Nestable beyond this demo (it's not a final product and has limited functionality). I cannot reply to any requests for help.</strong></p>

    <menu id="nestable-menu">
        <button type="button" data-action="expand-all">Expand All</button>
        <button type="button" data-action="collapse-all">Collapse All</button>
    </menu>

    <div class="cf nestable-lists">

        <!--<div class="dd" id="nestable"> 
			<? if(!empty($data_out['liste_fils'])){ ?> 
            <ol class="dd-list">
                <? foreach($data_out['liste_fils'] as $element){ ?> 
                <li class="dd-item" data-id="<?=$element['id_arbo']?>">
                    <div class="dd-handle"><?=($element['id_arbo_pere'] != 0) ? 'Dossier ' : 'Fichier '?><?=$element['intitule']?></div>
                    <? if(!empty($element['liste_fils'])){ ?> 
                    <ol class="dd-list">
                        <? foreach($element['liste_fils'] as $fils){ ?>
                        <li class="dd-item" data-id="<?=$fils['id_arbo']?>">
                            <div class="dd-handle"><?=($fils['id_arbo_pere'] != 0) ? 'Dossier ' : 'Fichier '?><?=$fils['intitule']?></div>
                            <? if(!empty($fils['liste_fils'])){ ?> 
                            <ol class="dd-list">
                                <? foreach($fils['liste_fils'] as $petit_fils){ ?>
                                <li class="dd-item" data-id="<?=$petit_fils['id_arbo']?>"><div class="dd-handle"><?=($petit_fils['id_arbo_pere'] != 0) ? 'Dossier ' : 'Fichier '?><?=$petit_fils['intitule']?></div></li>
                                <? }?>
                            </ol>
                            <? }?>
                        </li>
                        <? }?>
                    </ol>
                    <? }?>
                </li>
                <? } ?>
            </ol>
            <? }?>
        </div>-->
		
        <div id="nestable" class="dd">
        	<? Arbo_afficher($data_out['liste_fils']); ?>
        </div>
    </div>

    <p><strong>Serialised Output (per list)</strong></p>

    <textarea id="nestable-output"></textarea>
    <!--<textarea id="nestable2-output"></textarea>-->

    <p>&nbsp;</p>

    <div class="cf nestable-lists">

    <p><strong>Draggable Handles</strong></p>

    <p>If you're clever with your CSS and markup this can be achieved without any JavaScript changes.</p>

        <div class="dd" id="nestable3">
            <ol class="dd-list">
                <li class="dd-item dd3-item" data-id="13">
                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 13</div>
                </li>
                <li class="dd-item dd3-item" data-id="14">
                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 14</div>
                </li>
                <li class="dd-item dd3-item" data-id="15">
                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 15</div>
                    <ol class="dd-list">
                        <li class="dd-item dd3-item" data-id="16">
                            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 16</div>
                        </li>
                        <li class="dd-item dd3-item" data-id="17">
                            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 17</div>
                        </li>
                        <li class="dd-item dd3-item" data-id="18">
                            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 18</div>
                        </li>
                    </ol>
                </li>
            </ol>
        </div>

    </div>

    <p class="small">Copyright &copy; <a href="http://dbushell.com/">David Bushell</a> | Made for <a href="http://www.browserlondon.com/">Browser</a></p>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="jquery.nestable.js"></script>
<script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
			$.ajax({
              	type: 'POST',
              	url: 'arbo_actions.php?action=AJAX_ArboUPD&arbo_json='+output.val(),
              	cache: false,
              	success: function(html) {
              	}
      		});
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
		maxDepth: 10
    })
    .on('change', updateOutput);
    
    // activate Nestable for list 2
    //$('#nestable2').nestable({
      //  group: 1
    //})
    //.on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    //updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();

});
</script>
</body>
</html>