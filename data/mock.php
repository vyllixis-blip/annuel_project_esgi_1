<?php
/*
** ESGI PROJECT, 2025
** data/mock.php
** File description:
** Centralised mock data — swap each array with real DB calls
*/

/* ═══ GAMES ════════════════════════════════════════════════════ */
$GAMES = [
    ['id'=>1,  'title'=>"Elden Ring",          'genre'=>"Action-RPG",    'year'=>2022,'rating'=>9.8,'emoji'=>'⚔️', 'studio'=>'FromSoftware',    'badge'=>['label'=>'GOTY',      'type'=>'warm'],   'description'=>"Une vaste terre de l'entre-deux vous attend. Explorez des donjons, affrontez des boss titanesques et forgez votre légende dans ce RPG en monde ouvert signé FromSoftware et George R.R. Martin.",'gradient'=>'linear-gradient(135deg,#1a0a00,#3d1a00,#2d0a0a)','tags'=>['open-world','souls','dark-fantasy'],'plays'=>'12.4M','new'=>false],
    ['id'=>2,  'title'=>"Cyberpunk 2077",       'genre'=>"RPG",           'year'=>2020,'rating'=>8.4,'emoji'=>'🌆','studio'=>'CD Projekt Red',   'badge'=>['label'=>'POPULAIRE', 'type'=>'primary'], 'description'=>"Incarnez V dans la mégacité de Night City. Un monde overt cyberpunk regorgeant d'histoires, de décisions morales et de combats nerveux.",'gradient'=>'linear-gradient(135deg,#00030a,#0a0a1e,#0a1a1e)','tags'=>['cyberpunk','open-world','fps'],'plays'=>'8.1M','new'=>false],
    ['id'=>3,  'title'=>"Hollow Knight",        'genre'=>"Metroidvania",  'year'=>2017,'rating'=>9.1,'emoji'=>'🦋','studio'=>'Team Cherry',      'badge'=>['label'=>'INDIE GEM', 'type'=>'accent'],  'description'=>"Explorez un vaste royaume souterrain d'insectes, dans ce metroidvania indie de la Team Cherry : ambiance, gameplay fluide et boss mémorables.",'gradient'=>'linear-gradient(135deg,#0a001f,#120023,#0a0a1a)','tags'=>['indie','metroidvania','hard'],'plays'=>'3.2M','new'=>false],
    ['id'=>4,  'title'=>"Baldur's Gate 3",      'genre'=>"RPG",           'year'=>2023,'rating'=>9.6,'emoji'=>'🧙','studio'=>'Larian Studios',   'badge'=>['label'=>'GOTY 2023','type'=>'warm'],    'description'=>"Le RPG ultime basé sur D&D 5e. Des choix qui comptent vraiment, une narration extraordinaire et une liberté de jeu quasi infinie.",'gradient'=>'linear-gradient(135deg,#1a0a00,#2d1500)','tags'=>['rpg','dnd','co-op'],'plays'=>'9.7M','new'=>true],
    ['id'=>5,  'title'=>"Alan Wake 2",          'genre'=>"Survival Horror",'year'=>2023,'rating'=>8.8,'emoji'=>'🔦','studio'=>'Remedy Entertainment','badge'=>['label'=>'NARRATIF','type'=>'accent'],  'description'=>"Alan Wake revient dans une suite ambitieuse mélangeant réalité et fiction, survival horror et narration cinématique.",'gradient'=>'linear-gradient(135deg,#00090a,#001520)','tags'=>['horror','narrative','thriller'],'plays'=>'2.1M','new'=>true],
    ['id'=>6,  'title'=>"Spider-Man 2",         'genre'=>"Action-Adv.",   'year'=>2023,'rating'=>9.0,'emoji'=>'🕷️','studio'=>'Insomniac Games',  'badge'=>['label'=>'EXCLUSIF',  'type'=>'primary'], 'description'=>"Peter Parker et Miles Morales patroller New York dans une aventure grandiose avec le Symbionte comme antagoniste central.",'gradient'=>'linear-gradient(135deg,#1a0000,#3d0000)','tags'=>['action','superhero','open-world'],'plays'=>'5.4M','new'=>true],
    ['id'=>7,  'title'=>"Starfield",            'genre'=>"RPG",           'year'=>2023,'rating'=>7.5,'emoji'=>'🚀','studio'=>'Bethesda',          'badge'=>['label'=>'SCI-FI',    'type'=>'accent'],  'description'=>"Explorez plus de 1000 planètes dans le vaste univers de Starfield, le NASA-punk RPG de Bethesda.",'gradient'=>'linear-gradient(135deg,#000010,#000828)','tags'=>['space','rpg','exploration'],'plays'=>'6.8M','new'=>true],
    ['id'=>8,  'title'=>"Lies of P",            'genre'=>"Soulslike",     'year'=>2023,'rating'=>8.1,'emoji'=>'🎭','studio'=>'Round8 Studio',     'badge'=>['label'=>'SOULSLIKE', 'type'=>'primary'], 'description'=>"Basé sur Pinocchio, ce soulslike coréen surprend par sa qualité : paradoxe du mensonge, personnages attachants et boss variés.",'gradient'=>'linear-gradient(135deg,#0a0500,#1a1000)','tags'=>['soulslike','dark','steampunk'],'plays'=>'1.5M','new'=>true],
    ['id'=>9,  'title'=>"The Witcher 3",        'genre'=>"RPG",           'year'=>2015,'rating'=>9.8,'emoji'=>'🗡️','studio'=>'CD Projekt Red',   'badge'=>['label'=>'LÉGENDAIRE','type'=>'warm'],    'description'=>"L'un des plus grands RPG de tous les temps. Geralt de Riv parcourt un monde vivant pour retrouver Ciri, avec des choix narratifs impactants.",'gradient'=>'linear-gradient(135deg,#001a00,#0a2800)','tags'=>['rpg','open-world','dark-fantasy'],'plays'=>'28M','new'=>false],
    ['id'=>10, 'title'=>"God of War (2018)",    'genre'=>"Action-Adv.",   'year'=>2018,'rating'=>9.7,'emoji'=>'🪓','studio'=>'Santa Monica Studio','badge'=>['label'=>'CHEF-D\'ŒUVRE','type'=>'warm'],'description'=>"Kratos et son fils Atreus traversent les royaumes nordiques dans une aventure épique, intime et visuellement somptueuse.",'gradient'=>'linear-gradient(135deg,#200000,#3d0000)','tags'=>['action','mythology','story'],'plays'=>'19M','new'=>false],
    ['id'=>11, 'title'=>"Red Dead Redemption 2",'genre'=>"Open-World",    'year'=>'2018','rating'=>9.7,'emoji'=>'🤠','studio'=>'Rockstar Games',  'badge'=>['label'=>'CULTE',     'type'=>'warm'],    'description'=>"La vie de hors-la-loi du Far West dans l'une des simulations les plus réalistes jamais créées. Arthur Morgan, une tragédie inoubliable.",'gradient'=>'linear-gradient(135deg,#1a0a00,#2d1500)','tags'=>['open-world','western','story'],'plays'=>'22M','new'=>false],
    ['id'=>12, 'title'=>"Hades",                'genre'=>"Roguelike",     'year'=>2020,'rating'=>9.4,'emoji'=>'⚡','studio'=>'Supergiant Games',  'badge'=>['label'=>'ADDICTIF',  'type'=>'primary'], 'description'=>"Fuyez l'Hadès dans ce roguelike ultra-dynamique de Supergiant, où chaque run enrichit l'histoire grâce à une narration progressive unique.",'gradient'=>'linear-gradient(135deg,#1a0000,#2d0a00)','tags'=>['roguelike','hack-and-slash','indie'],'plays'=>'7.3M','new'=>false],
    ['id'=>13, 'title'=>"Celeste",              'genre'=>"Platformer",    'year'=>2018,'rating'=>9.3,'emoji'=>'🏔️','studio'=>'Maddy Thorson',    'badge'=>['label'=>'INDIE',     'type'=>'accent'],  'description'=>"Aidez Madeline à gravir la montagne Celeste dans ce platformer de précision émouvant qui traite de la santé mentale avec subtilité et bienveillance.",'gradient'=>'linear-gradient(135deg,#00001a,#000028)','tags'=>['indie','platformer','challenge'],'plays'=>'4.1M','new'=>false],
    ['id'=>14, 'title'=>"Disco Elysium",        'genre'=>"RPG",           'year'=>2019,'rating'=>9.6,'emoji'=>'🕵️','studio'=>'ZA/UM',            'badge'=>['label'=>'NARRATIF',  'type'=>'accent'],  'description'=>"Un RPG textuel sans combat où vous incarnez un détective amnésique résolvant un meurtre dans une ville post-révolutionnaire étrange et magnifique.",'gradient'=>'linear-gradient(135deg,#0a001a,#150028)','tags'=>['rpg','narrative','detective'],'plays'=>'2.9M','new'=>false],
    ['id'=>15, 'title'=>"Dark Souls III",       'genre'=>"Soulslike",     'year'=>2016,'rating'=>9.5,'emoji'=>'🔥','studio'=>'FromSoftware',      'badge'=>['label'=>'DIFFICILE', 'type'=>'primary'], 'description'=>"Le troisième opus de la saga Dark Souls. Maîtrisez un combat exigeant, explorez un monde interconnecté et triomphez face à des boss légendaires.",'gradient'=>'linear-gradient(135deg,#0a0000,#200000)','tags'=>['soulslike','dark-fantasy','hard'],'plays'=>'10.2M','new'=>false],
    ['id'=>16, 'title'=>"Sekiro",               'genre'=>"Action",         'year'=>2019,'rating'=>9.4,'emoji'=>'🥷','studio'=>'FromSoftware',      'badge'=>['label'=>'GOTY 2019','type'=>'warm'],    'description'=>"Shinobi du Japon féodal, maîtrisez la déviation et le shinobi-art dans ce jeu d'action FromSoftware qui redéfinit le combat au katana.",'gradient'=>'linear-gradient(135deg,#0a0500,#1a0a00)','tags'=>['action','japan','soulslike'],'plays'=>'8.5M','new'=>false],
];

