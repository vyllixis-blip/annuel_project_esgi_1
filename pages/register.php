<?php
/*
** ESGI PROJECT, 2025
** pages/register.php
** File description:
** New user registration form
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireGuest();

$errors = [];
$fields = ['username' => '', 'email' => '', 'confirm' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck()) {
        $errors['global'] = 'Requête invalide. Veuillez réessayer.';
    } else {
        $fields['username'] = trim($_POST['username'] ?? '');
        $fields['email']    = trim($_POST['email']    ?? '');
        $password           = $_POST['password']  ?? '';
        $fields['confirm']  = $_POST['confirm']   ?? '';
        $tos                = !empty($_POST['tos']);

        /* Validation */
        if (strlen($fields['username']) < 3)
            $errors['username'] = 'Le pseudo doit faire au moins 3 caractères.';
        elseif (!preg_match('/^[a-zA-Z0-9_\-]+$/', $fields['username']))
            $errors['username'] = 'Caractères autorisés : lettres, chiffres, _ et -.';

        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = 'Adresse e-mail invalide.';

        if (strlen($password) < 8)
            $errors['password'] = 'Le mot de passe doit faire au moins 8 caractères.';

        if ($password !== $fields['confirm'])
            $errors['confirm'] = 'Les mots de passe ne correspondent pas.';

        if (!$tos)
            $errors['tos'] = 'Vous devez accepter les conditions d\'utilisation.';

        if (empty($errors)) {
            /* TODO: insert into DB, send confirmation email */
            /* Mock: log the user in directly */
            loginUser([
                'id'       => rand(100, 9999),
                'username' => $fields['username'],
                'email'    => $fields['email'],
                'avatar'   => '🧑‍💻',
                'role'     => 'user',
            ]);
            flashSet('success', 'Bienvenue sur GameLib, ' . $fields['username'] . ' !');
            redirect('pages/profile.php');
        }
    }
}

$pageTitle = 'Inscription';
$activeNav = '';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div style="width:100%;max-width:480px;">
        <div class="auth-card">
            <div class="auth-card-header">
                <div class="auth-card-logo">🚀</div>
                <h2>Créer un compte</h2>
                <p>Rejoignez la communauté GameLib — c'est gratuit.</p>
            </div>

            <?php if (!empty($errors['global'])): ?>
            <div class="flash flash-error" style="position:static;margin-bottom:20px;animation:none;">
                <span class="flash-icon">✕</span>
                <span><?= e($errors['global']) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="/pages/register.php" novalidate>
                <?= csrfField() ?>

                <div class="form-group">
                    <label class="form-label" for="username">Pseudo</label>
                    <input type="text" id="username" name="username"
                           class="form-input <?= isset($errors['username'])?'error':'' ?>"
                           value="<?= e($fields['username']) ?>"
                           placeholder="cool_gamer42" autocomplete="username" autofocus>
                    <?php if (isset($errors['username'])): ?>
                    <p class="form-error"><?= e($errors['username']) ?></p>
                    <?php else: ?>
                    <p class="form-hint">Lettres, chiffres, _ et - uniquement.</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email"
                           class="form-input <?= isset($errors['email'])?'error':'' ?>"
                           value="<?= e($fields['email']) ?>"
                           placeholder="vous@exemple.com" autocomplete="email">
                    <?php if (isset($errors['email'])): ?>
                    <p class="form-error"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <div class="form-input-wrapper">
                        <input type="password" id="password" name="password"
                               class="form-input <?= isset($errors['password'])?'error':'' ?>"
                               placeholder="Au moins 8 caractères" autocomplete="new-password">
                        <button type="button" class="form-input-action" data-toggle-password="password">👁</button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                    <p class="form-error"><?= e($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm">Confirmer le mot de passe</label>
                    <div class="form-input-wrapper">
                        <input type="password" id="confirm" name="confirm"
                               class="form-input <?= isset($errors['confirm'])?'error':'' ?>"
                               placeholder="••••••••" autocomplete="new-password">
                        <button type="button" class="form-input-action" data-toggle-password="confirm">👁</button>
                    </div>
                    <?php if (isset($errors['confirm'])): ?>
                    <p class="form-error"><?= e($errors['confirm']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="display:flex;align-items:flex-start;gap:10px;">
                    <input type="checkbox" id="tos" name="tos"
                           style="width:16px;height:16px;accent-color:var(--color-primary);margin-top:2px;flex-shrink:0;"
                           <?= !empty($_POST['tos'])?'checked':'' ?>>
                    <label for="tos" style="font-size:0.85rem;color:var(--color-text-muted);cursor:pointer;line-height:1.5;">
                        J'accepte les <a href="/pages/terms.php" style="color:var(--color-primary-light);">Conditions d'utilisation</a>
                        et la <a href="/pages/privacy.php" style="color:var(--color-primary-light);">Politique de confidentialité</a>.
                    </label>
                </div>
                <?php if (isset($errors['tos'])): ?>
                <p class="form-error" style="margin-top:-12px;margin-bottom:16px;"><?= e($errors['tos']) ?></p>
                <?php endif; ?>

                <button type="submit" class="btn-primary btn-full">
                    Créer mon compte
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </form>

            <p class="auth-footer">
                Déjà un compte ? <a href="/pages/login.php">Se connecter</a>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
