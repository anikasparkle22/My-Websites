CREATE TABLE plant_data (
    id INTEGER NOT NULL UNIQUE PRIMARY KEY AUTOINCREMENT,
    file_ext TEXT NOT NULL,
    source TEXT NOT NULL,
    plant_id    TEXT NOT NULL UNIQUE,
    plant_name  TEXT NOT NULL UNIQUE,
    plant_genus TEXT NOT NULL,
    pa TEXT NOT NULL,
    fsu INTEGER NOT NULL ,
    psh INTEGER NOT NULL,
    fsh INTEGER NOT NULL,
    hardi TEXT NOT NULL,
    s_ecp   INTEGER NOT NULL,
    s_esp   INTEGER NOT NULL,
    s_pp    INTEGER NOT NULL,
    s_ip    INTEGER NOT NULL,
    s_rp    INTEGER NOT NULL,
    s_ep    INTEGER NOT NULL,
    s_pwr   INTEGER NOT NULL,
    s_bp    INTEGER NOT NULL,
    p_vi    INTEGER NOT NULL,
    c_nss   INTEGER NOT NULL
);

CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL
);

-- copied monkey password
INSERT INTO
  users (id, username, password)
VALUES
  (
    1,
    'admin',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

CREATE TABLE sessions (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE groups (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL UNIQUE
);

INSERT INTO
  groups (id, name)
VALUES
  (1, 'admin');

CREATE TABLE memberships (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  group_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,
  FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO
  memberships (group_id, user_id)
VALUES
  (1, 1);

CREATE TABLE tags (
	id	INTEGER NOT NULL UNIQUE,
	tname	TEXT NOT NULL UNIQUE,
	PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO tags (id, tname)
VALUES (1, 'moss');

INSERT INTO tags (id, tname)
VALUES (2, 'tree');

INSERT INTO tags (id, tname)
VALUES (3, 'flower');

CREATE TABLE plant_tags (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    plant_id INTEGER,
    tag_id INTEGER,
    FOREIGN KEY (plant_id) REFERENCES plant_data(id),
    FOREIGN KEY (tag_id) REFERENCES tags(tid)
 );

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (1,1,1);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (2,2,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (3,3,3);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (4,4,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (5,5,1);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (6,6,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (7,7,1);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (8,8,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (9,9,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (10,10,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (11,11,2);

INSERT INTO plant_tags (id, plant_id, tag_id)
VALUES (12,12,2);



INSERT INTO
    plant_data (id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (1, 'jpg','Original Work', 'FE_15', 'Sheet Moss', 'Hypnum cupressiforme','Neither',0,1,1,'wide variety',   0,  1,  0,  1,  1,0 ,   0,1,1,1 );

INSERT INTO
    plant_data (id, file_ext, source, plant_id, plant_name, plant_genus,pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (2,'jpg','Original Work', 'TR_31', 'Weeping Copper Beech', "Fagus sylvatica 'Purpurea Pendula'",'Perennial',1,1,0,'4-7',  1,  1,  1, 1, 0, 0, 1, 1,1,1);

INSERT INTO
    plant_data (id, file_ext, source, plant_id, plant_name, plant_genus,pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (3, 'jpg','Original Work', 'FL_02', 'Moneyplant', 'Lunaria annua','Annual',1,1,0,'4-9', 0, 1, 1,  1, 0, 0, 0, 1,1,0);

INSERT INTO
    plant_data (id, file_ext, source,plant_id, plant_name, plant_genus,pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (4, 'jpg','Original Work', 'TR_27', 'Redbud Tree', 'Cercis canadensis','Perennial',1,1,0,'4-8', 1, 1,  1, 1, 0, 0, 0, 1,1,0);

INSERT INTO
    plant_data (id, file_ext, source, plant_id, plant_name, plant_genus,pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (5, 'jpg','Original Work', 'FE_17', 'American Tree Moss', 'Climacium americanum','Annual',0,1,1,'2-10', 0, 1,  0, 1, 1, 0, 0, 1,1,1);

INSERT INTO
    plant_data (id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (6, 'jpg','Original Work', 'FL_07', 'Narrow Sundrops', 'Oneothera fruticosa','Perennial',1,1,0,'4-8', 0,   1,  1, 1, 0, 0, 0, 1,1,0);

INSERT INTO
    plant_data (id, file_ext, source, plant_id, plant_name, plant_genus,pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (7, 'jpg','Original Work','FE_14', 'Broom Moss', 'Dicranum scoparium','Neither',0,1,1,'4-10', 0,  1,  1, 1, 1, 0, 0, 1,1, 1);

INSERT INTO
    plant_data(id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (8, 'jpg','Info 2300 folder','TR_22','Black Gum', 'Nyssa sylvatica','Perennial',1,1,1,'4-9', 1,  1,  1, 0,0, 0, 0, 1,1,0);

INSERT INTO
    plant_data(id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (9, 'jpg','Info 2300 folder','TR_11','Saucer Magnolia', 'Magnolia soulangiana','Neither',1,1,0,'5-9', 1,  1,  1, 1,0, 0, 0, 1,1,0);

INSERT INTO
    plant_data(id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (10, 'jpg','Info 2300 folder','GA_08','Northern Sea Oats', 'Chasmanthium latifolium','Perennial',0,1,1,'5-8', 1,  1,  1, 0,0, 0, 1, 1,0,0);

INSERT INTO
    plant_data(id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (11, 'jpg','Info 2300 folder','SH_20','Highbush Blueberry', 'Vaccinium corymbosom','Perennial',0,1,1,'5-8', 1,  1,  1, 0,0, 0, 1, 1,1,0);

INSERT INTO
    plant_data(id, file_ext, source, plant_id, plant_name, plant_genus, pa, fsu, psh, fsh, hardi, s_ecp, s_esp, s_pp, s_ip, s_rp, s_ep, s_pwr, s_bp, p_vi, c_nss)
VALUES
    (12, 'jpg','Info 2300 folder','TR_03','Eastern White Pine', 'Pinus strobus','Perennial',0,1,1,'4-9', 1,  1,  0, 1,0, 0, 1, 1,1,1);
