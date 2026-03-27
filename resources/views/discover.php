<?php
/**
 * Discovery Page Template
 * Ressources/views/discover.php
 * Affiche les jeux avec filtres avancés
 */

// Convert Game objects to arrays
$displayGames = [];
if (!empty($paginated['items'])) {
    foreach ($paginated['items'] as $game) {
        if ($game instanceof \GameLib\Models\Game) {
            $displayGames[] = [
                'id' => $game->getId(),
                'title' => $game->getTitle(),
                'description' => $game->getDescription(),
                'genre' => $game->getGenre(),
                'year' => $game->getYear(),
                'rating' => $game->getRating(),
                'difficulty' => $game->getDifficulty(),
                'playtime_hours' => $game->getPlaytimeHours(),
                'graphics_style' => $game->getGraphicsStyle(),
                'target_audience' => $game->getTargetAudience(),
                'emoji' => $game->getEmoji(),
                'multiplayer' => $game->getMultiplayer(),
                'price_eur' => $game->getPriceEur(),
            ];
        } else {
            $displayGames[] = (array)$game;
        }
    }
}

// Update paginated items with converted games
$paginated['items'] = $displayGames;
?>

<!-- Hero Section: Découverte Intelligente -->
<div class="discover-hero" style="background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-accent) 100%); position: relative; overflow: hidden; padding: 60px 20px;">
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255,255,255, 0.05); border-radius: 50%; filter: blur(50px);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div style="text-align: center; color: white;">
            <div style="font-size: 3rem; margin-bottom: 20px;">🎮</div>
            <h1 style="font-size: 2.5rem; margin-bottom: 10px; font-weight: 700;">Découvrez votre Prochain Jeu</h1>
            <p style="font-size: 1.1rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Besoin d'aide pour choisir ? Utilisez nos filtres intelligents pour trouver le jeu qui <strong>vous correspond</strong>.</p>
        </div>
    </div>
</div>

