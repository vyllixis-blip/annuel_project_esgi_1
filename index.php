<?php
session_start();

/* ─── Mock data – replace with real DB calls ─────────────────────── */
$featured_games = [
    [
        'id'          => 1,
        'title'       => 'Elden Ring',
        'genre'       => 'Action-RPG',
        'description' => 'Une vaste terre de l\'entre-deux attend votre exploration dans ce chef-d\'œuvre de FromSoftware.',
        'year'        => 2022,
        'rating'      => 9.8,
        'badge'       => ['label' => 'GOTY', 'type' => 'warm'],
        'emoji'       => '⚔️',
        'gradient'    => 'linear-gradient(135deg, #1a0a00, #3d1a00, #2d0a0a)',
        'plays'       => '12.4M',
    ],
    [
        'id'          => 2,
        'title'       => 'Cyberpunk 2077',
        'genre'       => 'RPG',
        'description' => 'Plongez dans la mégacité de Night City, un monde ouvert futuriste sans limites.',
        'year'        => 2020,
        'rating'      => 8.4,
        'badge'       => ['label' => 'POPULAIRE', 'type' => 'primary'],
        'emoji'       => '🌆',
        'gradient'    => 'linear-gradient(135deg, #00030a, #0a0a1e, #0a1a1e)',
    ],
    [
        'id'          => 3,
        'title'       => 'Hollow Knight',
        'genre'       => 'Metroidvania',
        'description' => 'Explorez un vaste royaume souterrain d\'insectes dans cet incroyable jeu indépendant.',
        'year'        => 2017,
        'rating'      => 9.1,
        'badge'       => ['label' => 'INDIE GEM', 'type' => 'accent'],
        'emoji'       => '🦋',
        'gradient'    => 'linear-gradient(135deg, #0a001f, #120023, #0a0a1a)',
    ],
];

$latest_games = [
    ['title' => 'Baldur\'s Gate 3', 'genre' => 'RPG',       'emoji' => '🧙', 'year' => 2023, 'rating' => 9.6, 'gradient' => 'linear-gradient(135deg, #1a0a00, #2d1500)'],
    ['title' => 'Alan Wake 2',      'genre' => 'Survival',  'emoji' => '🔦', 'year' => 2023, 'rating' => 8.8, 'gradient' => 'linear-gradient(135deg, #00090a, #001520)'],
    ['title' => 'Spider-Man 2',     'genre' => 'Action',    'emoji' => '🕷️', 'year' => 2023, 'rating' => 9.0, 'gradient' => 'linear-gradient(135deg, #1a0000, #3d0000)'],
    ['title' => 'Starfield',        'genre' => 'RPG',       'emoji' => '🚀', 'year' => 2023, 'rating' => 7.5, 'gradient' => 'linear-gradient(135deg, #000010, #000828)'],
    ['title' => 'Lies of P',        'genre' => 'Soulslike', 'emoji' => '🎭', 'year' => 2023, 'rating' => 8.1, 'gradient' => 'linear-gradient(135deg, #0a0500, #1a1000)'],
    ['title' => 'Remnant II',       'genre' => 'Shooter',   'emoji' => '🔫', 'year' => 2023, 'rating' => 8.4, 'gradient' => 'linear-gradient(135deg, #001000, #001500)'],
];

$top_games = [
    ['title' => 'The Witcher 3',   'genre' => 'RPG',         'emoji' => '🗡️', 'year' => 2015, 'rating' => 9.8, 'badge' => 'LÉGENDAIRE',  'gradient' => 'linear-gradient(135deg, #001a00, #0a2800)'],
    ['title' => 'God of War',      'genre' => 'Action-Adv.', 'emoji' => '🪓', 'year' => 2018, 'rating' => 9.7, 'badge' => 'CHEF-D\'ŒUVRE','gradient' => 'linear-gradient(135deg, #200000, #3d0000)'],
    ['title' => 'Red Dead 2',      'genre' => 'Open-World',  'emoji' => '🤠', 'year' => 2018, 'rating' => 9.7, 'badge' => 'CULTE',        'gradient' => 'linear-gradient(135deg, #1a0a00, #2d1500)'],
    ['title' => 'Dark Souls III',  'genre' => 'Soulslike',   'emoji' => '🔥', 'year' => 2016, 'rating' => 9.5, 'badge' => 'DIFFICILE',     'gradient' => 'linear-gradient(135deg, #0a0000, #200000)'],
    ['title' => 'Half-Life: Alyx', 'genre' => 'FPS / VR',   'emoji' => '🥽', 'year' => 2020, 'rating' => 9.3, 'badge' => 'VR',            'gradient' => 'linear-gradient(135deg, #001a10, #00280a)'],
    ['title' => 'Disco Elysium',   'genre' => 'RPG',         'emoji' => '🕵️', 'year' => 2019, 'rating' => 9.6, 'badge' => 'NARRATIF',      'gradient' => 'linear-gradient(135deg, #0a001a, #150028)'],
    ['title' => 'Hades',           'genre' => 'Roguelike',   'emoji' => '⚡', 'year' => 2020, 'rating' => 9.4, 'badge' => 'ADDICTIF',      'gradient' => 'linear-gradient(135deg, #1a0000, #2d0a00)'],
    ['title' => 'Celeste',         'genre' => 'Platformer',  'emoji' => '🏔️', 'year' => 2018, 'rating' => 9.3, 'badge' => 'INDIE',         'gradient' => 'linear-gradient(135deg, #00001a, #000028)'],
];

