<?php
/**
 * Game Detail Page Template
 * resources/views/game-detail.php
 * Affiche les détails complets d'un jeu
 * 
 * Variables attendues:
 * $game (Game object)
 */

// Convert Game object to array
$gameData = [];
if ($game instanceof \GameLib\Models\Game) {
    $gameData = [
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
        'game_type' => $game->getGameType(),
        'story_mode' => $game->getStoryMode(),
        'multiplayer' => $game->getMultiplayer(),
        'price_eur' => $game->getPriceEur(),
        'emoji' => $game->getEmoji(),
        'platforms' => (array)$game->getPlatforms(),
    ];
} else {
    $gameData = (array)$game;
}
?>

<!-- Hero Section -->
<div style="background: <?= gameGradient((int)($gameData['id'] ?? 1), $gameData['difficulty'] ?? '', $gameData['graphics_style'] ?? '') ?>; position: relative; overflow: hidden; padding: 60px 20px;">
    <div class="container" style="position: relative; z-index: 1;">
        <a href="/discover" style="color: white; text-decoration: none; font-weight: 600; margin-bottom: 20px; display: inline-block;">← Retour</a>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
            <div>
                <div style="font-size: 4rem; margin-bottom: 20px; background: rgba(255,255,255,0.1); width: fit-content; padding: 30px; border-radius: 12px;">
                    <?= e($gameData['emoji'] ?? '🎮') ?>
                </div>
            </div>
            <div style="color: white;">
                <div style="opacity: 0.8; margin-bottom: 10px;"><?= e($gameData['genre'] ?? '') ?> • <?= e($gameData['year'] ?? '') ?></div>
                <h1 style="font-size: 2.5rem; margin: 0 0 20px 0; font-weight: 700;"><?= e($gameData['title'] ?? 'Unknown Game') ?></h1>
                <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div style="opacity: 0.8; font-size: 0.9rem;">Note Globale</div>
                        <div style="font-size: 2rem; font-weight: 700;">⭐ <?= e($gameData['rating'] ?? 'N/A') ?>/10</div>
                    </div>
                    <div style="opacity: 0.8; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 20px;">
                        <div style="font-size: 0.9rem;">Plateforme<?= !empty($gameData['platforms']) && count($gameData['platforms']) > 1 ? 's' : '' ?></div>
                        <div style="font-weight: 600;">
                            <?= implode(', ', array_map('e', (array)($gameData['platforms'] ?? []))) ?>
                        </div>
                    </div>
                </div>
                <p style="opacity: 0.9; line-height: 1.6; margin: 0;"><?= e($gameData['description'] ?? '') ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container" style="padding: 40px 20px;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        
        <!-- Left Column: Details -->
        <div>
            <!-- Criteria Cards -->
            <div style="margin-bottom: 40px;">
                <h2 style="margin: 0 0 20px 0; font-size: 1.5rem; font-weight: 700;">📊 Caractéristiques du Jeu</h2>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    
                    <!-- Difficulty -->
                    <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); padding: 20px; border-radius: 8px;">
                        <div style="font-size: 1.3rem; margin-bottom: 10px;">⚔️</div>
                        <div style="font-size: 0.85rem; color: var(--clr-text-light); margin-bottom: 5px;">Difficulté</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #ff6b6b;"><?= e($gameData['difficulty'] ?? 'N/A') ?></div>
                    </div>

                    <!-- Playtime -->
                    <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); padding: 20px; border-radius: 8px;">
                        <div style="font-size: 1.3rem; margin-bottom: 10px;">⏱️</div>
                        <div style="font-size: 0.85rem; color: var(--clr-text-light); margin-bottom: 5px;">Durée de Jeu</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #4ecdc4;"><?= e($gameData['playtime_hours'] ?? 'N/A') ?> heures</div>
                    </div>

                    <!-- Graphics -->
                    <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); padding: 20px; border-radius: 8px;">
                        <div style="font-size: 1.3rem; margin-bottom: 10px;">🎨</div>
                        <div style="font-size: 0.85rem; color: var(--clr-text-light); margin-bottom: 5px;">Style Graphique</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #a78bfa;"><?= e($gameData['graphics_style'] ?? 'N/A') ?></div>
                    </div>

                    <!-- Target Audience -->
                    <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); padding: 20px; border-radius: 8px;">
                        <div style="font-size: 1.3rem; margin-bottom: 10px;">👥</div>
                        <div style="font-size: 0.85rem; color: var(--clr-text-light); margin-bottom: 5px;">Public Cible</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #60a5fa;"><?= e($gameData['target_audience'] ?? 'N/A') ?></div>
                    </div>

                </div>
            </div>

            <!-- Game Info -->
            <div style="margin-bottom: 40px;">
                <h2 style="margin: 0 0 20px 0; font-size: 1.5rem; font-weight: 700;">ℹ️ Informations</h2>
                <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); border-radius: 8px; padding: 20px; display: grid; gap: 15px;">
                    
                    <div>
                        <span style="color: var(--clr-text-light); font-weight: 600;">Genre :</span>
                        <span style="margin-left: 10px; color: var(--clr-text);"><?= e($gameData['genre'] ?? 'N/A') ?></span>
                    </div>

                    <div>
                        <span style="color: var(--clr-text-light); font-weight: 600;">Année de Sortie :</span>
                        <span style="margin-left: 10px; color: var(--clr-text);"><?= e($gameData['year'] ?? 'N/A') ?></span>
                    </div>

                    <div>
                        <span style="color: var(--clr-text-light); font-weight: 600;">Type de Jeu :</span>
                        <span style="margin-left: 10px; color: var(--clr-text);"><?= e($gameData['game_type'] ?? 'N/A') ?></span>
                    </div>

                    <div>
                        <span style="color: var(--clr-text-light); font-weight: 600;">Mode Histoire :</span>
                        <span style="margin-left: 10px; color: var(--clr-text);"><?= ($gameData['story_mode'] ?? 'Non') === 'Oui' ? '✓ Présent' : '✗ Absent' ?></span>
                    </div>

                    <div>
                        <span style="color: var(--clr-text-light); font-weight: 600;">Multijoueur :</span>
                        <span style="margin-left: 10px; color: var(--clr-text);"><?= ($gameData['multiplayer'] ?? 'Non') === 'Oui' ? '✓ Oui' : '✗ Non' ?></span>
                    </div>

                    <div style="border-top: 1px solid var(--clr-border); padding-top: 15px; margin-top: 15px;">
                        <span style="color: var(--clr-text-light); font-weight: 600;">Plateformes :</span>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px;">
                            <?php
                            $platforms = (array)($gameData['platforms'] ?? []);
                            foreach ($platforms as $platform): 
                            ?>
                                <span style="background: var(--clr-primary); color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                    <?= e($platform) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Description Complète -->
            <div>
                <h2 style="margin: 0 0 20px 0; font-size: 1.5rem; font-weight: 700;">📖 À Propos</h2>
                <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); border-radius: 8px; padding: 20px; line-height: 1.8; color: var(--clr-text);">
                    <?= e($gameData['description'] ?? '') ?>
                </div>
            </div>

        </div>

        <!-- Right Column: Sidebar -->
        <div>
            <!-- Price Section -->
            <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <div style="font-size: 0.85rem; color: var(--clr-text-light); margin-bottom: 10px;">PRIX MOYEN</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--clr-accent); margin-bottom: 20px;">
                    <?= e($gameData['price_eur'] ?? 'N/A') ?>
                </div>
                <button style="width: 100%; padding: 12px; background: var(--clr-primary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                    👕 Ajouter à ma Wishlist
                </button>
            </div>

            <!-- Summary Card -->
            <div style="background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); border-radius: 8px; padding: 20px;">
                <h3 style="margin: 0 0 15px 0; font-size: 1.1rem; font-weight: 700;">Résumé</h3>
                
                <div style="display: grid; gap: 12px; font-size: 0.9rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--clr-text-light);">⭐ Note</span>
                        <strong><?= e($gameData['rating'] ?? 'N/A') ?>/10</strong>
                    </div>
                    <div style="border-top: 1px solid var(--clr-border); padding-top: 12px; margin-top: 12px;">
                        <span style="color: var(--clr-text-light);">Genre :</span>
                        <div style="font-weight: 600; margin-top: 5px;"><?= e($gameData['genre'] ?? 'N/A') ?></div>
                    </div>
                    <div style="border-top: 1px solid var(--clr-border); padding-top: 12px; margin-top: 12px;">
                        <span style="color: var(--clr-text-light);">Année :</span>
                        <div style="font-weight: 600; margin-top: 5px;"><?= e($gameData['year'] ?? 'N/A') ?></div>
                    </div>
                    <div style="border-top: 1px solid var(--clr-border); padding-top: 12px; margin-top: 12px;">
                        <span style="color: var(--clr-text-light);">Difficulté :</span>
                        <div style="font-weight: 600; margin-top: 5px; color: #ff6b6b;"><?= e($gameData['difficulty'] ?? 'N/A') ?></div>
                    </div>
                    <div style="border-top: 1px solid var(--clr-border); padding-top: 12px; margin-top: 12px;">
                        <span style="color: var(--clr-text-light);">Durée :</span>
                        <div style="font-weight: 600; margin-top: 5px; color: #4ecdc4;"><?= e($gameData['playtime_hours'] ?? 'N/A') ?>h</div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div style="margin-top: 20px;">
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span style="background: rgba(255, 107, 107, 0.2); color: #ff6b6b; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                        ⚔️ <?= e($gameData['difficulty'] ?? 'N/A') ?>
                    </span>
                    <span style="background: rgba(168, 85, 247, 0.2); color: #a855f7; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                        🎨 <?= e($gameData['graphics_style'] ?? 'N/A') ?>
                    </span>
                    <span style="background: rgba(96, 165, 250, 0.2); color: #3b82f6; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                        👥 <?= e($gameData['target_audience'] ?? 'N/A') ?>
                    </span>
                </div>
            </div>

            <!-- Back Button -->
            <div style="margin-top: 30px;">
                <a href="/discover" style="display: inline-block; width: 100%; padding: 12px; background: var(--clr-dark-lighter); border: 1px solid var(--clr-border); color: var(--clr-text); text-decoration: none; border-radius: 6px; text-align: center; font-weight: 600; transition: all 0.2s;"
                   onmouseover="this.style.borderColor='var(--clr-primary)'"
                   onmouseout="this.style.borderColor='var(--clr-border)'"
                >
                    ← Retour à la Découverte
                </a>
            </div>

        </div>

    </div>
</div>