<!-- Advanced Filter Bar -->
<div class="discover-filters" style="background: var(--clr-dark-lighter); border-bottom: 1px solid var(--clr-border); position: sticky; top: 0; z-index: 50;">
    <div class="container" style="padding: 20px 20px;">
        <form method="GET" action="/discover" id="discover-filters" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px;">
            
            <!-- Search -->
            <div class="filter-group">
                <label style="font-weight: 600; color: var(--clr-text-light); display: block; margin-bottom: 8px;">🔍 Rechercher</label>
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Titre, genre..." 
                    value="<?= e($q ?? '') ?>"
                    style="width: 100%; padding: 10px 12px; background: var(--clr-dark); border: 1px solid var(--clr-border); border-radius: 6px; color: var(--clr-text); font-size: 0.95rem;"
                />
            </div>

            <!-- Difficulty -->
            <div class="filter-group">
                <label style="font-weight: 600; color: var(--clr-text-light); display: block; margin-bottom: 8px;">⚔️ Difficulté</label>
                <select name="difficulty" style="width: 100%; padding: 10px 12px; background: var(--clr-dark); border: 1px solid var(--clr-border); border-radius: 6px; color: var(--clr-text); font-size: 0.95rem;">
                    <option value="">Tous les niveaux</option>
                    <?php foreach ($difficulties ?? [] as $diff): ?>
                        <option value="<?= e($diff) ?>" <?= ($difficulty ?? '') === $diff ? 'selected' : '' ?>><?= e($diff) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Graphics -->
            <div class="filter-group">
                <label style="font-weight: 600; color: var(--clr-text-light); display: block; margin-bottom: 8px;">🎨 Style Graphique</label>
                <select name="graphics" style="width: 100%; padding: 10px 12px; background: var(--clr-dark); border: 1px solid var(--clr-border); border-radius: 6px; color: var(--clr-text); font-size: 0.95rem;">
                    <option value="">Tous les styles</option>
                    <?php foreach ($graphics_styles ?? [] as $gs): ?>
                        <option value="<?= e($gs) ?>" <?= ($graphics ?? '') === $gs ? 'selected' : '' ?>><?= e($gs) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Target Audience -->
            <div class="filter-group">
                <label style="font-weight: 600; color: var(--clr-text-light); display: block; margin-bottom: 8px;">👥 Public Cible</label>
                <select name="audience" style="width: 100%; padding: 10px 12px; background: var(--clr-dark); border: 1px solid var(--clr-border); border-radius: 6px; color: var(--clr-text); font-size: 0.95rem;">
                    <option value="">Tous les publics</option>
                    <?php foreach ($audiences ?? [] as $aud): ?>
                        <option value="<?= e($aud) ?>" <?= ($audience ?? '') === $aud ? 'selected' : '' ?>><?= e($aud) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sort -->
            <div class="filter-group">
                <label style="font-weight: 600; color: var(--clr-text-light); display: block; margin-bottom: 8px;">📊 Trier par</label>
                <select name="sort" style="width: 100%; padding: 10px 12px; background: var(--clr-dark); border: 1px solid var(--clr-border); border-radius: 6px; color: var(--clr-text); font-size: 0.95rem;">
                    <option value="rating" <?= ($sort ?? 'rating') === 'rating' ? 'selected' : '' ?>>⭐ Meilleures notes</option>
                    <option value="newest" <?= ($sort ?? '') === 'newest' ? 'selected' : '' ?>>🆕 Plus récents</option>
                    <option value="oldest" <?= ($sort ?? '') === 'oldest' ? 'selected' : '' ?>>📅 Plus anciens</option>
                    <option value="az" <?= ($sort ?? '') === 'az' ? 'selected' : '' ?>>A→Z Alphab.</option>
                    <option value="za" <?= ($sort ?? '') === 'za' ? 'selected' : '' ?>>Z→A Alphab.</option>
                    <option value="price_low" <?= ($sort ?? '') === 'price_low' ? 'selected' : '' ?>>💰 Prix croissant</option>
                    <option value="price_high" <?= ($sort ?? '') === 'price_high' ? 'selected' : '' ?>>💰 Prix décroissant</option>
                </select>
            </div>

            <!-- Submit & Reset -->
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <button type="submit" style="flex: 1; padding: 10px 20px; background: var(--clr-primary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.95rem;">🔎 Filtrer</button>
                <a href="/discover" style="flex: 1; padding: 10px 20px; background: var(--clr-border); color: var(--clr-text); border: none; border-radius: 6px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; font-size: 0.95rem;">↻ Réinitialiser</a>
            </div>

        </form>
    </div>
</div>

