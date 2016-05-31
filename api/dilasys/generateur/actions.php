<?
/**
* Fonction de nettoyage des noms de fichiers
* @param $texte Texte à nettoyer
*/
function Lib_nettoie($texte) {
    $texte = strtr($texte, 
      'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
      'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $texte = preg_replace('/([^.a-z0-9]+)/i', '_', $texte);
    return $texte;
}

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script! 
//==================================================================================
//Préparation des POST et des GET dans le tableau data_in
foreach($_GET as $key => $value) $data_in[$key] = stripslashes($value);
foreach($_POST as $key => $value) $data_in[$key] = stripslashes($value);

// Chaque action represente un enchainement fonctionnel unitaire.
//==================================================================================
function ExecActions($action) {

	// On recupere tous les objet contenant les donnees
	global $data_in, $data_out;

	switch($action)
	{
		case "Classe_Accueil" :
		{
			include('class.php');
		}
		break;
		case "Class_ADD":
		{
			//*******************************************************************//
			//***************STOCKAGE DES CHAMPS DANS UN TABLEAU******************//
			//*******************************************************************//

			//Initialisation du tableau champ;
			$champ = array();
			//On commence par l'id
			$champ[0]['nom']       = 'id_'.$data_in['nom_table'];
			$champ[0]['type']      = 'INT';
			$champ[0]['taille']    = '11';
			$champ[0]['recherche'] = 'on';

			//On stocke les champs ajouter par l'utilisateur
			for($i = 1, $j = 1; $i <= $data_in['nb_lignes'] ; $i++){
				if(!isset($data_in['ligne_'.$i])){
					//Si le type est INT et la taille non spécifiée, la taille vaut 11
					if($data_in['type_'.$i] == 'INT' && $data_in['taille_'.$i] == '') $data_in['taille_'.$i] = '11';
					//Si le type est VARCHAR et la taille non spécifiée, la taille vaut 255
					elseif($data_in['type_'.$i] == 'VARCHAR' && $data_in['taille_'.$i] == '') $data_in['taille_'.$i] = '255';
					//Si le type est DECIMAL et la taille non spécifiée, la taille vaut 5,2
					elseif($data_in['type_'.$i] == 'DECIMAL' && $data_in['taille_'.$i] == '') $data_in['taille_'.$i] = '5,2';
					//Récupération des champs et insertion dans le tableau
					$champ[$j]['nom']               = Lib_nettoie($data_in['nom_'.$i]);
					$champ[$j]['type']              = $data_in['type_'.$i];
					$champ[$j]['taille']            = preg_replace('/ /', '', $data_in['taille_'.$i]);
					$champ[$j]['recherche']         = (isset($data_in['recherche_'.$i])) ? $data_in['recherche_'.$i] : '';
					$champ[$j]['clef_secondaire_1'] = (isset($data_in['clef_'.$i.'_1'])) ? $data_in['clef_'.$i.'_1'] : '';
					$champ[$j]['clef_secondaire_2'] = (isset($data_in['clef_'.$i.'_2'])) ? $data_in['clef_'.$i.'_2'] : '';
					$champ[$j]['clef_secondaire_3'] = (isset($data_in['clef_'.$i.'_3'])) ? $data_in['clef_'.$i.'_3'] : '';
					$j++;
				}
			}

			//On ajoute les champs etat, date_add, date_upd, et info_table
			$champ[$j]['nom']    = 'etat';
			$champ[$j]['type']   = 'ENUM';
			$champ[$j]['taille'] = "'actif', 'inactif', 'supprime'";
			$champ[$j]['recherche'] = 'on';
			$j++;
			$champ[$j]['nom']    = 'date_add';
			$champ[$j]['type']   = 'VARCHAR';
			$champ[$j]['taille'] = '255';
			$j++;
			$champ[$j]['nom']    = 'date_upd';
			$champ[$j]['type']   = 'VARCHAR';
			$champ[$j]['taille'] = '255';
			$j++;
			$champ[$j]['nom']    = 'info_'.$data_in['nom_table'];
			$champ[$j]['type']   = 'VARCHAR';
			$champ[$j]['taille'] = '255';

			//La variable j devient le nombre de champ
			$nb_champs = $j;

			//*******************************************************************//
			//*****************RECHERCHE DU RETRAIT MAXIMAL***********************//
			//*******************************************************************//

			//Permet d'aligner les signes = dans les parties où les lignes sont similaires, sauf le nom du champ
			$nb_caracteres_max = 0;
			$nb_caracteres_min = 0;
			for($i = 0; $i <= $nb_champs; $i++){
				if(strlen($champ[$i]['nom']) > $nb_caracteres_max)
					$nb_caracteres_max = strlen($champ[$i]['nom']);
				if(strlen($champ[$i]['nom']) < $nb_caracteres_min)
					$nb_caracteres_min = strlen($champ[$i]['nom']);
			}
			$nb_retraits_max = ceil(($nb_caracteres_max - $nb_caracteres_min) / 3) ;

			//*******************************************************************//
			//*********************RECHERCHE DU PLURIEL***************************//
			//*******************************************************************//

			//Le nom de la table est nettoyé : on enlève les accents et les espaces, on remplace les tirets par des "_"
			$nom_table = strtolower(Lib_nettoie($data_in['nom_table']));

			//Prennent un x :
			//Les noms terminés par "au" ou "eau" sauf landau et sarrau
			//Les noms terminés par "eau"
			//Les noms terminés par "eu" sauf pneu et bleu
			//Les noms bijou, caillou, chou,genou, hibou, joujou, pou prennent un 

			if(   (substr($nom_table, -2) == 'au' && $nom_table != 'sarrau' && $nom_table != 'landau') 
				|| (substr($nom_table, -3) == 'eau')
				|| (substr($nom_table, -2) == 'eu' && $nom_table != 'bleu' && $nom_table != 'pneu')
				|| ($nom_table == 'bijou')
				|| ($nom_table == 'caillou')
				|| ($nom_table == 'chou')
				|| ($nom_table == 'genou')
				|| ($nom_table == 'hibou')
				|| ($nom_table == 'joujou')
				|| ($nom_table == 'pou') )
				$nom_table_pluriel = $nom_table.'x';

			//Les noms terminés en "al" ont leur pluriel en "aux" sauf bals, bancals, carnavals,cérémonials, chacals, festivals, récitals, régals, avals, cals, caracals, cantals, chorals, nopals, pals, santals ou sandals, servals, narvals.
			elseif(substr($nom_table, -2) == 'al' && $nom_table != 'bal' 
					&& $nom_table != 'bancal'  && $nom_table != 'carnaval' && $nom_table != 'ceremonial' 
					&& $nom_table != 'chacal'  && $nom_table != 'festival' && $nom_table != 'recital' 
					&& $nom_table != 'regal'   && $nom_table != 'aval'     && $nom_table != 'cal' 
					&& $nom_table != 'caracal' && $nom_table != 'cantal'   && $nom_table != 'choral' 
					&& $nom_table != 'nopal'   && $nom_table != 'pal'      && $nom_table != 'santal' 
					&& $nom_table != 'sandal'  && $nom_table != 'serval'   && $nom_table != 'narval'){
						$coupure = strlen($nom_table) - 2;
						$nom_table_pluriel = substr($nom_table, 0, $coupure).'aux';
			}

			//Les noms bail, corail, émail, soupirail, travail, vantail, vitrail se terminent aussi en 'aux'
			elseif($nom_table == 'bail') $nom_table_pluriel = 'baux'; 
			elseif($nom_table == 'corail') $nom_table_pluriel = 'coraux'; 
			elseif($nom_table == 'email') $nom_table_pluriel = 'emaux'; 
			elseif($nom_table == 'soupirail') $nom_table_pluriel = 'soupiraux'; 
			elseif($nom_table == 'travail') $nom_table_pluriel = 'travaux'; 
			elseif($nom_table == 'vantail') $nom_table_pluriel = 'vantaux'; 
			elseif($nom_table == 'vitrail') $nom_table_pluriel = 'vitraux'; 
			elseif($nom_table == 'ail') $nom_table_pluriel = 'auxs'; 

			//Autres exceptions :
			elseif($nom_table == 'oeil') $nom_table_pluriel = 'yeux';
			elseif($nom_table == 'aieul') $nom_table_pluriel = 'aieux';
			elseif($nom_table == 'ciel') $nom_table_pluriel = 'cieux';
			elseif(substr($nom_table, -1) != 's' && substr($nom_table, -1) != 'x') $nom_table_pluriel = $nom_table.'s';
			else $nom_table_pluriel = $nom_table;
			//Nom de la classe avec une majuscule (singulier)
			$nom_classe = ucwords($nom_table);
			//Nom de la classe avec une majuscule (pluriel)
			$nom_classe_pluriel = ucwords($nom_table_pluriel); 
			//Nom de la classe en majuscule
			$nom_define = strtoupper($nom_table);

			//*******************************************************************//
			//************COMMENTAIRES EN TETE POUR DOXYGEN**********************//
			//*******************************************************************//

			$content  = "" ;
			$content .= "<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER\n";
			$content .= "/** @file\n";
			$content .= "*  @brief this file in ".$nom_classe_pluriel."\n";
			$content .= "*/\n";
			$content .= "\n";
			$content .= "/**\n";
			$content .= " * Classe pour la gestion de ".$nom_table_pluriel."\n";
			$content .= " *\n";
			$content .= " * @author dilas0ft & z3cN@$\n";
			$content .= " * @version 1.0\n";
			$content .= " * @code\n\n";

			//*******************************************************************//
			//*****************************CODE SQL******************************//
			//*******************************************************************//

			/* SYNTHAXE SQL 
			CREATE TABLE `table` (
			`a` INT(11) NOT NULL, 
			`b` VARCHAR(255) NOT NULL, 
			`c` TEXT NOT NULL, 
			`d` DECIMAL(5,2) NOT NULL, 
			`e` DATE NOT NULL, 
			`f` ENUM('oui', 'non') NOT NULL, 
			`g` VARCHAR(1) NOT NULL, 
			PRIMARY KEY (`a`)
			); */

			$sql  = "";
			$sql .= "CREATE TABLE `".$data_in['nom_bdd']."_".$nom_table."` (\n";
			for($i = 0 ; $i <= $nb_champs ; $i++){ 
				$sql .= "\t `".$champ[$i]['nom']."` ";
				switch($champ[$i]['type']){
					case 'INT' : case 'VARCHAR' : case 'DECIMAL' : case 'ENUM' :
						$sql .= $champ[$i]['type']."(".$champ[$i]['taille'].") NOT NULL";
						if($i == 0) $sql .= " auto_increment";
						$sql .= ",\n";
					break;
					case 'CHAR' : case 'TEXT' : case 'DATE' : 
						$sql .= $champ[$i]['type']." NOT NULL,\n"; 
					break;
				}
			}
			$sql .= "PRIMARY KEY(`".$champ[0]['nom']."`));";
			$sql .= "\n";

			//Concaténation de la requête sql à la variable content
			$content .= $sql;

			$content .= "\n * @endcode\n";
			$content .= " *\n";
			$content .= " */\n\n";

			//*******************************************************************//
			//****************RECHERCHE DES CLEFS SECONDAIRES**********************//
			//*******************************************************************//

			//Déclaration du tableau de stockage des clefs
			$clef =  array();

			//Initialisation : la premiere clef est la clef primaire
			$clef[0][0] = $champ[0]['nom'];
			$clef[1] = array();
			$clef[2] = array();
			$clef[3] = array();

			//Recherche des clefs secondaires
			for($i = 0; $i <= $nb_champs; $i++){
				//Récupération de la clef 1
				if(isset($champ[$i]['clef_secondaire_1']) && $champ[$i]['clef_secondaire_1'] == 'on')
					$clef[1][] = $champ[$i]['nom'];
				//Récupération de la clef 2
				if(isset($champ[$i]['clef_secondaire_2']) && $champ[$i]['clef_secondaire_2'] == 'on')
					$clef[2][] = $champ[$i]['nom'];
				//Récupération de la clef 3
				if(isset($champ[$i]['clef_secondaire_3']) && $champ[$i]['clef_secondaire_3'] == 'on')
					$clef[3][] = $champ[$i]['nom'];
			}

			//*******************************************************************//
			//************NOTES POUR LES CLEFS SECONDAIRES ET DE RECHERCHE**********//
			//*******************************************************************//

			$content .= "// Clefs de recherche \n"; 
			for($i = 1, $j = 1; $i <= $nb_champs ; $i++){
				if(isset($champ[$i]['recherche']) && $champ[$i]['recherche'] == 'on'){
					$content .= "// Clef de recherche ".$j." : ".$champ[$i]['nom']."\n";
					$j++;
				}
			}
			$content .= "\n";
			
			$content .= "// Clefs secondaires\n";
			$content .= "//";
			for($i = 0; $i < count($clef[1]); $i++)
				$content .= " ".$clef[1][$i].',';
			$content .= "\n";
			$content .= "//";
			for($i = 0; $i < count($clef[2]); $i++)
				$content .= " ".$clef[2][$i].',';
			$content .= "\n";
			$content .= "//";
			for($i = 0; $i < count($clef[3]); $i++)
				$content .= " ".$clef[3][$i].',';
			$content .= "\n// FIN DU BLOC PARAMETRAGE\n";

			//*******************************************************************//
			//*****************************DEFINE********************************//
			//*******************************************************************//

			$content .= "if (!defined('__".$nom_define."_INC__')){\n";
			$content .= "\tdefine('__".$nom_define."_INC__', 1);\n\n";

			//*******************************************************************//
			//********************DECLARATION DE LA CLASSE*************************//
			//*******************************************************************//

			$content .= "class ".$nom_classe." extends Element {\n";

			//*******************************************************************//
			//********************DECLARATION DES CHAMPS**************************//
			//*******************************************************************//

			for($i = 0; $i <= $nb_champs; $i++) 
				$content .= "\tvar $".$champ[$i]['nom'].";\n";

			//*******************************************************************//
			//**************************CONSTRUCTEUR*****************************//
			//*******************************************************************//

			//Affichage du commentaires en tête
			$content .= "\n/** \n";
			$content .= "Constructeur de la classe.\n"; 
			$content .= "*/\n";

			//Signature de la fonction
			$content .= "function ".$nom_classe."()\n";

			//Contenu
			$content .= "{\n";
			$content .= "\t\$this->type_moi = \"".$nom_table_pluriel."\";\n";
			$content .= "}\n\n";

			//*******************************************************************//
			//****************************GET_TAB********************************//
			//*******************************************************************//

			//Affichage du commentaires en tête
			$content .= "/**\n";
			$content .= "Cette fonction retourne un tableau correspondant aux différents attributs de ".$nom_classe.".\n";
			$content .= "*/\n";
			$content .= "function getTab()\n"; 
			$content .= "{\n";

			for($i = 0; $i <= $nb_champs; $i++){
				//On calcule le nombre de retrait qu'il faut pour ce champ.
				$nb_retraits = ($nb_retraits_max - ceil(strlen($champ[$i]['nom']) / 3));
				//Premiere partie de la ligne
				$content .= "\t\$tab['".$champ[$i]['nom']."']";
				//On place autant de retrait que le nombre calculé 
				for($j = 0; $j <= $nb_retraits; $j++) $content .= "\t";
				//Seconde partie de la ligne
				$content .= "= \$this->".$champ[$i]['nom'].";\n";
			}
			$content .= "\treturn \$tab;\n";
			$content .= "}\n\n";

			//*******************************************************************//
			//********************************ADD********************************//
			//*******************************************************************//

			//Affichage du commentaires en tête
			$content .= "/**\n";
			$content .= "Cette fonction ajoute un element de la table ".$nom_table." à la BDD. \n";
			$content .= "*/\n";
			$content .= "function ADD()\n";
			$content .= "{\n";

			for($i = 1; $i <= $nb_champs; $i++){
				//Premiere partie de la ligne
				//Le champ update n'est pas requis dans la requête INSERT
				if($champ[$i]['nom'] != 'date_upd'){ 
					$content .= "\t\$".$champ[$i]['nom']." ";
					//On place autant de retrait que le nombre calculé
					//On calcule le nombre de retrait qu'il faut pour ce champ.
					$nb_retraits = $nb_retraits_max - (ceil(strlen($champ[$i]['nom'])) / 3);
					for($j = 0; $j <= $nb_retraits; $j++) $content .= "\t";
					//Seconde partie de la ligne
					//Suivant le type, on appelle une fonction de traitement de la chaîne différente
					if($champ[$i]['type'] == 'VARCHAR' || $champ[$i]['type'] == 'TEXT'){
						if($champ[$i]['nom'] != 'date_add' && $champ[$i]['nom'] != 'date_upd')
							$content .= "= Sql_prepareTexteStockage(\$this->{$champ[$i]['nom']});\n";
						elseif($champ[$i]['nom'] == 'date_add') 
							$content .= "= time();\n"; 
					} elseif($champ[$i]['type'] == 'DATE'){
						$content .= "= Lib_frToEn(\$this->{$champ[$i]['nom']});\n";
					} elseif($champ[$i]['type'] == 'DECIMAL'){
						$content .= "= strtr(\$this->{$champ[$i]['nom']}, \",\", \".\");\n";
					} elseif($champ[$i]['type'] == 'INT'){
						$content .= "= is_numeric(\$this->{$champ[$i]['nom']}) ? \$this->{$champ[$i]['nom']} : 0;\n";
					} elseif($champ[$i]['type'] == 'ENUM' && $champ[$i]['nom'] == 'etat') {
						$content .= "= \$this->etat != '' ? \$this->etat : 'actif';\n";
					}	else
						$content .= "= \$this->{$champ[$i]['nom']};\n";
				}
			}
			$content .= "\n";

			//Requête SQL INSERT
			$content .= "\t\$sql = \" INSERT INTO \".\$GLOBALS['prefix'].\"".$nom_table."\n";
			$content .= "\t\t\t\t\t(";
			for($i = 1; $i <= $nb_champs; $i++){
				//Le champ update n'est pas requis dans la requête INSERT
				if($champ[$i]['nom'] != 'date_upd'){
					//Contrôle pour le positionnement des virgules
					if($i != $nb_champs) $content .= $champ[$i]['nom'].", ";
					else $content .= $champ[$i]['nom'];
					if($i % 3 == 0) $content .= "\n\t\t\t\t\t";
				}
			}
			$content .= ")\n";
			$content .= "\t\t\t\tVALUES \n";
			$content .= "\t\t\t\t\t (";
			for($i = 1; $i <= $nb_champs; $i++){
				if($champ[$i]['nom'] != 'date_upd'){
					//Contrôle pour le positionnement des virgules
					if($i != $nb_champs) $content .= "'\$".$champ[$i]['nom']."', ";
					else $content .= "'\$".$champ[$i]['nom']."'";
					if($i % 3 == 0) $content .= "\n\t\t\t\t\t";
				}
			}
			$content .= ")\";\n\n";

			$content .= "\tif (!Sql_exec(\$sql)) \$this->setError(ERROR);\n\n"; 
			$content .= "\tif (!\$this->isError()) {\n";
			$content .= "\t\t\$".$champ[0]['nom']." = Sql_lastInsertId(); \n";
			$content .= "\t\tLib_sqlLog(\$sql.\" -- \$".$champ[0]['nom']."\");\n";
			$content .= "\t\t\$this->".$champ[0]['nom']." = \$this->".$champ[0]['nom'].";\n";
			$content .= "\t\treturn \$".$champ[0]['nom'].";\n";
			$content .= "\t}\n";
			$content .= "\treturn;\n";
			$content .= "}\n\n";

			//*******************************************************************//
			//********************************UPD********************************//
			//*******************************************************************//

			//Affichage du commentaires en tête
			$content .= "/**\n";
			$content .= "Cette fonction modifie un élément de la table ".$nom_table." dans la BDD. \n";
			$content .= "*/\n";
			$content .= "function UPD()\n";
			$content .= "{\n";

			for($i = 0; $i <= $nb_champs; $i++){
				//Premiere partie de la ligne
				//Le champ add n'est pas requis dans la requête UPDATE
				if($champ[$i]['nom'] != 'date_add'){ 
					$content .= "\t\$".$champ[$i]['nom']." ";
					//On place autant de retrait que le nombre calculé
					//On calcule le nombre de retrait qu'il faut pour ce champ.
					$nb_retraits = $nb_retraits_max - (ceil(strlen($champ[$i]['nom'])) / 3);
					for($j = 0; $j <= $nb_retraits; $j++) $content .= "\t";
					//Seconde partie de la ligne
					//Suivant le type, on appelle une fonction de traitement de la chaîne différente
					if($champ[$i]['type'] == 'VARCHAR' || $champ[$i]['type'] == 'TEXT'){
						if($champ[$i]['nom'] != 'date_upd')
							$content .= "= Sql_prepareTexteStockage(\$this->{$champ[$i]['nom']});\n";
						elseif($champ[$i]['nom'] == 'date_upd') 
							$content .= "= time();\n"; 
					} elseif($champ[$i]['type'] == 'DATE'){
						$content .= "= Lib_frToEn(\$this->{$champ[$i]['nom']});\n";
					} elseif($champ[$i]['type'] == 'DECIMAL'){
						$content .= "= strtr(\$this->{$champ[$i]['nom']}, \",\", \".\");\n";
					} elseif($champ[$i]['type'] == 'INT'){
						$content .= "= is_numeric(\$this->{$champ[$i]['nom']}) ? \$this->{$champ[$i]['nom']} : 0;\n";
					} else
						$content .= "= \$this->".$champ[$i]['nom'].";\n";
				}
			}
			$content .= "\n";

			//Requête SQL UPDATE
			$content .= "\t\$sql = \" UPDATE \".\$GLOBALS['prefix'].\"".$nom_table."\n";
			$content .= "\t\t\t\tSET ";

			for($i = 1; $i <= $nb_champs; $i++){
				if($champ[$i]['nom'] != 'date_add'){
					$content .= $champ[$i]['nom']." = ";
					//Contrôle pour le positionnement des virgules
					if($i != $nb_champs) $content .= "'\$".$champ[$i]['nom']."', ";
					else $content .= "'\$".$champ[$i]['nom']."'";
					if($i % 3 == 0) $content .= "\n\t\t\t\t\t";
				}
			}
			$content .= "\n\t\t\t\tWHERE ".$champ[0]['nom']." = $".$champ[0]['nom']."\";\n\n";

			$content .= "\tif (!Sql_exec(\$sql)) \$this->setError(ERROR);\n"; 
			$content .= "\tif (!\$this->isError()) Lib_sqlLog(\$sql);\n";
			$content .= "\n";
			$content .= "\treturn;\n";
			$content	.= "}\n\n";
			
			//*******************************************************************//
			//******************************DELETE*******************************//
			//*******************************************************************//
			
			$content .= "/**\n";
			$content .= "\tCette fonction supprime un chantier de la BDD.\n";
			$content .= "*/\n";
			$content .= "function DEL()\n"; 
			$content .= "{\n";
			$content .= "\tif (\$this->isError()) return;\n\n";
			$content .= "\t\$".$champ[0]['nom']." = \$this->".$champ[0]['nom'].";\n\n";
			$content .= "\t\$sql = \" DELETE FROM \".\$GLOBALS['prefix'].\"".$nom_table."\n";
			$content .= "\t\t\t\tWHERE ".$champ[0]['nom']." = \$".$champ[0]['nom']."\";\n\n";
			$content .= "\tif (!Sql_exec(\$sql)) \$this->setError(ERROR);\n"; 
			$content .= "\tif (!\$this->isError()) Lib_sqlLog(\$sql);\n\n";
			$content .= "\treturn;\n";
			$content .= "}\n\n";
			
			//*******************************************************************//
			//*******************************TOSTR*******************************//
			//*******************************************************************//

			//Affichage du commentaires en tête
			$content .= "/** \n";
			$content .= "Cette fonction transforme les attributs en chaine de caractères.\n";
			$content .= "*/\n";
			$content .= "function toStr()\n";
			$content .= "{\n";
			$content .= "\t\$str = \"\";\n";

			for($i = 0; $i <= $nb_champs; $i++)
				$content .= "\t\$str = Lib_addElem(\$str, \$this->".$champ[$i]['nom'].");\n";

			$content .= "\t\$str = \"(\".\$str.\")\";\n";
			$content .= "\treturn \$str;\n";
			$content .= "}\n";
			$content .= "}\n\n";

			//*******************************************************************//
			//************************CLASSE_RECUPERER***************************//
			//*******************************************************************//

			//Pour chaque clef secondaire
			for($i = 0; $i <= 3; $i++){
				if(count($clef[$i]) >= 1){

					//Affichage du commentaires en tête
					$content .= "/**\n";
					if($i == 0)
						$content .= "Recupère toutes les données relatives à un ".$nom_table." suivant son identifiant\n";
					else{
						$content .= "Recupère toutes les données relatives à un ".$nom_table." suivant les attributs ";
						foreach($clef[$i] as $id => $key) 
							$content .= $key.", ";
					}
					$content .= "et retourne la coquille \"".$nom_classe."\" remplie avec les informations récupérées\n";
					$content .= "de la base.\n";
					foreach($clef[$i] as $key) 
						$content .= "@param ".$key.".\n";
					$content .= "*/\n";

					//Signature de la fonction
					//Pour la clef primaire, la fonction s'appelle nom_classe_recuperer
					//Pour les clefs secondaires, la fonction s'appelle
					if($i == 0)
						$content .= "function ".$nom_classe."_recuperer";
					else
						$content .= "function ".$nom_classe."_recuperer_".$clef[$i][0];

					foreach($clef[$i] as $id => $key)
						if($id != 0) $content .= "_".$key;

					$content .= "("; 

					$content .= "\$".$clef[$i][0];
					foreach($clef[$i] as $id => $key)
						if($id != 0) $content .= ", \$".$key;
					$content .= ")\n";
					$content .= "{\n";

					//Création d'un nouvel élement
					$content .= "\t\$".$nom_table." = new ".$nom_classe."();\n\n";

					//Génération de la requête SQL
					$content .= "\t\$sql = \" SELECT *\n";
					$content .= "\t\t\t\tFROM \".\$GLOBALS['prefix'].\"".$nom_table."\n";
					$content .= "\t\t\t\tWHERE ";
					$content .= $clef[$i][0]." = '\$".$clef[$i][0]."'";
					foreach($clef[$i] as $id => $key){
						if($id != 0) $content .= "\t\t\t\tAND ".$key." = '\$".$key."'";
						if(!empty($clef[$i][$id +1])) $content .= "\n";
					}
					$content .= ";\";\n\n";
					//Exécution de la requête	
					$content .= "\t\$result = Sql_query(\$sql);\n\n";

					//Insertion du resultats dans l'objet
					$content .= "\tif (\$result && Sql_errorCode(\$result) === \"00000\") {\n";
					$content .= "\t\t\$row = Sql_fetch(\$result);\n";

					for($j = 0; $j <= $nb_champs; $j++){
						//Premiere partie de la ligne
						$content .= "\t\t\$".$nom_table."->".$champ[$j]['nom']."";
						//On place autant de retrait que le nombre calculé
						//On calcule le nombre de retrait qu'il faut pour ce champ.
						$nb_retraits = $nb_retraits_max - (ceil(strlen($champ[$j]['nom'])) / 3);
						for($k = 0; $k <= $nb_retraits; $k++) $content .= "\t";
						//Seconde partie de la ligne
						//Suivant le type, on appelle une fonction de traitement de la chaîne différente
						if (($champ[$j]['type'] == 'VARCHAR' || $champ[$j]['type'] == 'TEXT') && ($champ[$j]['nom'] != 'date_add' && $champ[$j]['nom'] != 'date_upd'))
							$content .= "= Sql_prepareTexteAffichage(\$row['".$champ[$j]['nom']."']);\n";
						elseif($champ[$j]['type'] == 'DATE')
							$content .= "= Lib_enToFr(\$row['".$champ[$j]['nom']."']);\n";
						else
							$content .= "= \$row['".$champ[$j]['nom']."'];\n";
					}

					$content .= "\t}\n";

					$content .= "\treturn \$".$nom_table.";\n";
					$content .= "}\n\n";
				}
			}

			//*******************************************************************//
			//************************CLASSES_CHERCHER***************************//
			//*******************************************************************//

			//Affichage du commentaires en tête
			$content .= "/**\n";
			$content .= "Retourne un tableau de ".$nom_table_pluriel." correspondant aux champs du tableau en argument.\n";
			$content .= "@param \$args\n";
			$content .= "*/\n";

			//Signature de la fonction
			$content .= "function ".$nom_classe_pluriel."_chercher(\$args)\n";
			$content .= "{\n";

			//Déclaration du tableau de résultat
			$content .= "\t\$count = 0;\n\n";
			$content .= "\t\$tab_result = array();\n\n";

			//Génération de la requête SQL
			$content .= "\tif (isset(\$args['count'])) {\n";
			$content .= "\t\t\$sql = \" SELECT count(*) nb_enregistrements \n";
			$content .= "\t\t\t\t\tFROM \".\$GLOBALS['prefix'].\"".$nom_table."\n";
			$content .= "\t\t\t\t\tWHERE 1\";\n";
			$content .= "\t} else {\n";
			$content .= "\t\t\$sql = \" SELECT * \n";
			$content .= "\t\t\t\t\tFROM \".\$GLOBALS['prefix'].\"".$nom_table."\n";
			$content .= "\t\t\t\t\tWHERE 1\";\n";
			$content .= "\t}\n\n";

			//Le tableau est retourné vide si le tableau $args ne contient pas les champs nécessaires
			$content .= "\tif (!isset(\$args['".$champ[0]['nom']."'])";
			for($i = 1, $j = 1; $i <= $nb_champs ; $i++){
				if(isset($champ[$i]['recherche']) && $champ[$i]['recherche'] == 'on'){
					$j++;
					$content .= " && !isset(\$args['".$champ[$i]['nom']."'])";
					if($j % 3 == 0) $content .= "\n\t\t";
				}
			}
			$content .= " && !isset(\$args['order_by']) && !isset(\$args['etat']) && !isset(\$args['tab_ids_".$nom_table_pluriel."'])";
			$content .= ")\n";
			$content .= "\t\treturn \$tab_result;\n\n";

			//Début de la condition du WHERE
			$content .= "\t\$condition=\"\";\n\n";

			for($i = 0; $i <= $nb_champs ; $i++){
				if(isset($champ[$i]['recherche']) && $champ[$i]['recherche'] == 'on'){
					$content .= "\tif (isset(\$args['".$champ[$i]['nom']."']) && \$args['".$champ[$i]['nom']."'] != \"*\")\n";
					if($champ[$i]['type'] == 'VARCHAR' || $champ[$i]['type'] == 'TEXT')
						$content .= "\t\t\$condition .= \" AND ".$champ[$i]['nom']." LIKE '\".Sql_prepareTexteStockage(\$args['".$champ[$i]['nom']."']).\"' \";\n";
					elseif($champ[$i]['type'] == 'DATE')
						$content .= "\t\t\$condition .= \" AND ".$champ[$i]['nom']." = '\".Lib_frToEn(\$args['".$champ[$i]['nom']."']).\"' \";\n";
					elseif($champ[$i]['type'] == 'DECIMAL')
						$content .= "\t\t\$condition .= \" AND ".$champ[$i]['nom']." = '\".strtr(\$this->".$champ[$i]['nom'].", \",\", \".\").\"' \";\n";
					else 
						$content .= "\t\t\$condition .= \" AND ".$champ[$i]['nom']." = '\".\$args['".$champ[$i]['nom']."'].\"' \";\n";
				}
			}

			//Tableau avec IN
			$content .= "\n\tif (isset(\$args['tab_ids_".$nom_table_pluriel."']) && \$args['tab_ids_".$nom_table_pluriel."'] != \"*\") {\n"; 
			$content .= "\t\t\$ids = implode(\",\", \$args['tab_ids_".$nom_table_pluriel."']);\n";
			$content .= "\t\t\$condition .= \" AND ".$champ[0]['nom']." IN (0\".\$ids.\") \";\n";  
			$content .= "\t}\n";

			//Concaténation de la requête formé avec un ORDER BY
			$content .= "\tif (!isset(\$args['etat']))\n";
			$content .= "\t\t\$condition .= \" AND etat != 'supprime' \";\n";

			$content .= "\n";
			$content .= "\t\$sql .= \$condition;\n\n";

			//Concaténation de la requête formé avec un ORDER BY
			$content .= "\tif (isset(\$args['order_by']) && !isset(\$args['asc_desc']))\n";
			$content .= "\t\t\$sql .= \" ORDER BY \".\$args['order_by'].\" ASC\";\n";
			$content .= "\tif (isset(\$args['order_by']) && isset(\$args['asc_desc']))\n";
			$content .= "\t\t\$sql .= \" ORDER BY \".\$args['order_by'].\" \".\$args['asc_desc'];\n\n";

			//Concaténation de la requête formé avec un LIMIT
			$content .= "\tif (isset(\$args['limit']) && !isset(\$args['start']))\n";
			$content .= "\t\t\$sql .= \" LIMIT \".\$args['limit'];\n\n";
			$content .= "\tif (isset(\$args['limit']) && isset(\$args['start']))\n";
			$content .= "\t\t\$sql .= \" LIMIT \".\$args['start'].\",\".\$args['limit'];\n\n";

			//Log et exécution
			$content .= "\t/*=============*/ Lib_myLog(\"SQL: \$sql\");\n";
			$content .= "\t\$result = Sql_query(\$sql);\n\n";

			$content .= "\tif (isset(\$args['count'])) {\n";
			$content .= "\t\tif (\$result && Sql_errorCode(\$result) === \"00000\") {\n";
			$content .= "\t\t\t\$row = Sql_fetch(\$result);\n";
			$content .= "\t\t\t\$count = \$row['nb_enregistrements'];\n";
			$content .= "\t\t}\n";
			$content .= "\t\treturn \$count;\n";
			$content .= "\t} else {\n";

			$content .= "\t\tif (\$result && Sql_errorCode(\$result) === \"00000\") {\n";
			$content .= "\t\t\twhile(\$row = Sql_fetch(\$result)) {\n";
			$content .= "\t\t\t\t\$id = \$row['".$champ[0]['nom']."'];\n";

			for($j = 0; $j <= $nb_champs; $j++){
				//Premiere partie de la ligne
				$content .= "\t\t\t\t\$tab_result[\$id][\"".$champ[$j]['nom']."\"]";
				//On place autant de retrait que le nombre calculé
				//On calcule le nombre de retrait qu'il faut pour ce champ.
				$nb_retraits = $nb_retraits_max - (ceil(strlen($champ[$j]['nom'])) / 3);
				for($k = 0; $k <= $nb_retraits; $k++) $content .= "\t";
				//Seconde partie de la ligne
				//Suivant le type, on appelle une fonction de traitement de la chaîne différente
				if($j == 0) $content .= "= \$id;\n";
				else {
					if (($champ[$j]['type'] == 'VARCHAR' || $champ[$j]['type'] == 'TEXT') && ($champ[$j]['nom'] != 'date_add' && $champ[$j]['nom'] != 'date_upd'))
						$content .= "= Sql_prepareTexteAffichage(\$row['".$champ[$j]['nom']."']);\n";
					elseif($champ[$j]['type'] == 'DATE')
						$content .= "= Lib_enToFr(\$row['".$champ[$j]['nom']."']);\n";
					else
						$content .= "= \$row['".$champ[$j]['nom']."'];\n";
				}
			}

			$content .= "\t\t\t}\n";
			$content .= "\t\t}\n\n";

			for($i = 0; $i <= 3; $i++){
				if(count($clef[$i]) >= 1){
					//Définition des array_pop sur le tableau final en fonction des clefs secondaires
					$content .= "\t\tif (count(\$tab_result) == 1 && ";
					$content .= "(\$args['".$champ[0]['nom']."'] != '' && \$args['".$champ[0]['nom']."'] != '*')"; 
					foreach($clef[$i] as $id => $key)
						if($id != 0) $content .= " && (\$args['".$key."'] != '' && \$args['".$key."'] != '*')";
					$content .= ")\n";
					$content .= "\t\t\t\$tab_result = array_pop(\$tab_result);\n";
				}
			}

			$content .= "\t}\n";

			//Retour du tableau de résultat
			$content .= "\n";
			$content .= "\treturn \$tab_result;\n";
			$content .= "}\n";

			//*******************************************************************//
			//******************************FIN DEFINE****************************//
			//*******************************************************************//

			$content .= "} // Fin if (!defined('__".$nom_define."_INC__'))\n";
			$content .= "?>";

			//*******************************************************************//
			//********************CREATION DU FICHIER classe.inc.php*******************//
			//*******************************************************************//

			//Définition du fichier futur
			$path = $data_in['nom_bdd'].'/'.$nom_table.".inc.php"; 

			//Si aucun répertoire pour la base de données concernées, on crée le répertoire
			if(!is_dir($data_in['nom_bdd'])) mkdir($data_in['nom_bdd'], 0777);

			//On ouvre le fichier
			$file = fopen($path, "w"); 

			//On écrit le contenu dans le fichier
			fwrite($file,$content);

			//On ferme le fichier
			fclose($file); 

			//*******************************************************************//
			//********************ENVOI VERS LA PAGE DE RESULTAT*******************//
			//*******************************************************************//

			//On envoie en data_out la requête sql de création de la table;
			$data_out['sql'] = $sql;
			$data_out['nom_bdd'] = $data_in['nom_bdd'];
			$data_out['nom_table'] = $nom_table;

			include('resultat.php');
		}
		break;

		case "Class_UPD";
		{
			//Pour le moment, il n'y a pas d'erreur
			$error = 0;
			$clefs_recherche = array();
			$clef_1 = array();
			$clef_2 = array();
			$clef_3 = array();

			// Ouverture du fichier en lecture
			$fp = fopen($_FILES["path"]['tmp_name'], "r"); 

			if(substr($_FILES["path"]['name'], -8) != '.inc.php')
				$error = 1;

			// Tant que non fin du fichier
			$i = 1; $j = 1;
			while (!feof($fp)) {

				//On récupère chaque ligne de la classe
				$ligne = fgets($fp) ; 

				$ind_clef_1 = $ind_clef_2 = $ind_clef_3 = 0;
				//On vérifie que la classe est une classe créé avec ce module
				//La ligne 9 doit être égal à  "* @author dilas0ft & z3cN@$ "
				if($i == 9){
					if(!preg_match('/\* \@author dilas0ft \& z3cN\@\$/', $ligne)){
						$error = 1;
						break;
					}
				}
				//A la ligne 13, on récupère le nom de la table et le nom de la base de données
				elseif($i == 13){
					$split_ligne_1 = preg_split("/`/", $ligne);
					$split_ligne_2 = preg_split("/_/", $split_ligne_1[1]);
					
					//Le nom de la base de donnée est le mot après le premier '_' 
					$nom_bdd = $split_ligne_2[0];
					//Le nom de la table est ce qu'il y a ensuite
					for($pass = 0, $k = 1; $k < count($split_ligne_2); $k++){
						if($pass == 0){
							$nom_table = $split_ligne_2[$k];
							$pass = 1;
						} else 
							$nom_table .= '_'.$split_ligne_2[$k];
					}
				}
				//On vérifie si la ligne contient : "	 `*`", * correspondant à une chaine de caractère, 
				//C'est à dire à partir de la première ligne de la requête sql de la classe (ligne 14)
				// On skip la ligne 14 : c'est l'identifiant 
				elseif(preg_match('/\t `*`/', $ligne) && $i != 14){
					//On ignore les champs date_add, date_upd, info_
					if(preg_match('/date_add/', $ligne) || preg_match('/date_upd/', $ligne) || preg_match('/info_/', $ligne)) continue;
					//Lorsqu'on arrive au champ date_add, on s'arrête : ce qui nous intéresse, ce ne sont que les champs saisis par l'utilisateur
					//Les lignes récupérées sont de type : "	 `nom_champ` VARCHAR(64) NOT NULL, "
					//On coupe la chaine au espace et on stocke le résultat dans un tableau
					$split_ligne = preg_split("/ /", $ligne); 
					//Le nom du champ est la première case du tableau, à laquelle on enlève les "`" grâce à preg_replace
					$champ[$j]['nom'] = preg_replace('/`/', '', $split_ligne[1]);
					//La deuxième case du tableau coupé est de type "VARCHAR(64)";
					//On coupe donc à la parenthèse ouvrante pour récupérer le type VARCHAR et la taille 64
					$taille = preg_split("/\(/", $split_ligne[2]);
					$champ[$j]['type'] = $taille[0];
					//On stocke la taille, avec la parenthèse fermante en moins supprimé avec preg_replace
					$champ[$j]['taille'] = preg_replace('/\)/', '', $taille[1]);
					$j++;
				}
				//Récupération des attributs de recherche 
				elseif(preg_match('/Clef de recherche /', $ligne)){
					$split_ligne = array();
					$split_ligne = preg_split("/\ : /", $ligne);
					$clefs_recherche[] = trim($split_ligne[1]);
				}
				//On recherche les clefs secondaires 
				elseif(preg_match('/Clefs secondaires/', $ligne)){
					$ind_clef_1 = $i + 1;
					$ind_clef_2 = $i + 2;
					$ind_clef_3 = $i + 3;
				}

				//Récupération de la première clef secondaire
				elseif($i == $ind_clef_1){
					$split_ligne = $split_1 = $split_2 = $clef_1 = array();
					$split_ligne = preg_split("/, /", $ligne);
					//Pour le premier, on enlève les barres de commentaires
					$split_1 = preg_split("/\/\/ /", $split_ligne[0]);
					$clef_1[0] = $split_1[1];
					
					//Pour la suite, on ne fait que stocker
					for($k = 1; $k < (count($split_ligne)-1) ; $k++)
						$clef_1[$k] = $split_ligne[$k];

					//Pour le dernier, on enlève la virgule
					$split_2 = preg_split("/,/", $split_ligne[$k]);
					$clef_1[$k] = $split_2[0];
				}
				//Récupération de la seconde clef secondaire
				elseif($i == $ind_clef_2){
					$split_ligne = $split_1 = $split_2 = $clef_2 = array();
					$split_ligne = preg_split("/, /", $ligne);
					//Pour le premier, on enlève les barres de commentaires
					$split_1 = preg_split("/\/\//", $split_ligne[0]);
					$clef_2[0] = $split_1[1];
					
					//Pour la suite, on ne fait que stocker
					for($k = 1; $k < (count($split_ligne)-1) ; $k++)
						$clef_2[$k] = $split_ligne[$k];

					//Pour le dernier, on enlève la virgule
					$split_2 = preg_split("/,/", $split_ligne[$k]);
					$clef_2[$k] = $split_2[0];
				}
				//Récupération de la première clef secondaire
				elseif($i == $ind_clef_3){
					$split_ligne = $split_1 = $split_2 = $clef_3 = array();
					$split_ligne = preg_split("/, /", $ligne);
					//Pour le premier, on enlève les barres de commentaires
					$split_1 = preg_split("/\/\//", $split_ligne[0]);
					$clef_3[0] = $split_1[1];
					
					//Pour la suite, on ne fait que stocker
					for($k = 1; $k < (count($split_ligne)-1) ; $k++)
						$clef_3[$k] = $split_ligne[$k];

					//Pour le dernier, on enlève la virgule
					$split_2 = preg_split("/,/", $split_ligne[$k]);
					$clef_3[$k] = $split_2[0];
					
					//Fin du traitement sur le fichier
					break;
				}
				$i++;
			}
			//On stocke les champs dans un data_out
			$data_out['clefs_recherche'] = $clefs_recherche;
			$data_out['clef_1'] = $clef_1;
			$data_out['clef_2'] = $clef_2;
			$data_out['clef_3'] = $clef_3;
			$data_out['nom_bdd'] = $nom_bdd;
			$data_out['nom_table'] = $nom_table;
			$data_out['liste_champs'] = $champ;
			
			if($error == 1)
				$data_out['message'] = 'Le fichier n\'est pas une classe g&eacute;n&eacute;r&eacute;e par ce module.';

			ExecActions('Classe_Accueil');
		}
		break;
		default:
			ExecActions('Classe_Accueil');
		break;
	}
}

if (!isset($data_in['action'])) $data_in['action'] = 'Classe_Accueil';
ExecActions($data_in['action']);
?>