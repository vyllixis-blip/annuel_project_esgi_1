<?php

namespace GameLib\Controllers;

use GameLib\Services\GameService;

/**
 * Game Detail Controller - Single game details page
 *
 * @package GameLib\Controllers
 * @author ESGI Project Team
 * @version 1.0.0
 */
class GameDetailController
{
    private GameService $gameService;

    /**
     * Constructor
     */
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Show game details
     */
    public function show(int $gameId): array
    {
        $game = $this->gameService->findById($gameId);

        if (!$game) {
            return ['error' => 'game_not_found'];
        }

        return ['game' => $game];
    }
}
