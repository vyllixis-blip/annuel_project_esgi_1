<?php
/*
** ESGI PROJECT, 2025
** pages/contact.php
** File description:
** Contact form with validation
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$errors  = [];
$success = false;
$fields  = ['name'=>'','email'=>'','subject'=>'','message'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck()) {
        $errors['global'] = 'Requête invalide.';
    } else {
        $fields['name']    = trim($_POST['name']    ?? '');
        $fields['email']   = trim($_POST['email']   ?? '');
        $fields['subject'] = trim($_POST['subject'] ?? '');
        $fields['message'] = trim($_POST['message'] ?? '');

        if (strlen($fields['name']) < 2)         $errors['name']    = 'Votre nom est requis (2 caractères min).';
        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Adresse e-mail invalide.';
        if ($fields['subject'] === '')            $errors['subject'] = 'Un sujet est requis.';
        if (strlen($fields['message']) < 20)     $errors['message'] = 'Le message doit faire au moins 20 caractères.';

        if (empty($errors)) {
            /* TODO: mail($to, $subject, $body) or store in DB */
            $success = true;
            $fields  = ['name'=>'','email'=>'','subject'=>'','message'=>''];
        }
    }
}

$pageTitle = 'Contact';
$pageDesc  = 'Contactez l\'équipe GameLib — questions, suggestions, signalements.';
$activeNav = '';

$user = currentUser();

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow">
                <div class="page-hero-eyebrow-line"></div>
                <span>Nous contacter</span>
            </div>
            <h1>Une question ? <span class="gradient-text">Écrivez-nous.</span></h1>
            <p>Notre équipe répond sous 24–48 h en jours ouvrés.</p>
        </div>
    </div>
</div>

<main style="padding:60px 0 80px;">
    <div class="container">
        <div class="contact-grid">

            <!-- Info panel -->
            <div>
                <div class="contact-info-card" style="margin-bottom:24px;">
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:24px;">Informations de contact</h3>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">📧</div>
                        <div class="contact-info-text">
                            <h4>E-mail</h4>
                            <p>contact@gamelib.fr</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">💬</div>
                        <div class="contact-info-text">
                            <h4>Discord</h4>
                            <p>discord.gg/gamelib</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">🕐</div>
                        <div class="contact-info-text">
                            <h4>Disponibilité</h4>
                            <p>Lun–Ven, 9h–18h (CET)</p>
                        </div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;">Motifs fréquents</h3>
                    <?php
                    $topics = ['🐛 Signaler un bug','💡 Suggérer une fonctionnalité','🎮 Jeu manquant dans le catalogue','👤 Problème de compte','🤝 Partenariat & presse'];
                    foreach ($topics as $t):
                    ?>
                    <div style="padding:10px 0;border-bottom:1px solid var(--color-border);font-size:0.85rem;color:var(--color-text-muted);">
                        <?= e($t) ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Form -->
            <div class="contact-form-card">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:24px;">Envoyer un message</h3>

                <?php if ($success): ?>
                <div class="flash flash-success" style="position:static;animation:none;margin-bottom:24px;">
                    <span class="flash-icon">✓</span>
                    <span>Message envoyé ! Nous reviendrons vers vous rapidement.</span>
                </div>
                <?php endif; ?>

                <?php if (!empty($errors['global'])): ?>
                <div class="flash flash-error" style="position:static;animation:none;margin-bottom:24px;">
                    <span class="flash-icon">✕</span>
                    <span><?= e($errors['global']) ?></span>
                </div>
                <?php endif; ?>

                <form method="POST" action="/pages/contact.php" novalidate>
                    <?= csrfField() ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nom</label>
                            <input type="text" name="name" class="form-input <?= isset($errors['name'])?'error':'' ?>"
                                   value="<?= e($user ? $user['username'] : $fields['name']) ?>"
                                   placeholder="Votre nom">
                            <?php if (isset($errors['name'])): ?><p class="form-error"><?= e($errors['name']) ?></p><?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-input <?= isset($errors['email'])?'error':'' ?>"
                                   value="<?= e($user ? $user['email'] : $fields['email']) ?>"
                                   placeholder="vous@exemple.com">
                            <?php if (isset($errors['email'])): ?><p class="form-error"><?= e($errors['email']) ?></p><?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Sujet</label>
                        <select name="subject" class="filter-select form-input" style="width:100%;padding:13px 16px;">
                            <option value="">Choisissez un sujet…</option>
                            <option value="bug"       <?= $fields['subject']==='bug'       ?'selected':'' ?>>🐛 Signaler un bug</option>
                            <option value="feature"   <?= $fields['subject']==='feature'   ?'selected':'' ?>>💡 Suggestion de fonctionnalité</option>
                            <option value="game"      <?= $fields['subject']==='game'      ?'selected':'' ?>>🎮 Jeu manquant</option>
                            <option value="account"   <?= $fields['subject']==='account'   ?'selected':'' ?>>👤 Problème de compte</option>
                            <option value="partnership"<?= $fields['subject']==='partnership'?'selected':'' ?>>🤝 Partenariat</option>
                            <option value="other"     <?= $fields['subject']==='other'     ?'selected':'' ?>>❓ Autre</option>
                        </select>
                        <?php if (isset($errors['subject'])): ?><p class="form-error"><?= e($errors['subject']) ?></p><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-input <?= isset($errors['message'])?'error':'' ?>"
                                  rows="6" placeholder="Décrivez votre demande…"><?= e($fields['message']) ?></textarea>
                        <?php if (isset($errors['message'])): ?><p class="form-error"><?= e($errors['message']) ?></p><?php endif; ?>
                    </div>

                    <button type="submit" class="btn-primary btn-full">
                        Envoyer le message
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
            </div>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
