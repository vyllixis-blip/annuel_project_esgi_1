<?php
/*
** ESGI PROJECT, 2025
** pages/login.php
** File description:
** User login form with mock authentication
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireGuest(); /* Redirect if already logged in */

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck()) {
        $errors['global'] = 'Requête invalide. Veuillez réessayer.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '') $errors['username'] = 'Le nom d\'utilisateur est requis.';
        if ($password === '') $errors['password'] = 'Le mot de passe est requis.';

        if (empty($errors)) {
            $user = mockLogin($username, $password);
            if ($user) {
                loginUser($user);
                flashSet('success', 'Bienvenue, ' . $user['username'] . ' !');
                $intended = $_SESSION['intended'] ?? '/pages/profile.php';
                unset($_SESSION['intended']);
                header('Location: ' . $intended);
                exit;
            } else {
                $errors['global'] = 'Identifiants incorrects. (demo / demo1234)';
            }
        }
    }
}

$pageTitle = 'Connexion';
$activeNav = 'login';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div style="width:100%;max-width:460px;">

        <div class="auth-card">
            <div class="auth-card-header">
                <div class="auth-card-logo">🎮</div>
                <h2>Content de vous revoir !</h2>
                <p>Connectez-vous pour accéder à votre bibliothèque.</p>
            </div>

            <?php if (!empty($errors['global'])): ?>
            <div class="flash flash-error" style="position:static;margin-bottom:20px;animation:none;">
                <span class="flash-icon">✕</span>
                <span><?= e($errors['global']) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="/pages/login.php" novalidate>
                <?= csrfField() ?>

                <div class="form-group">
                    <label class="form-label" for="username">Nom d'utilisateur</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-input <?= isset($errors['username'])?'error':'' ?>"
                        value="<?= e($username) ?>"
                        placeholder="votre_pseudo"
                        autocomplete="username"
                        autofocus
                    >
                    <?php if (isset($errors['username'])): ?>
                    <p class="form-error"><?= e($errors['username']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        Mot de passe
                        <a href="#" style="font-weight:400;color:var(--color-primary-light);font-size:0.78rem;margin-left:8px;">Oublié ?</a>
                    </label>
                    <div class="form-input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input <?= isset($errors['password'])?'error':'' ?>"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        <button type="button" class="form-input-action" data-toggle-password="password">👁</button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                    <p class="form-error"><?= e($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
                    <input type="checkbox" id="remember" name="remember" style="width:16px;height:16px;accent-color:var(--color-primary);">
                    <label for="remember" style="font-size:0.85rem;color:var(--color-text-muted);cursor:pointer;">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn-primary btn-full">
                    Se connecter
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>

                <div class="form-divider">ou</div>

                <p style="text-align:center;font-size:0.78rem;color:var(--color-text-dim);background:rgba(255,255,255,.03);padding:12px;border-radius:var(--radius-sm);border:1px solid var(--color-border);">
                    🔑 Compte démo : <strong style="color:var(--color-text);">demo</strong> / <strong style="color:var(--color-text);">demo1234</strong>
                </p>
            </form>

            <p class="auth-footer">
                Pas encore de compte ? <a href="/pages/register.php">Créer un compte</a>
            </p>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