$categories = [
    ['name' => 'RPG',        'icon' => '⚔️',  'count' => 214, 'class' => 'cat-rpg',       'slug' => 'rpg'],
    ['name' => 'Action',     'icon' => '💥',  'count' => 386, 'class' => 'cat-action',    'slug' => 'action'],
    ['name' => 'Stratégie',  'icon' => '🧠',  'count' => 142, 'class' => 'cat-strategy',  'slug' => 'strategy'],
    ['name' => 'Sport',      'icon' => '⚽',  'count' => 98,  'class' => 'cat-sport',     'slug' => 'sport'],
    ['name' => 'Horreur',    'icon' => '👻',  'count' => 87,  'class' => 'cat-horror',    'slug' => 'horror'],
    ['name' => 'Indépendant','icon' => '🎮',  'count' => 321, 'class' => 'cat-indie',     'slug' => 'indie'],
    ['name' => 'Aventure',   'icon' => '🗺️',  'count' => 178, 'class' => 'cat-adventure', 'slug' => 'adventure'],
    ['name' => 'Simulation', 'icon' => '🏗️',  'count' => 112, 'class' => 'cat-simulation','slug' => 'simulation'],
];

$stats = [
    ['value' => '1 400+', 'label' => 'Jeux catalogués'],
    ['value' => '48 K',   'label' => 'Membres actifs'],
    ['value' => '92 K',   'label' => 'Critiques publiées'],
    ['value' => '220+',   'label' => 'Catégories'],
];

