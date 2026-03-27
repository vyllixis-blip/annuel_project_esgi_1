<?php
/*
** ESGI PROJECT, 2025
** includes/functions.php
** File description:
** Global helper functions used across all pages
*/

/* ─── HTML Helpers ──────────────────────────────────────────────── */

/** Escape for safe HTML output */
function e(mixed $val): string {
    return htmlspecialchars((string)$val, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Render star rating (out of 10 → 5 stars) */
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

/** Badge CSS class from type string */
function badgeClass(string $type): string {
    return match ($type) {
        'warm'   => 'badge-warm',
        'accent' => 'badge-accent',
        'new'    => 'badge-new',
        default  => 'badge-primary',
    };
}

/** Truncate text safely */
function truncate(string $text, int $max = 100, string $suffix = '…'): string {
    if (mb_strlen($text) <= $max) return $text;
    return mb_substr($text, 0, $max) . $suffix;
}

/** Format a number nicely (1400 → 1 400) */
function fmtNumber(int|float $n): string {
    return number_format($n, 0, ',', ' ');
}

/** Generate unique gradient CSS for games */
function gameGradient(int $gameId = 1, string $difficulty = '', string $graphics = ''): string {
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

/* ─── URL Helpers ───────────────────────────────────────────────── */

/** Build an absolute URL from a root-relative path */
function url(string $path = ''): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

/** Redirect to a root-relative path */
function redirect(string $path): never {
    header('Location: ' . url($path));
    exit;
}

/* ─── Flash messages ────────────────────────────────────────────── */

function flashSet(string $type, string $message): void {
    $_SESSION['_flash'][$type] = $message;
}

function flashGet(string $type): ?string {
    $msg = $_SESSION['_flash'][$type] ?? null;
    unset($_SESSION['_flash'][$type]);
    return $msg;
}

function flashHtml(): string {
    if (empty($_SESSION['_flash'])) return '';
    $html = '';
    foreach ($_SESSION['_flash'] as $type => $msg) {
        $color = match($type) {
            'success' => '#22c55e',
            'error'   => '#ef4444',
            'warning' => '#f59e0b',
            default   => '#06b6d4',
        };
        $icon = match($type) {
            'success' => '✓',
            'error'   => '✕',
            'warning' => '⚠',
            default   => 'ℹ',
        };
        $html .= sprintf(
            '<div class="flash flash-%s" style="--flash-color:%s">
                <span class="flash-icon">%s</span>
                <span>%s</span>
                <button onclick="this.parentElement.remove()" class="flash-close">×</button>
             </div>',
            e($type), $color, $icon, e($msg)
        );
    }
    unset($_SESSION['_flash']);
    return $html;
}

/* ─── CSV Data helpers ──────────────────────────────────────────── */

/** Load games from CSV file */
function loadGamesFromCSV(string $csvPath): array {
    $games = [];
    if (!file_exists($csvPath)) {
        return [];
    }
    
    $file = fopen($csvPath, 'r');
    $headers = fgetcsv($file);
    if (!$headers) return [];
    
    while (($row = fgetcsv($file)) !== false) {
        // Skip empty rows and ensure row length matches headers
        if (empty(array_filter($row)) || count($row) !== count($headers)) {
            continue;
        }
        
        $game = array_combine($headers, $row);
        if ($game !== false) {
            // Parse multi-value fields
            $game['platforms'] = array_filter(explode('|', $game['platforms'] ?? ''));
            $games[] = $game;
        }
    }
    fclose($file);
    return $games;
}

/** Find a game by id from the games array */
function findGame(int $id, array $games): ?array {
    foreach ($games as $g) {
        if ((int)$g['id'] === $id) return $g;
    }
    return null;
}

/** Filter games advanced criteria */
function filterGamesAdvanced(
    array $games, 
    string $q = '', 
    string $difficulty = '',
    string $graphics = '',
    string $audience = '',
    string $sort = 'rating'
): array {
    // Text search
    if ($q !== '') {
        $q_low = mb_strtolower($q);
        $games = array_filter($games, fn($g) =>
            str_contains(mb_strtolower($g['title'] ?? ''), $q_low) ||
            str_contains(mb_strtolower($g['genre'] ?? ''), $q_low) ||
            str_contains(mb_strtolower($g['description'] ?? ''), $q_low)
        );
    }
    
    // Difficulty filter
    if ($difficulty !== '') {
        $games = array_filter($games, fn($g) =>
            str_contains($g['difficulty'] ?? '', $difficulty)
        );
    }
    
    // Graphics style filter
    if ($graphics !== '') {
        $games = array_filter($games, fn($g) =>
            str_contains($g['graphics_style'] ?? '', $graphics)
        );
    }
    
    // Target audience filter
    if ($audience !== '') {
        $games = array_filter($games, fn($g) =>
            str_contains($g['target_audience'] ?? '', $audience)
        );
    }
    
    $games = array_values($games);
    
    // Sorting
    usort($games, match($sort) {
        'newest' => fn($a,$b) => (int)$b['year'] <=> (int)$a['year'],
        'oldest' => fn($a,$b) => (int)$a['year'] <=> (int)$b['year'],
        'az'     => fn($a,$b) => strcmp($a['title'], $b['title']),
        'za'     => fn($a,$b) => strcmp($b['title'], $a['title']),
        'price_low' => fn($a,$b) => (($a['price_eur'] == 'Gratuit (F2P)' ? 0 : (float)str_replace(',', '.', $a['price_eur'])) <=> ($b['price_eur'] == 'Gratuit (F2P)' ? 0 : (float)str_replace(',', '.', $b['price_eur']))),
        'price_high' => fn($a,$b) => (($b['price_eur'] == 'Gratuit (F2P)' ? 0 : (float)str_replace(',', '.', $b['price_eur'])) <=> ($a['price_eur'] == 'Gratuit (F2P)' ? 0 : (float)str_replace(',', '.', $a['price_eur']))),
        default  => fn($a,$b) => (float)$b['rating'] <=> (float)$a['rating'],
    });
    
    return $games;
}

/** Filter games by query string */
function filterGames(array $games, string $q = '', string $genre = '', string $sort = 'rating'): array {
    if ($q !== '') {
        $q_low = mb_strtolower($q);
        $games = array_filter($games, fn($g) =>
            str_contains(mb_strtolower($g['title']), $q_low) ||
            str_contains(mb_strtolower($g['genre']), $q_low) ||
            str_contains(mb_strtolower($g['studio'] ?? ''), $q_low)
        );
    }
    if ($genre !== '') {
        $genre_low = mb_strtolower($genre);
        $games = array_filter($games, fn($g) =>
            str_contains(mb_strtolower($g['genre']), $genre_low) ||
            in_array($genre_low, array_map('mb_strtolower', $g['tags'] ?? []))
        );
    }
    $games = array_values($games);
    usort($games, match($sort) {
        'newest' => fn($a,$b) => (int)$b['year'] <=> (int)$a['year'],
        'oldest' => fn($a,$b) => (int)$a['year'] <=> (int)$b['year'],
        'az'     => fn($a,$b) => strcmp($a['title'], $b['title']),
        'za'     => fn($a,$b) => strcmp($b['title'], $a['title']),
        default  => fn($a,$b) => $b['rating'] <=> $a['rating'],
    });
    return $games;
}

/* ─── CSRF ──────────────────────────────────────────────────────── */

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function csrfCheck(): bool {
    return isset($_POST['csrf_token']) && hash_equals(csrfToken(), $_POST['csrf_token']);
}

/* ─── Pagination ────────────────────────────────────────────────── */

function paginate(array $items, int $page, int $perPage): array {
    $total = count($items);
    $pages = (int) ceil($total / $perPage);
    $page  = max(1, min($page, $pages ?: 1));
    $slice = array_slice($items, ($page - 1) * $perPage, $perPage);
    return [
        'items'   => $slice,
        'total'   => $total,
        'page'    => $page,
        'pages'   => $pages,
        'perPage' => $perPage,
    ];
}