<!-- Results Section -->
<div class="container" style="padding: 40px 20px;">
    <!-- Result Count -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem;">Résultats</h2>
            <p style="margin: 5px 0 0 0; color: var(--clr-text-light); font-size: 0.95rem;">
                <?= $paginated['total'] ?? 0 ?> jeu<?= ($paginated['total'] ?? 0) > 1 ? 'x' : '' ?> trouvé<?= ($paginated['total'] ?? 0) > 1 ? 's' : '' ?>
                <?php if ($difficulty || $graphics || $audience || $q): ?>
                    <span style="color: var(--clr-accent);">selon vos critères</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Games Grid -->
    <?php if (!empty($paginated['items'] ?? [])): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <?php foreach ($paginated['items'] as $game): ?>
                <div class="game-card-recommend" style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); border-radius: 12px; overflow: hidden; transition: transform 0.2s, border-color 0.2s; cursor: pointer;"
                    onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='var(--clr-primary)'';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--clr-border)'';"
                    onclick="window.location.href = '/game?id=<?= e($game['id']) ?>';">
                    
                    <!-- Header with emoji and rating -->
                    <div style="padding: 15px; background: <?= gameGradient((int)$game['id'], $game['difficulty'] ?? '', $game['graphics_style'] ?? '') ?>; border-bottom: 1px solid var(--clr-border);">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                            <span style="font-size: 2rem;"><?= e($game['emoji'] ?? '🎮') ?></span>
                            <div style="background: var(--clr-accent); color: white; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">⭐ <?= e($game['rating'] ?? 'N/A') ?></div>
                        </div>
                        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--clr-text);"><?= e($game['title'] ?? 'Unknown') ?></h3>
                        <p style="margin: 5px 0 0 0; font-size: 0.85rem; color: var(--clr-text-light);"><?= e($game['genre'] ?? '') ?> • <?= e($game['year'] ?? '') ?></p>
                    </div>

                    <!-- Criteria Tags -->
                    <div style="padding: 15px; border-bottom: 1px solid var(--clr-border);">
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <span style="background: var(--clr-primary); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">⚔️ <?= e($game['difficulty'] ?? 'N/A') ?></span>
                            <span style="background: var(--clr-accent); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">🎨 <?= e($game['graphics_style'] ?? 'N/A') ?></span>
                            <span style="background: rgba(107,114,128,0.2); color: var(--clr-text); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">⏱️ <?= e($game['playtime_hours'] ?? 'N/A') ?>h</span>
                        </div>
                    </div>

                    <!-- Details -->
                    <div style="padding: 15px;">
                        <div style="font-size: 0.85rem; color: var(--clr-text-light); margin-bottom: 10px; line-height: 1.4;">
                            <?= e(truncate($game['description'] ?? '', 80)) ?>
                        </div>
                        
                        <div style="border-top: 1px solid var(--clr-border); padding-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.8rem;">
                            <div>
                                <span style="color: var(--clr-text-light);">👥</span>
                                <span style="color: var(--clr-text);"><?= e($game['target_audience'] ?? '') ?></span>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: var(--clr-text-light);">💵</span>
                                <span style="color: var(--clr-text); font-weight: 600;"><?= e($game['price_eur'] ?? '') ?></span>
                            </div>
                        </div>
                        
                        <?php if (($game['multiplayer'] ?? '') === 'Oui'): ?>
                            <div style="margin-top: 10px; padding: 8px; background: var(--clr-primary); color: white; text-align: center; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                🎮 Multijoueur
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 60px 20px; background: var(--clr-dark-lighter); border-radius: 12px;">
            <div style="font-size: 3rem; margin-bottom: 20px;">🎮</div>
            <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">Aucun jeu trouvé</h3>
            <p style="margin: 0 0 20px 0; color: var(--clr-text-light);">Essayez de modifier vos critères de filtrage.</p>
            <a href="/discover" style="display: inline-block; padding: 10px 20px; background: var(--clr-primary); color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">Réinitialiser les filtres</a>
        </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if (($paginated['pages'] ?? 1) > 1): ?>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 40px;">
            <?php if (($paginated['page'] ?? 1) > 1): ?>
                <a 
                    href="/discover?page=<?= ($paginated['page'] - 1) ?>&q=<?= urlencode($q ?? '') ?>&difficulty=<?= urlencode($difficulty ?? '') ?>&graphics=<?= urlencode($graphics ?? '') ?>&audience=<?= urlencode($audience ?? '') ?>&sort=<?= urlencode($sort ?? 'rating') ?>"
                    style="padding: 8px 12px; background: var(--clr-primary); color: white; border-radius: 4px; text-decoration: none; font-weight: 600;"
                >← Précédent</a>
            <?php endif; ?>
            
            <span style="color: var(--clr-text-light);">Page <?= $paginated['page'] ?? 1 ?> / <?= $paginated['pages'] ?? 1 ?></span>
            
            <?php if (($paginated['page'] ?? 1) < ($paginated['pages'] ?? 1)): ?>
                <a 
                    href="/discover?page=<?= ($paginated['page'] + 1) ?>&q=<?= urlencode($q ?? '') ?>&difficulty=<?= urlencode($difficulty ?? '') ?>&graphics=<?= urlencode($graphics ?? '') ?>&audience=<?= urlencode($audience ?? '') ?>&sort=<?= urlencode($sort ?? 'rating') ?>"
                    style="padding: 8px 12px; background: var(--clr-primary); color: white; border-radius: 4px; text-decoration: none; font-weight: 600;"
                >Suivant →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
