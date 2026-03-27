<?php

namespace GameLib\Controllers;

use GameLib\Services\GameService;
use GameLib\Utils\StringHelper;

/**
 * Discovery Controller - Game recommendation engine
 *
 * @package GameLib\Controllers
 * @author ESGI Project Team
 * @version 1.0.0
 */
class DiscoveryController
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
     * Render discovery page
     */
    public function index(): array
    {
        // Get query parameters
        $difficulty = trim($_GET['difficulty'] ?? '');
        $graphics = trim($_GET['graphics'] ?? '');
        $audience = trim($_GET['audience'] ?? '');
        $query = trim($_GET['q'] ?? '');
        $sort = in_array($_GET['sort'] ?? '', ['rating','newest','oldest','az','za','price_low','price_high']) ? $_GET['sort'] : 'rating';
        $page = max(1, (int)($_GET['page'] ?? 1));

        // Get filter options
        $options = $this->gameService->getFilterOptions();

        // Filter games
        $filtered = $this->gameService->filter($query, $difficulty, $graphics, $audience, $sort);

        // Paginate
        $totalGames = count($filtered);
        $gamesPerPage = 12;
        $totalPages = ceil($totalGames / $gamesPerPage) ?: 1;
        $page = min($page, $totalPages);

        $offset = ($page - 1) * $gamesPerPage;
        $displayedGames = array_slice($filtered, $offset, $gamesPerPage);

        return [
            'games' => $displayedGames,
            'filters' => [
                'difficulties' => $options['difficulties'],
                'graphics_styles' => $options['graphics_styles'],
                'audiences' => $options['audiences'],
                'selected' => [
                    'difficulty' => $difficulty,
                    'graphics' => $graphics,
                    'audience' => $audience,
                    'query' => $query,
                    'sort' => $sort,
                ]
            ],
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalGames' => $totalGames,
                'perPage' => $gamesPerPage,
            ]
        ];
    }
}
