<?php
/*
** ESGI PROJECT, 2025
** pages/about.php
** File description:
** About GameLib — mission, team, history
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'À propos';
$pageDesc  = 'Découvrez l\'histoire et la mission de GameLib, la plateforme communautaire dédiée aux jeux vidéo.';
$activeNav = '';

$team = [
    ['name'=>'Alice Martin',     'role'=>'Co-fondatrice & CEO',      'avatar'=>'👩‍💼'],
    ['name'=>'Tom Leclerc',      'role'=>'Lead Développeur Full-Stack','avatar'=>'👨‍💻'],
    ['name'=>'Maya Dupont',      'role'=>'Directrice UX/UI',         'avatar'=>'👩‍🎨'],
    ['name'=>'Lucas Bernard',    'role'=>'Responsable Communauté',    'avatar'=>'🧑‍🤝‍🧑'],
    ['name'=>'Sara Okafor',      'role'=>'Ingénieure Base de données','avatar'=>'👩‍🔬'],
    ['name'=>'Théo Fontaine',    'role'=>'DevOps & Infrastructure',  'avatar'=>'🧑‍🔧'],
];

$values = [
    ['icon'=>'🎯','title'=>'Passion du jeu','desc'=>"Chaque décision est guidée par notre amour des jeux vidéo et le respect de la culture gaming."],
    ['icon'=>'👥','title'=>'Communauté d\'abord','desc'=>"Les joueurs font GameLib. Nous construisons des outils qui leur donnent le pouvoir d'expression."],
    ['icon'=>'🔍','title'=>'Transparence','desc'=>"Pas de publicités cachées, pas de manipulations algorithmiques. Juste des jeux et des opinions authentiques."],
    ['icon'=>'🌍','title'=>'Inclusivité','desc'=>"Le gaming est pour tout le monde. Nous cultivons un espace sûr, respectueux et ouvert."],
];

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow">
                <div class="page-hero-eyebrow-line"></div>
                <span>Notre histoire</span>
            </div>
            <h1>À propos de <span class="gradient-text">GameLib</span></h1>
            <p>Une plateforme née de la passion des jeux vidéo, construite par des joueurs pour des joueurs.</p>
        </div>
    </div>
</div>

<main>

    <!-- Mission -->
    <section class="section">
        <div class="container" style="max-width:900px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;">
                <div>
                    <div class="badge badge-primary" style="margin-bottom:16px;">🚀 Notre mission</div>
                    <h2 class="section-title">Donner une voix à <span>chaque joueur</span></h2>
                    <p style="color:var(--color-text-muted);line-height:1.8;margin-top:16px;">
                        GameLib est né d'un constat simple : il n'existait pas de plateforme francophone où les joueurs pouvaient
                        vraiment <strong style="color:var(--color-text);">cataloguer, critiquer et découvrir</strong> des jeux vidéo 
                        de manière authentique.
                    </p>
                    <p style="color:var(--color-text-muted);line-height:1.8;margin-top:12px;">
                        Depuis 2024, nous construisons cet espace avec notre communauté — chaque retour, 
                        chaque suggestion façonne la plateforme.
                    </p>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <?php
                    $nums = [
                        ['v'=>'2024',   'l'=>'Fondée'],
                        ['v'=>'1 400+', 'l'=>'Jeux'],
                        ['v'=>'48 K',   'l'=>'Membres'],
                        ['v'=>'92 K',   'l'=>'Critiques'],
                    ];
                    foreach ($nums as $n):
                    ?>
                    <div style="background:var(--color-bg-card);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:20px;text-align:center;">
                        <div class="stat-value" style="font-size:1.5rem;"><?= e($n['v']) ?></div>
                        <div class="stat-label"><?= e($n['l']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="categories-section">
        <div class="container">
            <div style="text-align:center;margin-bottom:48px;">
                <div class="badge badge-accent" style="margin-bottom:16px;">💡 Nos valeurs</div>
                <h2 class="section-title">Ce qui nous <span>guide</span></h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:24px;">
                <?php foreach ($values as $v): ?>
                <div style="background:var(--color-bg-card);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:28px;transition:var(--transition);"
                     onmouseover="this.style.borderColor='rgba(124,58,237,.5)';this.style.transform='translateY(-4px)';"
                     onmouseout="this.style.borderColor='';this.style.transform='';">
                    <div style="font-size:2rem;margin-bottom:16px;"><?= $v['icon'] ?></div>
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:8px;"><?= e($v['title']) ?></h3>
                    <p style="font-size:0.85rem;color:var(--color-text-muted);line-height:1.65;"><?= e($v['desc']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="section">
        <div class="container">
            <div style="text-align:center;margin-bottom:48px;">
                <div class="badge badge-warm" style="margin-bottom:16px;">👥 L'équipe</div>
                <h2 class="section-title">Les gens <span>derrière GameLib</span></h2>
                <p class="section-subtitle">Une équipe passionnée de jeux vidéo et de technologie</p>
            </div>
            <div class="team-grid">
                <?php foreach ($team as $member): ?>
                <div class="team-card">
                    <div class="team-avatar"><?= $member['avatar'] ?></div>
                    <h4><?= e($member['name']) ?></h4>
                    <p><?= e($member['role']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-banner">
        <div class="container">
            <div class="cta-banner-inner">
                <div class="cta-banner-glow cta-banner-glow-1"></div>
                <div class="cta-banner-glow cta-banner-glow-2"></div>
                <h2>Rejoignez l'aventure<br><span>GameLib</span></h2>
                <p>Faites partie d'une communauté qui grandit chaque jour autour d'une passion commune.</p>
                <div class="cta-banner-actions">
                    <a href="/pages/register.php" class="btn-primary">Créer un compte gratuit →</a>
                    <a href="/pages/contact.php"  class="btn-secondary">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
