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

/* ─── Data helpers ──────────────────────────────────────────────── */

/** Find a game by id from the mock array */
function findGame(int $id, array $games): ?array {
    foreach ($games as $g) {
        if ((int)$g['id'] === $id) return $g;
    }
    return null;
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
