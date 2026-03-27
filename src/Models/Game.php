<?php

namespace GameLib\Models;

/**
 * Game Model - Represents a video game
 *
 * @package GameLib\Models
 * @author ESGI Project Team
 * @version 1.0.0
 */
class Game
{
    private int $_id;
    private string $_title;
    private string $_genre;
    private array $_platforms;
    private string $_difficulty;
    private string $_playtimeHours;
    private string $_graphicsStyle;
    private string $_targetAudience;
    private float $_rating;
    private int $_year;
    private string $_priceEur;
    private string $_multiplayer;
    private string $_storyMode;
    private string $_gameType;
    private string $_description;
    private string $_emoji;

    /**
     * Constructor
     */
    public function __construct(array $data = [])
    {
        $this->_id = (int)($data['id'] ?? 0);
        $this->_title = $data['title'] ?? '';
        $this->_genre = $data['genre'] ?? '';
        $this->_platforms = array_filter(explode('|', $data['platforms'] ?? ''));
        $this->_difficulty = $data['difficulty'] ?? '';
        $this->_playtimeHours = $data['playtime_hours'] ?? '';
        $this->_graphicsStyle = $data['graphics_style'] ?? '';
        $this->_targetAudience = $data['target_audience'] ?? '';
        $this->_rating = (float)($data['rating'] ?? 0);
        $this->_year = (int)($data['year'] ?? 0);
        $this->_priceEur = $data['price_eur'] ?? '';
        $this->_multiplayer = $data['multiplayer'] ?? '';
        $this->_storyMode = $data['story_mode'] ?? '';
        $this->_gameType = $data['game_type'] ?? '';
        $this->_description = $data['description'] ?? '';
        $this->_emoji = $data['emoji'] ?? '';
    }

    // ─── Getters ──────────────────────────────────────────────────────

    public function getId(): int { return $this->_id; }
    public function getTitle(): string { return $this->_title; }
    public function getGenre(): string { return $this->_genre; }
    public function getPlatforms(): array { return $this->_platforms; }
    public function getDifficulty(): string { return $this->_difficulty; }
    public function getPlaytimeHours(): string { return $this->_playtimeHours; }
    public function getGraphicsStyle(): string { return $this->_graphicsStyle; }
    public function getTargetAudience(): string { return $this->_targetAudience; }
    public function getRating(): float { return $this->_rating; }
    public function getYear(): int { return $this->_year; }
    public function getPriceEur(): string { return $this->_priceEur; }
    public function getMultiplayer(): string { return $this->_multiplayer; }
    public function getStoryMode(): string { return $this->_storyMode; }
    public function getGameType(): string { return $this->_gameType; }
    public function getDescription(): string { return $this->_description; }
    public function getEmoji(): string { return $this->_emoji; }

    /**
     * Convert to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->_id,
            'title' => $this->_title,
            'genre' => $this->_genre,
            'platforms' => $this->_platforms,
            'difficulty' => $this->_difficulty,
            'playtime_hours' => $this->_playtimeHours,
            'graphics_style' => $this->_graphicsStyle,
            'target_audience' => $this->_targetAudience,
            'rating' => $this->_rating,
            'year' => $this->_year,
            'price_eur' => $this->_priceEur,
            'multiplayer' => $this->_multiplayer,
            'story_mode' => $this->_storyMode,
            'game_type' => $this->_gameType,
            'description' => $this->_description,
            'emoji' => $this->_emoji,
        ];
    }
}
