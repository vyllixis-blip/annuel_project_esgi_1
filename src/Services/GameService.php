<?php

namespace GameLib\Services;

use GameLib\Models\Game;

/**
 * Game Service - Business logic for games
 *
 * @package GameLib\Services
 * @author ESGI Project Team
 * @version 1.0.0
 */
class GameService
{
    private array $_games = [];

    /**
     * Constructor
     */
    public function __construct(array $games = [])
    {
        $this->_games = $games;
    }

    /**
     * Set games collection
     */
    public function setGames(array $games): void
    {
        $this->_games = $games;
    }

    /**
     * Get all games
     */
    public function getAll(): array
    {
        return $this->_games;
    }

    /**
     * Find game by ID
     */
    public function findById(int $id): ?Game
    {
        foreach ($this->_games as $game) {
            if ($game->getId() === $id) {
                return $game;
            }
        }
        return null;
    }

    /**
     * Filter games by multiple criteria
     *
     * @param string $query Textual search
     * @param string $difficulty Difficulty level
     * @param string $graphicsStyle Graphics style
     * @param string $audience Target audience
     * @param string $sortBy Sort criteria
     * @return array Filtered and sorted games
     */
    public function filter(
        string $query = '',
        string $difficulty = '',
        string $graphicsStyle = '',
        string $audience = '',
        string $sortBy = 'rating'
    ): array {
        $filtered = $this->_games;

        // Text search
        if (!empty($query)) {
            $query_lower = mb_strtolower($query);
            $filtered = array_filter($filtered, function(Game $game) use ($query_lower) {
                $searchText = mb_strtolower(
                    $game->getTitle() . ' ' .
                    $game->getGenre() . ' ' .
                    $game->getDescription()
                );
                return str_contains($searchText, $query_lower);
            });
        }

        // Difficulty filter
        if (!empty($difficulty)) {
            $filtered = array_filter($filtered, fn(Game $g) =>
                str_contains($g->getDifficulty(), $difficulty)
            );
        }

        // Graphics style filter
        if (!empty($graphicsStyle)) {
            $filtered = array_filter($filtered, fn(Game $g) =>
                str_contains($g->getGraphicsStyle(), $graphicsStyle)
            );
        }

        // Target audience filter
        if (!empty($audience)) {
            $filtered = array_filter($filtered, fn(Game $g) =>
                str_contains($g->getTargetAudience(), $audience)
            );
        }

        // Re-index array
        $filtered = array_values($filtered);

        // Sort
        usort($filtered, $this->_getSortComparator($sortBy));

        return $filtered;
    }

    /**
     * Get unique filter options
     */
    public function getFilterOptions(): array
    {
        $difficulties = [];
        $styles = [];
        $audiences = [];

        foreach ($this->_games as $game) {
            $difficulties[$game->getDifficulty()] = true;
            
            foreach (explode('|', $game->getGraphicsStyle()) as $style) {
                $styles[trim($style)] = true;
            }
            
            foreach (explode('|', $game->getTargetAudience()) as $aud) {
                $audiences[trim($aud)] = true;
            }
        }

        return [
            'difficulties' => array_keys($difficulties),
            'graphics_styles' => array_keys($styles),
            'audiences' => array_keys($audiences),
        ];
    }

    /**
     * Get sort comparator function
     */
    private function _getSortComparator(string $sortBy): callable
    {
        return match($sortBy) {
            'newest' => fn(Game $a, Game $b) => $b->getYear() <=> $a->getYear(),
            'oldest' => fn(Game $a, Game $b) => $a->getYear() <=> $b->getYear(),
            'az' => fn(Game $a, Game $b) => strcmp($a->getTitle(), $b->getTitle()),
            'za' => fn(Game $a, Game $b) => strcmp($b->getTitle(), $a->getTitle()),
            'price_low' => fn(Game $a, Game $b) => $this->_parsePrice($a->getPriceEur()) <=> $this->_parsePrice($b->getPriceEur()),
            'price_high' => fn(Game $a, Game $b) => $this->_parsePrice($b->getPriceEur()) <=> $this->_parsePrice($a->getPriceEur()),
            default => fn(Game $a, Game $b) => $b->getRating() <=> $a->getRating(),
        };
    }

    /**
     * Parse price string to float
     */
    private function _parsePrice(string $price): float
    {
        if (str_contains($price, 'Gratuit')) {
            return 0;
        }
        return (float) str_replace(',', '.', preg_replace('/[^0-9.,]/', '', $price)) ?: 0;
    }
}
