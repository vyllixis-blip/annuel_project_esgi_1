<?php
/*
** ESGI PROJECT, 2025
** pages/categories.php
** File description:
** Browse games by genre/category
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../data/mock.php';

$pageTitle = 'Catégories';
$pageDesc  = 'Parcourez notre catalogue par genre : RPG, Action, Stratégie, Horreur et bien plus encore.';
$activeNav = 'categories';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow">
                <div class="page-hero-eyebrow-line"></div>
                <span>Genres & Styles</span>
            </div>
            <h1>Parcourir par <span class="gradient-text">Catégorie</span></h1>
            <p><?= count($CATEGORIES) ?> genres disponibles — trouvez les jeux qui correspondent à vos envies.</p>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<main style="padding:60px 0 80px;">
    <div class="container">

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;">
            <?php foreach ($CATEGORIES as $cat):
                /* Games matching this category */
                $catGames = array_slice(filterGames($GAMES, '', $cat['slug'], 'rating'), 0, 3);
            ?>
            <a href="/pages/games.php?genre=<?= urlencode($cat['slug']) ?>" class="collection-card" style="text-decoration:none;color:inherit;">
                <!-- Category header -->
                <div style="display:flex;align-items:center;gap:16px;">
                    <div class="category-icon <?= e($cat['class']) ?>" style="width:56px;height:56px;font-size:1.5rem;border-radius:12px;">
                        <?= $cat['icon'] ?>
                    </div>
                    <div>
                        <h3 style="font-size:1.05rem;font-weight:800;margin-bottom:2px;"><?= e($cat['name']) ?></h3>
                        <p style="font-size:0.78rem;color:var(--color-text-dim);"><?= $cat['count'] ?> jeux</p>
                    </div>
                </div>

                <!-- Description -->
                <p style="font-size:0.85rem;color:var(--color-text-muted);line-height:1.65;flex:1;">
                    <?= e($cat['description']) ?>
                </p>

                <!-- Preview games -->
                <?php if (!empty($catGames)): ?>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <?php foreach ($catGames as $g): ?>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px;background:rgba(255,255,255,.03);border-radius:8px;border:1px solid var(--color-border);">
                        <span style="font-size:1.4rem;width:36px;text-align:center;"><?= $g['emoji'] ?></span>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.82rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= e($g['title']) ?>
                            </p>
                            <p style="font-size:0.72rem;color:var(--color-text-dim);"><?= (int)$g['year'] ?></p>
                        </div>
                        <span style="font-size:0.8rem;font-weight:700;color:var(--color-accent-warm);">★ <?= number_format($g['rating'],1) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Footer link -->
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.82rem;padding-top:8px;border-top:1px solid var(--color-border);">
                    <span style="color:var(--color-primary-light);font-weight:600;">Voir tous les <?= e($cat['name']) ?></span>
                    <span style="color:var(--color-text-dim);">→</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
