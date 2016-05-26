# --------------------------------------------------------
CREATE TABLE %%prefix%%adherent (
  `id_adherent` int(11) NOT NULL auto_increment,
  `id_utilisateur` int(11) NOT NULL,
  `id_interne` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `enseigne` varchar(255) NOT NULL,
  `raison_sociale` varchar(255) NOT NULL,
  `adresse1` varchar(255) NOT NULL,
  `adresse2` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `site_internet` varchar(255) NOT NULL,
  `entreprise_qualifiee` tinyint(4) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `nature_lien` varchar(255) NOT NULL,
  `info_publique` varchar(255) NOT NULL,
  `categorie1` varchar(255) NOT NULL,
  `categorie2` varchar(255) NOT NULL,
  `categorie3` varchar(255) NOT NULL,
  `categorie4` varchar(255) NOT NULL,
  `categorie5` varchar(255) NOT NULL,
  `categorie6` varchar(255) NOT NULL,
  `categorie7` varchar(255) NOT NULL,
  `categorie8` varchar(255) NOT NULL,
  `categorie9` varchar(255) NOT NULL,
  `categorie10` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `etat` enum('actif','inactif','supprime') NOT NULL,
  `date_add` varchar(255) NOT NULL,
  `date_upd` varchar(255) NOT NULL,
  `info_adherent` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_adherent`)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%arbo (
  `id_arbo` int(11) NOT NULL auto_increment,
  `id_arbo_pere` int(11) NOT NULL,
  `code_arbo` varchar(64) NOT NULL,
  `famille` varchar(32) NOT NULL default '0',
  `id_pere` int(11) NOT NULL default '0',
  `type_pere` varchar(32) NOT NULL default '',
  `etat` enum('actif','inactif') NOT NULL default 'actif',
  `ordre` int(11) NOT NULL default '0',
  `date_add` varchar(255) NOT NULL default '',
  `date_upd` varchar(255) NOT NULL default '',
  `intitule` varchar(255) NOT NULL default '',
  `intitule_canonize` varchar(255) NOT NULL default '',
  `couleur` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id_arbo`)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE IF NOT EXISTS %%prefix%%taches (
  `id_tache` int(11) NOT NULL auto_increment,
  `code` varchar(64) NOT NULL,
  `lang` varchar(64) NOT NULL default '',
  `position_une` int(11) NOT NULL default '0',
  `id_new` varchar(255) NOT NULL default '0',
  `code_news` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `url_image` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image_intro` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `texte` text NOT NULL,
  `etat` varchar(32) NOT NULL default '',
  `texte_intro` text NOT NULL,
  `titre_page` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL default '',
  `meta_titre` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_mots_clefs` varchar(255) NOT NULL,
  `meta_url` varchar(255) NOT NULL,
  `titre_canonize` varchar(255) NOT NULL default '',
  `url_vignette` varchar(255) NOT NULL default '',
  `url_image2` varchar(255) NOT NULL,
  `categorie` varchar(32) NOT NULL default '',
  `titre_data1` varchar(255) NOT NULL,
  `data1` text NOT NULL,
  `titre_data2` varchar(255) NOT NULL,
  `data2` date NOT NULL,
  `titre_data3` varchar(255) NOT NULL,
  `data3` date NOT NULL,
  `titre_data4` varchar(255) NOT NULL,
  `data4` date NOT NULL,
  `titre_data5` varchar(255) NOT NULL,
  `data5` text NOT NULL,
  `titre_data6` varchar(255) NOT NULL,
  `data6` text NOT NULL,
  `titre_data7` varchar(255) NOT NULL,
  `data7` text NOT NULL,
  `titre_data8` varchar(255) NOT NULL,
  `data8` text NOT NULL,
  `titre_data9` varchar(255) NOT NULL,
  `data9` text NOT NULL,
  `titre_data10` varchar(255) NOT NULL,
  `data10` text NOT NULL,
  `titre_data11` varchar(255) NOT NULL,
  `data11` text NOT NULL,
  `titre_data12` varchar(255) NOT NULL,
  `data12` text NOT NULL,
  `titre_data13` varchar(255) NOT NULL,
  `data13` text NOT NULL,
  `titre_data14` varchar(255) NOT NULL,
  `data14` text NOT NULL,
  `titre_data15` varchar(255) NOT NULL,
  `data15` text NOT NULL,
  `titre_data16` varchar(255) NOT NULL,
  `data16` text NOT NULL,
  `titre_data17` varchar(255) NOT NULL,
  `data17` text NOT NULL,
  `titre_data18` varchar(255) NOT NULL,
  `data18` text NOT NULL,
  `titre_data19` varchar(255) NOT NULL,
  `data19` text NOT NULL,
  `titre_data20` varchar(255) NOT NULL,
  `data20` text NOT NULL,
  `titre_fichier1` varchar(255) NOT NULL,
  `fichier1` varchar(255) NOT NULL,
  `titre_fichier2` varchar(255) NOT NULL,
  `fichier2` varchar(255) NOT NULL,
  `titre_fichier3` varchar(255) NOT NULL,
  `fichier3` varchar(255) NOT NULL,
  `titre_fichier4` varchar(255) NOT NULL,
  `fichier4` varchar(255) NOT NULL,
  `titre_fichier5` varchar(255) NOT NULL,
  `fichier5` varchar(255) NOT NULL,
  `date_add` varchar(64) NOT NULL default '',
  `date_upd` varchar(64) NOT NULL default '',
  `info_tache` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id_tache`),
  KEY `url_vignette` (`url_vignette`)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `%%prefix%%articles` (
  `id_article` int(11) NOT NULL auto_increment,
  `code` varchar(64) NOT NULL,
  `lang` varchar(64) NOT NULL default '',
  `position_une` int(11) NOT NULL default '0',
  `id_new` varchar(255) NOT NULL default '0',
  `code_news` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `url_image` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image_intro` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `etat` varchar(32) NOT NULL default '',
  `texte_intro` text NOT NULL,
  `titre_page` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL default '',
  `meta_titre` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_mots_clefs` varchar(255) NOT NULL,
  `meta_url` varchar(255) NOT NULL,
  `titre_canonize` varchar(255) NOT NULL default '',
  `url_vignette` varchar(255) NOT NULL default '',
  `url_image2` varchar(255) NOT NULL,
  `categorie` varchar(32) NOT NULL default '',
  `titre_data1` varchar(255) NOT NULL,
  `data1` text NOT NULL,
  `titre_data2` varchar(255) NOT NULL,
  `data2` text NOT NULL,
  `titre_data3` varchar(255) NOT NULL,
  `data3` text NOT NULL,
  `titre_data4` varchar(255) NOT NULL,
  `data4` text NOT NULL,
  `titre_data5` varchar(255) NOT NULL,
  `data5` text NOT NULL,
  `titre_data6` varchar(255) NOT NULL,
  `data6` text NOT NULL,
  `titre_data7` varchar(255) NOT NULL,
  `data7` text NOT NULL,
  `titre_data8` varchar(255) NOT NULL,
  `data8` text NOT NULL,
  `titre_data9` varchar(255) NOT NULL,
  `data9` text NOT NULL,
  `titre_data10` varchar(255) NOT NULL,
  `data10` text NOT NULL,
  `titre_data11` varchar(255) NOT NULL,
  `data11` text NOT NULL,
  `titre_data12` varchar(255) NOT NULL,
  `data12` text NOT NULL,
  `titre_data13` varchar(255) NOT NULL,
  `data13` text NOT NULL,
  `titre_data14` varchar(255) NOT NULL,
  `data14` text NOT NULL,
  `titre_data15` varchar(255) NOT NULL,
  `data15` text NOT NULL,
  `titre_data16` varchar(255) NOT NULL,
  `data16` text NOT NULL,
  `titre_data17` varchar(255) NOT NULL,
  `data17` text NOT NULL,
  `titre_data18` varchar(255) NOT NULL,
  `data18` text NOT NULL,
  `titre_data19` varchar(255) NOT NULL,
  `data19` text NOT NULL,
  `titre_data20` varchar(255) NOT NULL,
  `data20` text NOT NULL,
  `titre_fichier1` varchar(255) NOT NULL,
  `fichier1` varchar(255) NOT NULL,
  `titre_fichier2` varchar(255) NOT NULL,
  `fichier2` varchar(255) NOT NULL,
  `titre_fichier3` varchar(255) NOT NULL,
  `fichier3` varchar(255) NOT NULL,
  `titre_fichier4` varchar(255) NOT NULL,
  `fichier4` varchar(255) NOT NULL,
  `titre_fichier5` varchar(255) NOT NULL,
  `fichier5` varchar(255) NOT NULL,
  `id_article_pere` int(11) NOT NULL,
  `previsualisation` int(11) NOT NULL,
  `date_add` varchar(64) NOT NULL default '',
  `date_upd` varchar(64) NOT NULL default '',
  `info_article` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id_article`),
  KEY `url_vignette` (`url_vignette`)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%galeries (
  `id_galerie` int(11) NOT NULL auto_increment,
  `code_pere` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `url_vignette` varchar(255) NOT NULL,
  `url_gde_image` varchar(255) NOT NULL,
  `largeur_vignette` int(11) NOT NULL,
  `hauteur_vignette` int(11) NOT NULL,
  `info_galerie` varchar(64) NOT NULL,
  `id_pere` int(11) NOT NULL,
  `type_pere` varchar(64) NOT NULL,
  PRIMARY KEY  (`id_galerie`)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%galeries_lang (
  id_galerie int(11) NOT NULL,
  lang varchar(4) NOT NULL,
  legende text NOT NULL
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%docs (
  id_doc int(11) NOT NULL AUTO_INCREMENT,
  famille varchar(32) NOT NULL DEFAULT '0',
  id_utilisateur int(11) NOT NULL DEFAULT '0',
  id_pere int(11) NOT NULL DEFAULT '0',
  type_pere varchar(32) NOT NULL DEFAULT '',
  etat enum('actif','inactif') NOT NULL DEFAULT 'actif',
  ordre int(11) NOT NULL DEFAULT '0',
  date_add varchar(255) NOT NULL DEFAULT '',
  date_upd varchar(255) NOT NULL DEFAULT '',
  intitule varchar(255) NOT NULL DEFAULT '',
  intitule_canonize varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id_doc)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%fiche (
    id_fiche INT(11) NOT NULL auto_increment,
    id_type_fiche INT(11) NOT NULL,
    fic_prenom VARCHAR(255) NOT NULL,
    fic_nom VARCHAR(255) NOT NULL,
    fic_adresse1 VARCHAR(255) NOT NULL,
    fic_adresse2 VARCHAR(255) NOT NULL,
    fic_adresse3 VARCHAR(255) NOT NULL,
    fic_cp VARCHAR(255) NOT NULL,
    fic_ville VARCHAR(255) NOT NULL,
    fic_email VARCHAR(255) NOT NULL,
    fic_document VARCHAR(255) NOT NULL,
    date_add VARCHAR(255) NOT NULL,
    date_upd VARCHAR(255) NOT NULL,
    info_fiche VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id_fiche`)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%fiche_memos (
	 id_memo INT(11) NOT NULL auto_increment,
	 id_fiche INT(11) NOT NULL,
	 date_memo INT(11) NULL,
	 memo TEXT NOT NULL,
	 date_add VARCHAR(255) NOT NULL,
	 date_upd VARCHAR(255) NOT NULL,
	 info_memo VARCHAR(255) NOT NULL,
PRIMARY KEY(id_memo)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%param_type_fiche (
	id_type_fiche INT(11) NOT NULL auto_increment,
	libelle VARCHAR(255) NOT NULL,
	date_add VARCHAR(255) NOT NULL,
	date_upd VARCHAR(255) NOT NULL,
	info_type_fiche VARCHAR(255) NOT NULL,
	PRIMARY KEY(id_type_fiche)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%forms (
	  `id_form` int(10) NOT NULL auto_increment,
	  `nom` varchar(255) NOT NULL,
	  `prenom` varchar(255) NOT NULL,
	  `form0` text NOT NULL,
	  `form1` text NOT NULL,
	  `form2` text NOT NULL,
	  `form3` text NOT NULL,
	  `form4` text NOT NULL,
	  `form5` text NOT NULL,
	  `form6` text NOT NULL,
	  `form7` text NOT NULL,
	  `form8` text NOT NULL,
	  `form9` text NOT NULL,
	  `form10` text NOT NULL,
	  `form11` text NOT NULL,
	  `form12` text NOT NULL,
	  `form13` text NOT NULL,
	  `form14` text NOT NULL,
	  `form15` text NOT NULL,
	  `form16` text NOT NULL,
	  `form17` text NOT NULL,
	  `form18` text NOT NULL,
	  `form19` text NOT NULL,
	  `form20` text NOT NULL,
	  `form21` text NOT NULL,
	  `form22` text NOT NULL,
	  `form23` text NOT NULL,
	  `form24` text NOT NULL,
	  `form25` text NOT NULL,
	  `form26` text NOT NULL,
	  `form27` text NOT NULL,
	  `form28` text NOT NULL,
	  `form29` text NOT NULL,
	  `form30` text NOT NULL,
	  date_add varchar(32) NOT NULL,
	  date_upd varchar(32) NOT NULL,
	  KEY id (`id_form`)
	) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE IF NOT EXISTS %%prefix%%param_pays (
  `id_param_pays` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(3) NOT NULL,
  `alpha2` varchar(2) NOT NULL,
  `alpha3` varchar(3) NOT NULL,
  `nom_en` varchar(255) NOT NULL,
  `nom_fr` varchar(255) NOT NULL,
  etat enum('actif','inactif') NOT NULL DEFAULT 'actif',
  date_add varchar(32) NOT NULL,
  date_upd varchar(32) NOT NULL,
  info_param_pays VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_param_pays`),
  UNIQUE KEY `alpha2` (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`),
  UNIQUE KEY `code_unique` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=242 ;

INSERT INTO %%prefix%%param_pays (`id_param_pays`, `code`, `alpha2`, `alpha3`, `nom_en`, `nom_fr`, `etat`, `date_add`, `date_upd`, `info_param_pays`) VALUES
(1, 4, 'AF', 'AFG', 'Afghanistan', 'Afghanistan','actif','','',''),
(2, 8, 'AL', 'ALB', 'Albania', 'Albanie','actif','','',''),
(3, 10, 'AQ', 'ATA', 'Antarctica', 'Antarctique','actif','','',''),
(4, 12, 'DZ', 'DZA', 'Algeria', 'Alg�rie','actif','','',''),
(5, 16, 'AS', 'ASM', 'American Samoa', 'Samoa Am�ricaines','actif','','',''),
(6, 20, 'AD', 'AND', 'Andorra', 'Andorre','actif','','',''),
(7, 24, 'AO', 'AGO', 'Angola', 'Angola','actif','','',''),
(8, 28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antigua-et-Barbuda','actif','','',''),
(9, 31, 'AZ', 'AZE', 'Azerbaijan', 'Azerba�djan','actif','','',''),
(10, 32, 'AR', 'ARG', 'Argentina', 'Argentine','actif','','',''),
(11, 36, 'AU', 'AUS', 'Australia', 'Australie','actif','','',''),
(12, 40, 'AT', 'AUT', 'Austria', 'Autriche','actif','','',''),
(13, 44, 'BS', 'BHS', 'Bahamas', 'Bahamas','actif','','',''),
(14, 48, 'BH', 'BHR', 'Bahrain', 'Bahre�n','actif','','',''),
(15, 50, 'BD', 'BGD', 'Bangladesh', 'Bangladesh','actif','','',''),
(16, 51, 'AM', 'ARM', 'Armenia', 'Arm�nie','actif','','',''),
(17, 52, 'BB', 'BRB', 'Barbados', 'Barbade','actif','','',''),
(18, 56, 'BE', 'BEL', 'Belgium', 'Belgique','actif','','',''),
(19, 60, 'BM', 'BMU', 'Bermuda', 'Bermudes','actif','','',''),
(20, 64, 'BT', 'BTN', 'Bhutan', 'Bhoutan','actif','','',''),
(21, 68, 'BO', 'BOL', 'Bolivia', 'Bolivie','actif','','',''),
(22, 70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnie-Herz�govine','actif','','',''),
(23, 72, 'BW', 'BWA', 'Botswana', 'Botswana','actif','','',''),
(24, 74, 'BV', 'BVT', 'Bouvet Island', '�le Bouvet','actif','','',''),
(25, 76, 'BR', 'BRA', 'Brazil', 'Br�sil','actif','','',''),
(26, 84, 'BZ', 'BLZ', 'Belize', 'Belize','actif','','',''),
(27, 86, 'IO', 'IOT', 'British Indian Ocean Territory', 'Territoire Britannique de l''Oc�an Indien','actif','','',''),
(28, 90, 'SB', 'SLB', 'Solomon Islands', '�les Salomon','actif','','',''),
(29, 92, 'VG', 'VGB', 'British Virgin Islands', '�les Vierges Britanniques','actif','','',''),
(30, 96, 'BN', 'BRN', 'Brunei Darussalam', 'Brun�i Darussalam','actif','','',''),
(31, 100, 'BG', 'BGR', 'Bulgaria', 'Bulgarie','actif','','',''),
(32, 104, 'MM', 'MMR', 'Myanmar', 'Myanmar','actif','','',''),
(33, 108, 'BI', 'BDI', 'Burundi', 'Burundi','actif','','',''),
(34, 112, 'BY', 'BLR', 'Belarus', 'B�larus','actif','','',''),
(35, 116, 'KH', 'KHM', 'Cambodia', 'Cambodge','actif','','',''),
(36, 120, 'CM', 'CMR', 'Cameroon', 'Cameroun','actif','','',''),
(37, 124, 'CA', 'CAN', 'Canada', 'Canada','actif','','',''),
(38, 132, 'CV', 'CPV', 'Cape Verde', 'Cap-vert','actif','','',''),
(39, 136, 'KY', 'CYM', 'Cayman Islands', '�les Ca�manes','actif','','',''),
(40, 140, 'CF', 'CAF', 'Central African', 'R�publique Centrafricaine','actif','','',''),
(41, 144, 'LK', 'LKA', 'Sri Lanka', 'Sri Lanka','actif','','',''),
(42, 148, 'TD', 'TCD', 'Chad', 'Tchad','actif','','',''),
(43, 152, 'CL', 'CHL', 'Chile', 'Chili','actif','','',''),
(44, 156, 'CN', 'CHN', 'China', 'Chine','actif','','',''),
(45, 158, 'TW', 'TWN', 'Taiwan', 'Ta�wan','actif','','',''),
(46, 162, 'CX', 'CXR', 'Christmas Island', '�le Christmas','actif','','',''),
(47, 166, 'CC', 'CCK', 'Cocos (Keeling) Islands', '�les Cocos (Keeling)','actif','','',''),
(48, 170, 'CO', 'COL', 'Colombia', 'Colombie','actif','','',''),
(49, 174, 'KM', 'COM', 'Comoros', 'Comores','actif','','',''),
(50, 175, 'YT', 'MYT', 'Mayotte', 'Mayotte','actif','','',''),
(51, 178, 'CG', 'COG', 'Republic of the Congo', 'R�publique du Congo','actif','','',''),
(52, 180, 'CD', 'COD', 'The Democratic Republic Of The Congo', 'R�publique D�mocratique du Congo','actif','','',''),
(53, 184, 'CK', 'COK', 'Cook Islands', '�les Cook','actif','','',''),
(54, 188, 'CR', 'CRI', 'Costa Rica', 'Costa Rica','actif','','',''),
(55, 191, 'HR', 'HRV', 'Croatia', 'Croatie','actif','','',''),
(56, 192, 'CU', 'CUB', 'Cuba', 'Cuba','actif','','',''),
(57, 196, 'CY', 'CYP', 'Cyprus', 'Chypre','actif','','',''),
(58, 203, 'CZ', 'CZE', 'Czech Republic', 'R�publique Tch�que','actif','','',''),
(59, 204, 'BJ', 'BEN', 'Benin', 'B�nin','actif','','',''),
(60, 208, 'DK', 'DNK', 'Denmark', 'Danemark','actif','','',''),
(61, 212, 'DM', 'DMA', 'Dominica', 'Dominique','actif','','',''),
(62, 214, 'DO', 'DOM', 'Dominican Republic', 'R�publique Dominicaine','actif','','',''),
(63, 218, 'EC', 'ECU', 'Ecuador', '�quateur','actif','','',''),
(64, 222, 'SV', 'SLV', 'El Salvador', 'El Salvador','actif','','',''),
(65, 226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Guin�e �quatoriale','actif','','',''),
(66, 231, 'ET', 'ETH', 'Ethiopia', '�thiopie','actif','','',''),
(67, 232, 'ER', 'ERI', 'Eritrea', '�rythr�e','actif','','',''),
(68, 233, 'EE', 'EST', 'Estonia', 'Estonie','actif','','',''),
(69, 234, 'FO', 'FRO', 'Faroe Islands', '�les F�ro�','actif','','',''),
(70, 238, 'FK', 'FLK', 'Falkland Islands', '�les (malvinas) Falkland','actif','','',''),
(71, 239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'G�orgie du Sud et les �les Sandwich du Sud','actif','','',''),
(72, 242, 'FJ', 'FJI', 'Fiji', 'Fidji','actif','','',''),
(73, 246, 'FI', 'FIN', 'Finland', 'Finlande','actif','','',''),
(74, 248, 'AX', 'ALA', '�land Islands', '�les �land','actif','','',''),
(75, 250, 'FR', 'FRA', 'France', 'France','actif','','',''),
(76, 254, 'GF', 'GUF', 'French Guiana', 'Guyane Fran�aise','actif','','',''),
(77, 258, 'PF', 'PYF', 'French Polynesia', 'Polyn�sie Fran�aise','actif','','',''),
(78, 260, 'TF', 'ATF', 'French Southern Territories', 'Terres Australes Fran�aises','actif','','',''),
(79, 262, 'DJ', 'DJI', 'Djibouti', 'Djibouti','actif','','',''),
(80, 266, 'GA', 'GAB', 'Gabon', 'Gabon','actif','','',''),
(81, 268, 'GE', 'GEO', 'Georgia', 'G�orgie','actif','','',''),
(82, 270, 'GM', 'GMB', 'Gambia', 'Gambie','actif','','',''),
(83, 275, 'PS', 'PSE', 'Occupied Palestinian Territory', 'Territoire Palestinien Occup�','actif','','',''),
(84, 276, 'DE', 'DEU', 'Germany', 'Allemagne','actif','','',''),
(85, 288, 'GH', 'GHA', 'Ghana', 'Ghana','actif','','',''),
(86, 292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar','actif','','',''),
(87, 296, 'KI', 'KIR', 'Kiribati', 'Kiribati','actif','','',''),
(88, 300, 'GR', 'GRC', 'Greece', 'Gr�ce','actif','','',''),
(89, 304, 'GL', 'GRL', 'Greenland', 'Groenland','actif','','',''),
(90, 308, 'GD', 'GRD', 'Grenada', 'Grenade','actif','','',''),
(91, 312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe','actif','','',''),
(92, 316, 'GU', 'GUM', 'Guam', 'Guam','actif','','',''),
(93, 320, 'GT', 'GTM', 'Guatemala', 'Guatemala','actif','','',''),
(94, 324, 'GN', 'GIN', 'Guinea', 'Guin�e','actif','','',''),
(95, 328, 'GY', 'GUY', 'Guyana', 'Guyana','actif','','',''),
(96, 332, 'HT', 'HTI', 'Haiti', 'Ha�ti','actif','','',''),
(97, 334, 'HM', 'HMD', 'Heard Island and McDonald Islands', '�les Heard et Mcdonald','actif','','',''),
(98, 336, 'VA', 'VAT', 'Vatican City State', 'Saint-Si�ge (�tat de la Cit� du Vatican)','actif','','',''),
(99, 340, 'HN', 'HND', 'Honduras', 'Honduras','actif','','',''),
(100, 344, 'HK', 'HKG', 'Hong Kong', 'Hong-Kong','actif','','',''),
(101, 348, 'HU', 'HUN', 'Hungary', 'Hongrie','actif','','',''),
(102, 352, 'IS', 'ISL', 'Iceland', 'Islande','actif','','',''),
(103, 356, 'IN', 'IND', 'India', 'Inde','actif','','',''),
(104, 360, 'ID', 'IDN', 'Indonesia', 'Indon�sie','actif','','',''),
(105, 364, 'IR', 'IRN', 'Islamic Republic of Iran', 'R�publique Islamique d''Iran','actif','','',''),
(106, 368, 'IQ', 'IRQ', 'Iraq', 'Iraq','actif','','',''),
(107, 372, 'IE', 'IRL', 'Ireland', 'Irlande','actif','','',''),
(108, 376, 'IL', 'ISR', 'Israel', 'Isra�l','actif','','',''),
(109, 380, 'IT', 'ITA', 'Italy', 'Italie','actif','','',''),
(110, 384, 'CI', 'CIV', 'C�te d''Ivoire', 'C�te d''Ivoire','actif','','',''),
(111, 388, 'JM', 'JAM', 'Jamaica', 'Jama�que','actif','','',''),
(112, 392, 'JP', 'JPN', 'Japan', 'Japon','actif','','',''),
(113, 398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazakhstan','actif','','',''),
(114, 400, 'JO', 'JOR', 'Jordan', 'Jordanie','actif','','',''),
(115, 404, 'KE', 'KEN', 'Kenya', 'Kenya','actif','','',''),
(116, 408, 'KP', 'PRK', 'Democratic People''s Republic of Korea', 'R�publique Populaire D�mocratique de Cor�e','actif','','',''),
(117, 410, 'KR', 'KOR', 'Republic of Korea', 'R�publique de Cor�e','actif','','',''),
(118, 414, 'KW', 'KWT', 'Kuwait', 'Kowe�t','actif','','',''),
(119, 417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kirghizistan','actif','','',''),
(120, 418, 'LA', 'LAO', 'Lao People''s Democratic Republic', 'R�publique D�mocratique Populaire Lao','actif','','',''),
(121, 422, 'LB', 'LBN', 'Lebanon', 'Liban','actif','','',''),
(122, 426, 'LS', 'LSO', 'Lesotho', 'Lesotho','actif','','',''),
(123, 428, 'LV', 'LVA', 'Latvia', 'Lettonie','actif','','',''),
(124, 430, 'LR', 'LBR', 'Liberia', 'Lib�ria','actif','','',''),
(125, 434, 'LY', 'LBY', 'Libyan Arab Jamahiriya', 'Jamahiriya Arabe Libyenne','actif','','',''),
(126, 438, 'LI', 'LIE', 'Liechtenstein', 'Liechtenstein','actif','','',''),
(127, 440, 'LT', 'LTU', 'Lithuania', 'Lituanie','actif','','',''),
(128, 442, 'LU', 'LUX', 'Luxembourg', 'Luxembourg','actif','','',''),
(129, 446, 'MO', 'MAC', 'Macao', 'Macao','actif','','',''),
(130, 450, 'MG', 'MDG', 'Madagascar', 'Madagascar','actif','','',''),
(131, 454, 'MW', 'MWI', 'Malawi', 'Malawi','actif','','',''),
(132, 458, 'MY', 'MYS', 'Malaysia', 'Malaisie','actif','','',''),
(133, 462, 'MV', 'MDV', 'Maldives', 'Maldives','actif','','',''),
(134, 466, 'ML', 'MLI', 'Mali', 'Mali','actif','','',''),
(135, 470, 'MT', 'MLT', 'Malta', 'Malte','actif','','',''),
(136, 474, 'MQ', 'MTQ', 'Martinique', 'Martinique','actif','','',''),
(137, 478, 'MR', 'MRT', 'Mauritania', 'Mauritanie','actif','','',''),
(138, 480, 'MU', 'MUS', 'Mauritius', 'Maurice','actif','','',''),
(139, 484, 'MX', 'MEX', 'Mexico', 'Mexique','actif','','',''),
(140, 492, 'MC', 'MCO', 'Monaco', 'Monaco','actif','','',''),
(141, 496, 'MN', 'MNG', 'Mongolia', 'Mongolie','actif','','',''),
(142, 498, 'MD', 'MDA', 'Republic of Moldova', 'R�publique de Moldova','actif','','',''),
(143, 500, 'MS', 'MSR', 'Montserrat', 'Montserrat','actif','','',''),
(144, 504, 'MA', 'MAR', 'Morocco', 'Maroc','actif','','',''),
(145, 508, 'MZ', 'MOZ', 'Mozambique', 'Mozambique','actif','','',''),
(146, 512, 'OM', 'OMN', 'Oman', 'Oman','actif','','',''),
(147, 516, 'NA', 'NAM', 'Namibia', 'Namibie','actif','','',''),
(148, 520, 'NR', 'NRU', 'Nauru', 'Nauru','actif','','',''),
(149, 524, 'NP', 'NPL', 'Nepal', 'N�pal','actif','','',''),
(150, 528, 'NL', 'NLD', 'Netherlands', 'Pays-Bas','actif','','',''),
(151, 530, 'AN', 'ANT', 'Netherlands Antilles', 'Antilles N�erlandaises','actif','','',''),
(152, 533, 'AW', 'ABW', 'Aruba', 'Aruba','actif','','',''),
(153, 540, 'NC', 'NCL', 'New Caledonia', 'Nouvelle-Cal�donie','actif','','',''),
(154, 548, 'VU', 'VUT', 'Vanuatu', 'Vanuatu','actif','','',''),
(155, 554, 'NZ', 'NZL', 'New Zealand', 'Nouvelle-Z�lande','actif','','',''),
(156, 558, 'NI', 'NIC', 'Nicaragua', 'Nicaragua','actif','','',''),
(157, 562, 'NE', 'NER', 'Niger', 'Niger','actif','','',''),
(158, 566, 'NG', 'NGA', 'Nigeria', 'Nig�ria','actif','','',''),
(159, 570, 'NU', 'NIU', 'Niue', 'Niu�','actif','','',''),
(160, 574, 'NF', 'NFK', 'Norfolk Island', '�le Norfolk','actif','','',''),
(161, 578, 'NO', 'NOR', 'Norway', 'Norv�ge','actif','','',''),
(162, 580, 'MP', 'MNP', 'Northern Mariana Islands', '�les Mariannes du Nord','actif','','',''),
(163, 581, 'UM', 'UMI', 'United States Minor Outlying Islands', '�les Mineures �loign�es des �tats-Unis','actif','','',''),
(164, 583, 'FM', 'FSM', 'Federated States of Micronesia', '�tats F�d�r�s de Micron�sie','actif','','',''),
(165, 584, 'MH', 'MHL', 'Marshall Islands', '�les Marshall','actif','','',''),
(166, 585, 'PW', 'PLW', 'Palau', 'Palaos','actif','','',''),
(167, 586, 'PK', 'PAK', 'Pakistan', 'Pakistan','actif','','',''),
(168, 591, 'PA', 'PAN', 'Panama', 'Panama','actif','','',''),
(169, 598, 'PG', 'PNG', 'Papua New Guinea', 'Papouasie-Nouvelle-Guin�e','actif','','',''),
(170, 600, 'PY', 'PRY', 'Paraguay', 'Paraguay','actif','','',''),
(171, 604, 'PE', 'PER', 'Peru', 'P�rou','actif','','',''),
(172, 608, 'PH', 'PHL', 'Philippines', 'Philippines','actif','','',''),
(173, 612, 'PN', 'PCN', 'Pitcairn', 'Pitcairn','actif','','',''),
(174, 616, 'PL', 'POL', 'Poland', 'Pologne','actif','','',''),
(175, 620, 'PT', 'PRT', 'Portugal', 'Portugal','actif','','',''),
(176, 624, 'GW', 'GNB', 'Guinea-Bissau', 'Guin�e-Bissau','actif','','',''),
(177, 626, 'TL', 'TLS', 'Timor-Leste', 'Timor-Leste','actif','','',''),
(178, 630, 'PR', 'PRI', 'Puerto Rico', 'Porto Rico','actif','','',''),
(179, 634, 'QA', 'QAT', 'Qatar', 'Qatar','actif','','',''),
(180, 638, 'RE', 'REU', 'R�union', 'R�union','actif','','',''),
(181, 642, 'RO', 'ROU', 'Romania', 'Roumanie','actif','','',''),
(182, 643, 'RU', 'RUS', 'Russian Federation', 'F�d�ration de Russie','actif','','',''),
(183, 646, 'RW', 'RWA', 'Rwanda', 'Rwanda','actif','','',''),
(184, 654, 'SH', 'SHN', 'Saint Helena', 'Sainte-H�l�ne','actif','','',''),
(185, 659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Saint-Kitts-et-Nevis','actif','','',''),
(186, 660, 'AI', 'AIA', 'Anguilla', 'Anguilla','actif','','',''),
(187, 662, 'LC', 'LCA', 'Saint Lucia', 'Sainte-Lucie','actif','','',''),
(188, 666, 'PM', 'SPM', 'Saint-Pierre and Miquelon', 'Saint-Pierre-et-Miquelon','actif','','',''),
(189, 670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint-Vincent-et-les Grenadines','actif','','',''),
(190, 674, 'SM', 'SMR', 'San Marino', 'Saint-Marin','actif','','',''),
(191, 678, 'ST', 'STP', 'Sao Tome and Principe', 'Sao Tom�-et-Principe','actif','','',''),
(192, 682, 'SA', 'SAU', 'Saudi Arabia', 'Arabie Saoudite','actif','','',''),
(193, 686, 'SN', 'SEN', 'Senegal', 'S�n�gal','actif','','',''),
(194, 690, 'SC', 'SYC', 'Seychelles', 'Seychelles','actif','','',''),
(195, 694, 'SL', 'SLE', 'Sierra Leone', 'Sierra Leone','actif','','',''),
(196, 702, 'SG', 'SGP', 'Singapore', 'Singapour','actif','','',''),
(197, 703, 'SK', 'SVK', 'Slovakia', 'Slovaquie','actif','','',''),
(198, 704, 'VN', 'VNM', 'Vietnam', 'Viet Nam','actif','','',''),
(199, 705, 'SI', 'SVN', 'Slovenia', 'Slov�nie','actif','','',''),
(200, 706, 'SO', 'SOM', 'Somalia', 'Somalie','actif','','',''),
(201, 710, 'ZA', 'ZAF', 'South Africa', 'Afrique du Sud','actif','','',''),
(202, 716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabwe','actif','','',''),
(203, 724, 'ES', 'ESP', 'Spain', 'Espagne','actif','','',''),
(204, 732, 'EH', 'ESH', 'Western Sahara', 'Sahara Occidental','actif','','',''),
(205, 736, 'SD', 'SDN', 'Sudan', 'Soudan','actif','','',''),
(206, 740, 'SR', 'SUR', 'Suriname', 'Suriname','actif','','',''),
(207, 744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard et�le Jan Mayen','actif','','',''),
(208, 748, 'SZ', 'SWZ', 'Swaziland', 'Swaziland','actif','','',''),
(209, 752, 'SE', 'SWE', 'Sweden', 'Su�de','actif','','',''),
(210, 756, 'CH', 'CHE', 'Switzerland', 'Suisse','actif','','',''),
(211, 760, 'SY', 'SYR', 'Syrian Arab Republic', 'R�publique Arabe Syrienne','actif','','',''),
(212, 762, 'TJ', 'TJK', 'Tajikistan', 'Tadjikistan','actif','','',''),
(213, 764, 'TH', 'THA', 'Thailand', 'Tha�lande','actif','','',''),
(214, 768, 'TG', 'TGO', 'Togo', 'Togo','actif','','',''),
(215, 772, 'TK', 'TKL', 'Tokelau', 'Tokelau','actif','','',''),
(216, 776, 'TO', 'TON', 'Tonga', 'Tonga','actif','','',''),
(217, 780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinit�-et-Tobago','actif','','',''),
(218, 784, 'AE', 'ARE', 'United Arab Emirates', '�mirats Arabes Unis','actif','','',''),
(219, 788, 'TN', 'TUN', 'Tunisia', 'Tunisie','actif','','',''),
(220, 792, 'TR', 'TUR', 'Turkey', 'Turquie','actif','','',''),
(221, 795, 'TM', 'TKM', 'Turkmenistan', 'Turkm�nistan','actif','','',''),
(222, 796, 'TC', 'TCA', 'Turks and Caicos Islands', '�les Turks et Ca�ques','actif','','',''),
(223, 798, 'TV', 'TUV', 'Tuvalu', 'Tuvalu','actif','','',''),
(224, 800, 'UG', 'UGA', 'Uganda', 'Ouganda','actif','','',''),
(225, 804, 'UA', 'UKR', 'Ukraine', 'Ukraine','actif','','',''),
(226, 807, 'MK', 'MKD', 'The Former Yugoslav Republic of Macedonia', 'L''ex-R�publique Yougoslave de Mac�doine','actif','','',''),
(227, 818, 'EG', 'EGY', 'Egypt', '�gypte','actif','','',''),
(228, 826, 'GB', 'GBR', 'United Kingdom', 'Royaume-Uni','actif','','',''),
(229, 833, 'IM', 'IMN', 'Isle of Man', '�le de Man','actif','','',''),
(230, 834, 'TZ', 'TZA', 'United Republic Of Tanzania', 'R�publique-Unie de Tanzanie','actif','','',''),
(231, 840, 'US', 'USA', 'United States', '�tats-Unis','actif','','',''),
(232, 850, 'VI', 'VIR', 'U.S. Virgin Islands', '�les Vierges des �tats-Unis','actif','','',''),
(233, 854, 'BF', 'BFA', 'Burkina Faso', 'Burkina Faso','actif','','',''),
(234, 858, 'UY', 'URY', 'Uruguay', 'Uruguay','actif','','',''),
(235, 860, 'UZ', 'UZB', 'Uzbekistan', 'Ouzb�kistan','actif','','',''),
(236, 862, 'VE', 'VEN', 'Venezuela', 'Venezuela','actif','','',''),
(237, 876, 'WF', 'WLF', 'Wallis and Futuna', 'Wallis et Futuna','actif','','',''),
(238, 882, 'WS', 'WSM', 'Samoa', 'Samoa','actif','','',''),
(239, 887, 'YE', 'YEM', 'Yemen', 'Y�men','actif','','',''),
(240, 891, 'CS', 'SCG', 'Serbia and Montenegro', 'Serbie-et-Mont�n�gro','actif','','',''),
(241, 894, 'ZM', 'ZMB', 'Zambia', 'Zambie','actif','','','');