/* ═══ CATEGORIES ════════════════════════════════════════════════ */
$CATEGORIES = [
    ['id'=>1,'slug'=>'rpg',        'name'=>'RPG',         'icon'=>'⚔️', 'count'=>214,'class'=>'cat-rpg',        'color'=>'#7c3aed','description'=>"Jeux de rôle riches en histoire, développement de personnage et univers profonds."],
    ['id'=>2,'slug'=>'action',     'name'=>'Action',      'icon'=>'💥', 'count'=>386,'class'=>'cat-action',     'color'=>'#ef4444','description'=>"Combats nerveux, réflexes et gameplay intense pour les amateurs d'adrénaline."],
    ['id'=>3,'slug'=>'strategy',   'name'=>'Stratégie',   'icon'=>'🧠', 'count'=>142,'class'=>'cat-strategy',   'color'=>'#06b6d4','description'=>"Réfléchissez avant d'agir : gestion, tactique et planification à long terme."],
    ['id'=>4,'slug'=>'sport',      'name'=>'Sport',       'icon'=>'⚽', 'count'=>98, 'class'=>'cat-sport',      'color'=>'#22c55e','description'=>"Simulation sportive réaliste ou arcade, football, basket, course et plus."],
    ['id'=>5,'slug'=>'horror',     'name'=>'Horreur',     'icon'=>'👻', 'count'=>87, 'class'=>'cat-horror',     'color'=>'#a855f7','description'=>"Frissons garantis : survival horror, ambiance oppressante et monstres mémorables."],
    ['id'=>6,'slug'=>'indie',      'name'=>'Indépendant', 'icon'=>'🎮', 'count'=>321,'class'=>'cat-indie',      'color'=>'#f59e0b','description'=>"Jeux indépendants innovants, souvent porteurs des idées les plus fraîches du medium."],
    ['id'=>7,'slug'=>'adventure',  'name'=>'Aventure',    'icon'=>'🗺️', 'count'=>178,'class'=>'cat-adventure',  'color'=>'#10b981','description'=>"Explorez des mondes, résolvez des enigmes et vivez des épopées mémorables."],
    ['id'=>8,'slug'=>'simulation', 'name'=>'Simulation',  'icon'=>'🏗️', 'count'=>112,'class'=>'cat-simulation', 'color'=>'#3b82f6','description'=>"Pilotez, gérez, construisez : des simulations fidèles à la réalité ou totalement fantaisistes."],
    ['id'=>9,'slug'=>'soulslike',  'name'=>'Soulslike',   'icon'=>'💀', 'count'=>43, 'class'=>'cat-rpg',        'color'=>'#6b7280','description'=>"Challenge extrême, mort permanente et satisfaction incomparable quand vous triomphez."],
    ['id'=>10,'slug'=>'platformer','name'=>'Platformer',  'icon'=>'🏃', 'count'=>167,'class'=>'cat-indie',      'color'=>'#f59e0b','description'=>"Sauts de précision, niveaux créatifs et gameplay accessible mais profond."],
    ['id'=>11,'slug'=>'fps',       'name'=>'FPS',         'icon'=>'🔫', 'count'=>198,'class'=>'cat-action',     'color'=>'#ef4444','description'=>"First-person shooter : précision, rapidité et tension à la première personne."],
    ['id'=>12,'slug'=>'roguelike', 'name'=>'Roguelike',   'icon'=>'🎲', 'count'=>89, 'class'=>'cat-strategy',  'color'=>'#06b6d4','description'=>"Runs procéduraux, mort permanente et progression méta : chaque partie est unique."],
];