/* ─── Helpers ────────────────────────────────────────────────────── */
function renderStars(float $rating): string {
    $full  = (int) floor($rating / 2);
    $half  = ($rating / 2 - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    $html  = '<div class="star-rating">';
    for ($i = 0; $i < $full;  $i++) $html .= '<span class="star">★</span>';
    if ($half)                        $html .= '<span class="star" style="opacity:.5">★</span>';
    for ($i = 0; $i < $empty; $i++) $html .= '<span class="star-empty">★</span>';
    $html .= '</div>';
    return $html;
}

function badgeClass(string $type): string {
    return match($type) {
        'warm'    => 'badge-warm',
        'accent'  => 'badge-accent',
        'new'     => 'badge-new',
        default   => 'badge-primary',
    };
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameLib — Votre Bibliothèque de Jeux Vidéo</title>
    <meta name="description" content="Découvrez, cataloguez et partagez votre bibliothèque de jeux vidéo. Plus de 1 400 jeux référencés par la communauté.">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<!-- ═══════════════════════════════════════════════
     NAVBAR
════════════════════════════════════════════════ -->
<nav class="navbar">
    <div class="container">
        <div class="logo">
            <h1><a href="index.php">GameLib</a></h1>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Accueil</a></li>
            <li><a href="pages/discover.php">🎯 Découvrir</a></li>
            <li><a href="pages/games.php">Catalogue</a></li>
            <li><a href="pages/categories.php">Catégories</a></li>
            <li><a href="pages/collections.php">Collections</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="pages/profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="pages/login.php">Connexion</a></li>
                <li><a href="pages/register.php" class="btn-nav-cta">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- ═══════════════════════════════════════════════
     HERO
════════════════════════════════════════════════ -->
<section class="hero">
    <div class="hero-bg-grid"></div>
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>

    <div class="container">
        <div class="hero-content">

            <!-- Left column: copy + search -->
            <div class="hero-text">
                <div class="hero-eyebrow">
                    <div class="hero-eyebrow-line"></div>
                    <span>Votre Bibliothèque Gaming</span>
                </div>

                <h1 class="hero-title">
                    Trouvez votre<br>
                    Prochain Jeu<br>
                    <span class="gradient-text">Parfait</span>
                </h1>

                <p class="hero-description">
                    Perdu dans la jungle des jeux vidéo ? Notre système intelligent de recommandation 
                    vous aide à trouver <strong>exactement le jeu</strong> que vous cherchez selon votre 
                    difficulté préférée, style graphique et public cible.
                </p>

                <!-- Search -->
                <div class="hero-search">
                    <form action="pages/discover.php" method="GET">
                        <svg class="hero-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input
                            type="text"
                            name="q"
                            class="hero-search-input"
                            placeholder="Chercher un jeu par titre, genre..."
                            autocomplete="off"
                        >
                        <button type="submit" class="hero-search-btn">Chercher</button>
                    </form>
                </div>

                <!-- Quick tags -->
                <div class="hero-tags">
                    <?php
                    $tags = ['Action RPG', 'Pixelart', 'Facile', 'Sandbox', 'Story-driven', 'Multijoueur', 'Gratuit'];
                    foreach ($tags as $tag):
                    ?>
                        <a href="pages/discover.php?q=<?php echo urlencode($tag); ?>" class="hero-tag"><?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach; ?>
                </div>

                <!-- CTA -->
                <div class="hero-actions">
                    <a href="pages/discover.php" class="btn-primary">
                        🎯 Commencer la Découverte
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="pages/register.php" class="btn-secondary">
                        Créer un compte
                    </a>
                </div>
            </div>

            <!-- Right column: stacked cards visual -->
            <div class="hero-visual">
                <div class="hero-cards-stack">

                    <!-- Background cards -->
                    <div class="hero-game-card hero-game-card-side2">
                        <div class="hero-game-card-img-placeholder" style="background:<?php echo htmlspecialchars($featured_games[2]['gradient']); ?>">
                            <?php echo $featured_games[2]['emoji']; ?>
                        </div>
                        <div class="hero-game-card-body">
                            <h4><?php echo htmlspecialchars($featured_games[2]['title']); ?></h4>
                        </div>
                    </div>

                    <div class="hero-game-card hero-game-card-side1">
                        <div class="hero-game-card-img-placeholder" style="background:<?php echo htmlspecialchars($featured_games[1]['gradient']); ?>">
                            <?php echo $featured_games[1]['emoji']; ?>
                        </div>
                        <div class="hero-game-card-body">
                            <h4><?php echo htmlspecialchars($featured_games[1]['title']); ?></h4>
                        </div>
                    </div>

                    <!-- Main card -->
                    <div class="hero-game-card hero-game-card-main">
                        <div class="hero-game-card-img-placeholder" style="background:<?php echo htmlspecialchars($featured_games[0]['gradient']); ?>">
                            <?php echo $featured_games[0]['emoji']; ?>
                        </div>
                        <div class="hero-game-card-body">
                            <p class="game-card-genre"><?php echo htmlspecialchars($featured_games[0]['genre']); ?></p>
                            <h4><?php echo htmlspecialchars($featured_games[0]['title']); ?></h4>
                            <div class="hero-game-card-footer">
                                <?php echo renderStars($featured_games[0]['rating']); ?>
                                <span class="rating-score"><?php echo number_format($featured_games[0]['rating'], 1); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating stat cards -->
                    <div class="hero-float-card hero-float-card-1">
                        <div class="hero-float-stat">
                            <div class="hero-float-stat-icon purple">🏆</div>
                            <div class="hero-float-stat-info">
                                <span class="hero-float-stat-value">GOTY 2022</span>
                                <span class="hero-float-stat-label">Elden Ring</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-float-card hero-float-card-2">
                        <div class="hero-float-stat">
                            <div class="hero-float-stat-icon cyan">👥</div>
                            <div class="hero-float-stat-info">
                                <span class="hero-float-stat-value">48 000+</span>
                                <span class="hero-float-stat-label">Membres actifs</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /.hero-content -->
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     STATS STRIP
════════════════════════════════════════════════ -->
<section class="stats-strip">
    <div class="container">
        <div class="stats-strip-grid">
            <?php foreach ($stats as $stat): ?>
            <div class="stat-item">
                <span class="stat-value"><?php echo htmlspecialchars($stat['value']); ?></span>
                <span class="stat-label"><?php echo htmlspecialchars($stat['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     FEATURED GAMES
════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="badge badge-warm" style="margin-bottom:12px;">🔥 À la une</div>
                <h2 class="section-title">Jeux <span>Incontournables</span></h2>
                <p class="section-subtitle">Les titres qui ont marqué l'histoire du jeu vidéo</p>
            </div>
            <a href="pages/games.php?sort=featured" class="section-link">
                Voir tout →
            </a>
        </div>

        <!-- Large featured card + 2 side cards -->
        <div class="featured-grid">

            <!-- Main featured -->
            <?php $main = $featured_games[0]; ?>
            <a href="pages/game.php?id=<?php echo (int)$main['id']; ?>" class="featured-card-large" style="text-decoration:none;color:inherit;">
                <div class="featured-card-bg">
                    <div class="featured-card-bg-gradient" style="background:<?php echo htmlspecialchars($main['gradient']); ?>;"></div>
                    <div class="featured-card-bg-overlay"></div>
                    <span style="position:relative;z-index:1;opacity:0.15;font-size:10rem;"><?php echo $main['emoji']; ?></span>
                </div>
                <div class="featured-card-content">
                    <span class="badge <?php echo badgeClass($main['badge']['type']); ?>" style="margin-bottom:14px;">
                        🏆 <?php echo htmlspecialchars($main['badge']['label']); ?>
                    </span>
                    <h3><?php echo htmlspecialchars($main['title']); ?></h3>
                    <p><?php echo htmlspecialchars($main['description']); ?></p>
                    <div class="featured-card-footer">
                        <div class="featured-card-info">
                            <div>
                                <strong><?php echo htmlspecialchars($main['genre']); ?></strong>
                                Genre
                            </div>
                            <div>
                                <strong><?php echo (int)$main['year']; ?></strong>
                                Année
                            </div>
                            <div>
                                <strong><?php echo number_format($main['rating'], 1); ?>/10</strong>
                                Note
                            </div>
                            <?php if (!empty($main['plays'])): ?>
                            <div>
                                <strong><?php echo htmlspecialchars($main['plays']); ?></strong>
                                Joueurs
                            </div>
                            <?php endif; ?>
                        </div>
                        <span class="btn-primary" style="font-size:0.85rem;padding:10px 20px;">
                            Voir le jeu →
                        </span>
                    </div>
                </div>
            </a>

            <!-- Side cards -->
            <div class="featured-side-cards">
                <?php foreach (array_slice($featured_games, 1, 2) as $game): ?>
                <a href="pages/game.php?id=<?php echo (int)$game['id']; ?>" class="featured-card-small" style="text-decoration:none;color:inherit;">
                    <div class="featured-card-bg">
                        <div class="featured-card-bg-gradient" style="background:<?php echo htmlspecialchars($game['gradient']); ?>;"></div>
                        <div class="featured-card-bg-overlay"></div>
                        <span style="position:relative;z-index:1;opacity:0.15;font-size:5rem;"><?php echo $game['emoji']; ?></span>
                    </div>
                    <div class="featured-card-content">
                        <span class="badge <?php echo badgeClass($game['badge']['type']); ?>" style="margin-bottom:8px;">
                            <?php echo htmlspecialchars($game['badge']['label']); ?>
                        </span>
                        <h3><?php echo htmlspecialchars($game['title']); ?></h3>
                        <p><?php echo mb_strimwidth(htmlspecialchars($game['description']), 0, 90, '…'); ?></p>
                        <div class="featured-card-footer">
                            <span style="font-size:0.85rem;color:var(--color-primary-light);font-weight:600;">
                                <?php echo number_format($game['rating'], 1); ?>/10 ★
                            </span>
                            <span style="font-size:0.78rem;color:var(--color-text-muted);">
                                <?php echo htmlspecialchars($game['genre']); ?> · <?php echo (int)$game['year']; ?>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

        </div><!-- /.featured-grid -->
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     CATEGORIES
════════════════════════════════════════════════ -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="badge badge-accent" style="margin-bottom:12px;">🎯 Genres</div>
                <h2 class="section-title">Parcourir par <span>Catégorie</span></h2>
                <p class="section-subtitle">Trouvez les jeux qui correspondent à vos envies</p>
            </div>
            <a href="pages/categories.php" class="section-link">Toutes les catégories →</a>
        </div>

        <div class="categories-grid">
            <?php foreach ($categories as $cat): ?>
            <a href="pages/games.php?genre=<?php echo urlencode($cat['slug']); ?>" class="category-card">
                <div class="category-icon <?php echo htmlspecialchars($cat['class']); ?>">
                    <?php echo $cat['icon']; ?>
                </div>
                <span class="category-name"><?php echo htmlspecialchars($cat['name']); ?></span>
                <span class="category-count"><?php echo $cat['count']; ?> jeux</span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     TOP RATED
════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="badge badge-primary" style="margin-bottom:12px;">⭐ Meilleurs jeux</div>
                <h2 class="section-title">Les <span>Meilleures Notes</span></h2>
                <p class="section-subtitle">Évalués et plébiscités par notre communauté</p>
            </div>
            <a href="pages/games.php?sort=rating" class="section-link">Voir le classement →</a>
        </div>

        <div class="games-grid">
            <?php foreach ($top_games as $game): ?>
            <div class="game-card">
                <div class="game-card-image">
                    <div class="game-card-placeholder" style="background:<?php echo htmlspecialchars($game['gradient']); ?>;aspect-ratio:3/4;">
                        <?php echo $game['emoji']; ?>
                    </div>
                    <div class="game-card-badge">
                        <span class="badge badge-primary" style="font-size:0.65rem;"><?php echo htmlspecialchars($game['badge']); ?></span>
                    </div>
                    <button class="game-card-wishlist" title="Ajouter aux favoris">♡</button>
                    <div class="game-card-overlay">
                        <div class="game-card-quick-actions">
                            <a href="pages/game.php?title=<?php echo urlencode($game['title']); ?>" class="quick-btn quick-btn-primary">Voir</a>
                            <button class="quick-btn quick-btn-secondary">+ Collection</button>
                        </div>
                    </div>
                </div>
                <div class="game-card-body">
                    <p class="game-card-genre"><?php echo htmlspecialchars($game['genre']); ?></p>
                    <h3 class="game-card-title"><?php echo htmlspecialchars($game['title']); ?></h3>
                    <div class="game-card-meta">
                        <span><?php echo (int)$game['year']; ?></span>
                        <div class="game-card-rating">
                            ★ <?php echo number_format($game['rating'], 1); ?>
                        </div>
                    </div>
                    <?php echo renderStars($game['rating']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     LATEST RELEASES – horizontal scroll strip
════════════════════════════════════════════════ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="badge badge-new" style="margin-bottom:12px;">🆕 Nouveautés</div>
                <h2 class="section-title">Dernières <span>Sorties</span></h2>
                <p class="section-subtitle">Les jeux les plus récents dans notre catalogue</p>
            </div>
            <a href="pages/games.php?sort=newest" class="section-link">Voir tout →</a>
        </div>

        <div class="latest-scroll">
            <?php foreach ($latest_games as $game): ?>
            <div class="latest-game-card">
                <div class="latest-game-img" style="background:<?php echo htmlspecialchars($game['gradient']); ?>;">
                    <?php echo $game['emoji']; ?>
                </div>
                <div class="latest-game-info">
                    <p class="latest-game-title"><?php echo htmlspecialchars($game['title']); ?></p>
                    <p class="latest-game-meta"><?php echo htmlspecialchars($game['genre']); ?> · ★ <?php echo number_format($game['rating'], 1); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════════════ -->
<section class="cta-banner">
    <div class="container">
        <div class="cta-banner-inner">
            <div class="cta-banner-glow cta-banner-glow-1"></div>
            <div class="cta-banner-glow cta-banner-glow-2"></div>
            <h2>Prêt à construire<br><span>votre bibliothèque idéale&nbsp;?</span></h2>
            <p>
                Rejoignez des milliers de joueurs qui cataloguent leurs jeux, partagent
                leurs critiques et découvrent de nouveaux titres chaque jour.
            </p>
            <div class="cta-banner-actions">
                <a href="pages/register.php" class="btn-primary">
                    Créer un compte gratuit
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="pages/games.php" class="btn-secondary">Explorer d'abord</a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════ -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>GameLib</h3>
            <p>Votre plateforme communautaire dédiée à la bibliothèque et la découverte de jeux vidéo. Construite par des joueurs, pour des joueurs.</p>
        </div>

        <div class="footer-section">
            <h4>Navigation</h4>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="pages/games.php">Catalogue</a></li>
                <li><a href="pages/categories.php">Catégories</a></li>
                <li><a href="pages/collections.php">Collections</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Informations</h4>
            <ul>
                <li><a href="pages/about.php">À propos</a></li>
                <li><a href="pages/privacy.php">Confidentialité</a></li>
                <li><a href="pages/terms.php">CGU</a></li>
                <li><a href="pages/contact.php">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Réseaux</h4>
            <div class="social-links">
                <a href="#" title="Twitter">𝕏</a>
                <a href="#" title="Discord">💬</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="GitHub">⌨️</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> GameLib. Tous droits réservés.</p>
        <div class="footer-bottom-links">
            <a href="pages/privacy.php">Confidentialité</a>
            <a href="pages/terms.php">CGU</a>
            <a href="pages/contact.php">Contact</a>
        </div>
    </div>
</footer>

</body>
</html>
