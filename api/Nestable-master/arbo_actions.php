<?
/** @file
 *  @ingroup group3
 *  @brief this file in Articles
*/

//==================================================================================
// Definir ici le auteur du module qui sera verifie avec la table des autorisations
//==================================================================================
$module = "";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script! 
//==================================================================================
if (!include('../dilasys/pre.php')) exit;
include('../biblio/article.inc.php');
include('../biblio/arbo.inc.php');

/*=============*/ Lib_myLog("FILE: ",__FILE__);
/*=============*/ Lib_myLog("IN: ",$data_in);
include('../dilasys/lang/messages_dilasys_'.$lang.'.php');
include('../lang/messages_dynamique_'.$lang.'.php');
include('../lang/messages_arbo_'.$lang.'.php');

//==================================================================================
// Chaque action represente un enchainement fonctionnel unitaire.
//==================================================================================

/**
 Cette fonction est un grand switch qui sert à renvoyer vers une action donnée en paramètre. 
 @param Action : Action à accomplir…
*/


function ExecActions($action) {
	/*=============*/ Lib_myLog("action: ",$action);    
	// On recupere la configuration issue de conf.php
	global $lang, $taille_ecran, $MSG, $secure, $cle, $config;
	// On recupere tous les objet contenant les donnees
	global $data_in, $data_out, $data_srv, $session;

	// Initialization des variables
	global $message, $article;

	 switch($action)
	{
		/**
		* - Cas Site_Accueil :
		* . 
		*      Le cas (par défaut) Site_Accueil recherche tous les articles, s'occupent des critères de tri, et renvoie vers la vue (page) Site_Accueil.php....
		*/
		case "Accueil":
		{
			/*=============*/ Lib_myLog("Recuperation de l'arborescence");
			$data_out['liste_fils'] = Arbo_construire($data_in['code_arbo']);

			if (isset($data_in['id_arbo_pere'])) $data_out['id_arbo_pere'] = $data_in['id_arbo_pere'];
			$data_out['code_arbo'] = $data_in['code_arbo'];
			$data_out['menu_gauche'] = 'arbo';
			$data_out['page'] = 'arbo.php';
		}
		break;
		
		case "AJAX_ArboUPD":
		{
			$tab_arbo = json_decode($data_in['arbo_json'], true);
			/*=============*/ Lib_myLog("Arbo recuperee");
			Arbo_recalcul($tab_arbo);
		}
		break;

		case "Element_Etat":
		{
			$arbo = Arbo_recuperer($data_in['id_arbo']);
			$arbo->etat = ($arbo->etat == 'actif') ? $arbo->etat = 'inactif' : $arbo->etat = 'actif';
			$arbo->UPD();
			$data_out['message_ok'] = $MSG['fr']['%%arbo_UPD%%'];

			// On remet à 0 le fichier contenant le "cache" des articles pour l'affichage des blocs
			Lib_writeData('', "ARBO");

			ExecActions('Accueil');
		}
		break;

		case "Element_Bouger":
		{
			$tab_positions = explode("|", $data_in['tab_list']);
			$i=1;
			foreach($tab_positions as $position) {
				$projet = Arbo_recuperer($position);
				$projet->ordre = $i;
				$projet->UPD();
				$i++;
			}

			$data_out['message_ok'] = $MSG['fr']['%%arbo_UPD%%'];
			// On remet à 0 le fichier contenant le "cache" de l'arborescence
			Lib_writeData('', "ARBO");

			ExecActions('Accueil');
		}
		break;

		case "Element_DEL":
		{
			/*=============*/ Lib_myLog("Recuperation de l'element");
			if($data_in['id_arbo_pere'] != 0){
				/*=============*/ Lib_myLog("Suppression de de l'objet de type arbo");
				$obj_element_initial = Arbo_recuperer($data_in['id_arbo']);
				$data_out['message_ok'] = $MSG['fr']['%%arbo_DEL%%'];
			}

			if($data_in['id_arbo_pere'] == 0){
				/*=============*/ Lib_myLog("Suppression des articles dans toutes les langues");
				$obj_element_initial = Arbo_recuperer_par_element($data_in['id_pere'], $data_in['type_pere'], $data_in['code_arbo']);

				// Le même article peut être en pluisieurs langues. On les regroupe grâce au code article
				$args_articles['code'] = 'article-'.$obj_element_initial->id_pere;
				$liste_articles = Articles_chercher($args_articles);
				foreach($liste_articles as $art) {
					$article = Article_recuperer($art['id_article']);
					$article->DEL();
				}

				$data_out['message_ok'] = $MSG['fr']['%%page_DEL%%'];
			} 

			/*=============*/ Lib_myLog("Retablissement de l'ordre sans coupure");
			$args_elements['famille']   = $obj_element_initial->famille;
			$args_elements['sup_ordre'] = $obj_element_initial->ordre;
			$args_elements['code_arbo'] = $data_in['code_arbo'];
			$elements = Arbos_chercher($args_elements);
			foreach($elements as $element){
				$obj_element = Arbo_recuperer($element['id_arbo']);
				$obj_element->ordre--;
				$obj_element->UPD();
			}
			$obj_element_initial->DEL();

			// On remet à 0 le fichier contenant le "cache" de l'arborescence
			Lib_writeData('', "ARBO");

			ExecActions('Accueil');
		}
		break;

		case "Categorie_ADD" :
		{
			$args_arbos['code_arbo'] = $data_in['code_arbo'];
			$args_arbos['famille'] = '';

			if ($data_in['id_arbo_pere'] != '') {
				/*=============*/ Lib_myLog("Il s'agit d'un ajout de sous-element !");
				$arbo_pere = Arbo_recuperer($data_in['id_arbo_pere']);
				$args_arbos['famille'] = $arbo_pere->famille.$arbo_pere->id_arbo_pere.'-';
			}

			/*=============*/ Lib_myLog("On determine le nouvel ordre a attribuer au nouvel element");
			$arbos = Arbos_chercher($args_arbos);
			$ordre = count($arbos);
			$ordre++;

			/*=============*/ Lib_myLog("Rajout d'un nouvel element");
			$arbo = new Arbo();
			if ($data_in['id_arbo_pere'] != '') 
				$arbo->famille .= $arbo_pere->famille.$arbo_pere->id_arbo_pere.'-';
			$arbo->code_arbo	= $data_in['code_arbo'];
			$arbo->type_pere	= 'arbo';
			$arbo->ordre		= $ordre;
			$arbo->etat 		= 'inactif';
			$arbo->intitule	= $data_in['intitule'];
			$id_arbo = $arbo->ADD();
			$data_out['message_ok'] = $MSG['fr']['%%arbo_ADD%%'];

			$arbo->id_arbo_pere = ($data_in['id_arbo_pere'] != '') ? $data_in['id_arbo_pere'] : $id_arbo;

			/*=============*/ Lib_myLog("Creation du nouvel article associe a la categorie");
			$article = new Article();
			$article->titre_page = $data_in['intitule'];
			$article->titre = $data_in['intitule'];
			$article->lang = 'fr';
			$article->etat = 'actif';
			$id_article = $article->ADD();

			$article = Article_recuperer($id_article);
			// On définit un code pour pouvoir retrouver le même article en plusieurs langues
			$article->code = 'article-'.$id_article;
			$article->UPD();

			foreach($GLOBALS['LANGUES'] as $langue) {
				/*=============*/ Lib_myLog("Ajout de l'article en $langue");
				$article->lang = $langue;
				$article->ADD();
			}

			$arbo->id_pere = $id_article;
			$arbo->type_pere = 'article';
			$arbo->UPD();

			// On remet à 0 le fichier contenant le "cache" de l'arborescence
			Lib_writeData('', "ARBO");

			ExecActions('Accueil');
		}
		break;

		case "Categorie_UPD" :
		{
			/*=============*/ Lib_myLog("Modification de l'intitule d'un element");
			$arbo = Arbo_recuperer($data_in['id_arbo']);
			$arbo->intitule	= $data_in['intitule'];
			$arbo->UPD();

			/*=============*/ Lib_myLog("Modification de l'article lie a l'element");
			$article = Article_recuperer($arbo->id_pere);
			$article->titre = $data_in['intitule'];
			$article->UPD();

			// On remet à 0 le fichier contenant le "cache" de l'arborescence
			Lib_writeData('', "ARBO");
			$data_out['message_ok'] = $MSG['fr']['%%arbo_UPD%%'];

			ExecActions('Accueil');
		}
		break;

		case "SELECT_SsCategories":
		{
			$data_out['liste_sous_categories'] = array();
			/*=============*/ Lib_myLog("Recuperation du pere");
			$arbo_pere = Arbo_recuperer($data_in['id_arbo']);

			$args_sous['not_id_arbo_pere'] = 0;
			$args_sous['famille'] = $arbo_pere->famille.$arbo_pere->id_arbo.'-';
			$data_out['liste_sous_categories'] = Arbos_chercher($args_sous);

			$cle = 'ordre';
			$val = usort($data_out['liste_sous_categories'], "Lib_compareUp");

			$data_out['page'] = 'arbo_select_ss_categories.php';
		}
		break;

		default :
		{
				ExecActions('Accueil');
		}
		break;
	}
}

if (!isset($data_in['action'])) $data_in['action'] = 'default';
ExecActions($data_in['action']);
/*=============*/ Lib_myLog("OUT: ",$data_out);
include('../dilasys/post.php');
return $data_out;
?>