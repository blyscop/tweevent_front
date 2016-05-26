CREATE TABLE %%prefix%%sys_ip_autorisations (
  id_groupe int(10) NOT NULL default '0',
  adresse_ip varchar(15) NOT NULL default '',
  effacable enum('0','1') NOT NULL default '1'
) ENGINE=MyISAM;


INSERT INTO %%prefix%%sys_ip_autorisations VALUES (1, '127.0.0.1', '0');
INSERT INTO %%prefix%%sys_ip_autorisations VALUES (2, '127.0.0.2', '0');
INSERT INTO %%prefix%%sys_ip_autorisations VALUES (2, '*', '1');
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_ip_interdictions (
  nom_utilisateur varchar(50) NOT NULL default '',
  adresse_ip varchar(15) NOT NULL default '',
  nb_tentatives tinyint(2) NOT NULL default '0',
  date_add varchar(15) NOT NULL default '',
  date_upd varchar(15) NOT NULL default ''
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_evenements (
  id_evenement int(10) NOT NULL auto_increment,
  id_utilisateur int(10) NOT NULL default '0',
  id_pere int(10) default '0',
  type_pere varchar(32) default NULL,
  date_evenement int(24) NOT NULL default '0',
  type_evenement varchar(32) NOT NULL default '',
  info_evenement text,
  PRIMARY KEY  (id_evenement)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_groupes (
  id_groupe int(11) NOT NULL auto_increment,
  nom_groupe varchar(32) NOT NULL default '',
  nb_connect_defaut int(11) NOT NULL default '1',
  effacable enum('0','1') NOT NULL default '1',
  modifiable enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (id_groupe)
) ENGINE=MyISAM;

INSERT INTO %%prefix%%sys_groupes VALUES 
(1, 'system', 1, '0', '0'),
(2, 'admin', 10, '0', '1'),
(3, 'utilisateur', 10, '1', '1');

# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_groupes_modules (
  nom_groupe varchar(32) NOT NULL default '0',
  module varchar(64) NOT NULL default ''
) ENGINE=MyISAM;

INSERT INTO %%prefix%%sys_groupes_modules VALUES ('admin', 'admin');
INSERT INTO %%prefix%%sys_groupes_modules VALUES ('system', 'systeme');
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_groupes_droits (
  nom_groupe varchar(64) NOT NULL default '',
  champ varchar(64) NOT NULL default '',
  droits int(11) NOT NULL default '0'
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_parametres (
  id_utilisateur int(10) NOT NULL default '1',
  code_parametre varchar(32) NOT NULL default '',
  type_parametre enum('materiel') NOT NULL default 'materiel',
  designation varchar(64) default NULL,
  etat enum('actif','inactif') NOT NULL default 'actif',
  info_parametre text,
  PRIMARY KEY  (code_parametre,id_utilisateur)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_utilisateurs (
  id_utilisateur int(10) NOT NULL auto_increment,
  code_utilisateur varchar(16) NOT NULL default '',
  nom_groupe varchar(32) NOT NULL default '0',
  nom_utilisateur varchar(50) NOT NULL default '',
  password varchar(200) NOT NULL default '',
  nb_connect tinyint(2) NOT NULL default '0',
  etat enum('attente_activation','actif','inactif') NOT NULL default 'attente_activation',
  lang varchar(16) NOT NULL default 'fr',
  effacable enum('0','1') NOT NULL default '1',
  modifiable enum('0','1') NOT NULL default '1',
  info_utilisateur text,
  PRIMARY KEY  (id_utilisateur)
) ENGINE=MyISAM;
# --------------------------------------------------------
CREATE TABLE %%prefix%%sys_utilisateurs_droits (
  id_utilisateur int(11) NOT NULL DEFAULT '0',
  champ varchar(64) NOT NULL DEFAULT '',
  droits int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM;

INSERT INTO %%prefix%%sys_utilisateurs VALUES 
(1, '', 'system', 'system', 'system', 1, 'actif', 'fr', '0', '0', NULL),
(2, '', 'admin', 'admin', 'admin', 30, 'actif', 'fr', '0', '1', NULL),
(3, '', 'utilisateur', 'util', 'util', 30, 'actif', 'fr', '0', '1', NULL);

CREATE TABLE IF NOT EXISTS %%prefix%%sys_rewriting (
  `url_externe` text NOT NULL,
  `url_interne` text NOT NULL
) ENGINE=MyISAM;
# --------------------------------------------------------