<?php

namespace GameLib\Utils;

/**
 * String Helper - String manipulation utilities
 *
 * @package GameLib\Utils
 * @author ESGI Project Team
 * @version 1.0.0
 */
class StringHelper
{
    /**
     * Escape for safe HTML output
     */
    public static function escape(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Truncate text safely
     */
    public static function truncate(string $text, int $max = 100, string $suffix = '…'): string
    {
        if (mb_strlen($text) <= $max) {
            return $text;
        }
        return mb_substr($text, 0, $max) . $suffix;
    }

    /**
     * Format number nicely (1400 → 1 400)
     */
    public static function formatNumber(int|float $number): string
    {
        return number_format($number, 0, ',', ' ');
    }

    /**
     * Format stars rating (out of 10 → 5 stars)
     */
    public static function renderStars(float $rating): string
    {
        $full = (int) floor($rating / 2);
        $half = ($rating / 2 - $full) >= 0.5 ? 1 : 0;
        $empty = 5 - $full - $half;

        $html = '<div class="star-rating">';
        for ($i = 0; $i < $full; $i++) {
            $html .= '<span class="star">★</span>';
        }
        if ($half) {
            $html .= '<span class="star" style="opacity:.5">★</span>';
        }
        for ($i = 0; $i < $empty; $i++) {
            $html .= '<span class="star-empty">★</span>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Generate unique gradient background for games
     * @param int $gameId Game ID for deterministic gradient
     * @param string $difficulty Difficulty level
     * @param string $graphics Graphics style
     * @return string CSS gradient string
     */
    public static function generateGameGradient(
        int $gameId = 1,
        string $difficulty = '',
        string $graphics = ''
    ): string {
        // Color palette based on difficulty
        $difficultyColors = [
            'Très Facile' => ['#10b981', '#34d399'],
            'Facile' => ['#3b82f6', '#60a5fa'],
            'Moyen' => ['#f59e0b', '#fbbf24'],
            'Difficile' => ['#ef4444', '#f87171'],
        ];

        // Accent colors based on graphics
        $graphicsColors = [
            '2D Pixel Art' => '8b5cf6',
            '2D Stylisé' => 'a855f7',
            '3D Stylisé' => '06b6d4',
            '3D Réaliste' => '6366f1',
            '3D Abstrait' => 'ec4899',
        ];

        $baseGradient = $difficultyColors[$difficulty] ?? ['#667eea', '#764ba2'];
        $accentColor = $graphicsColors[$graphics] ?? 'f472b6';
        $rotationVar = ($gameId * 13) % 360;

        $color1 = $baseGradient[0];
        $color2 = $baseGradient[1];

        return "linear-gradient({$rotationVar}deg, {$color1}, #{$accentColor}, {$color2})";
    }
}