/* ═══ MOCK REVIEWS ════════════════════════════════════════════ */
$REVIEWS = [
    ['author'=>'KronosX',    'avatar'=>'👾','rating'=>10,'date'=>'15 Mar 2024','text'=>"Elden Ring est tout simplement le meilleur jeu que j'ai jamais joué. La liberté d'exploration est inégalée."],
    ['author'=>'PixelHunter','avatar'=>'🎯','rating'=>9, 'date'=>'02 Jan 2024','text'=>"Un chef-d'œuvre visuel et narratif. Quelques bugs à la sortie mais rien qui gâche l'expérience globale."],
    ['author'=>'NightWolf_',  'avatar'=>'🐺','rating'=>10,'date'=>'28 Fév 2024','text'=>"La direction artistique est stupéfiante. Chaque zone est unique et raconte une histoire à travers son environment design."],
    ['author'=>'CasualGamer', 'avatar'=>'🕹️','rating'=>8, 'date'=>'10 Avr 2024','text'=>"Excellent jeu mais peut être intimidant pour les nouveaux. Une fois accroché, impossible de décrocher !"],
];

/* ═══ MOCK COLLECTIONS ════════════════════════════════════════ */
$COLLECTIONS = [
    ['id'=>1,'name'=>'Games of the Year','description'=>"Les meilleurs jeux de chaque année sélectionnés avec soin.",'count'=>12,'author'=>'GameLib Team','emoji'=>'🏆','public'=>true],
    ['id'=>2,'name'=>'Indés Incontournables','description'=>"Les jeux indépendants qui ont révolutionné leur genre.",'count'=>24,'author'=>'PixelHunter','emoji'=>'💎','public'=>true],
    ['id'=>3,'name'=>'Challenge Accepted','description'=>"Les jeux les plus difficiles pour les masochistes du gaming.",'count'=>8,'author'=>'KronosX','emoji'=>'💀','public'=>true],
    ['id'=>4,'name'=>'Histoire Avant Tout','description'=>"Des jeux où la narration prime. Préparez les mouchoirs.",'count'=>16,'author'=>'NightWolf_','emoji'=>'📖','public'=>true],
    ['id'=>5,'name'=>'Ma Collection','description'=>"Ma bibliothèque personnelle.",'count'=>31,'author'=>'Vous','emoji'=>'🎮','public'=>false],
];

/* ═══ STATS ════════════════════════════════════════════════════ */
$STATS = [
    ['value'=>'1 400+','label'=>'Jeux catalogués'],
    ['value'=>'48 K',  'label'=>'Membres actifs'],
    ['value'=>'92 K',  'label'=>'Critiques publiées'],
    ['value'=>'220+',  'label'=>'Catégories'],
];
