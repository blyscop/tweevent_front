# --------------------------------------------------------
# Rajout des modules autorises. 
# --------------------------------------------------------
INSERT INTO %%prefix%%sys_groupes_modules VALUES 
('admin', 'annuaire'),
('admin', 'articles'),
('admin', 'site'),
('admin', 'news'),
('utilisateur', 'annuaire');
