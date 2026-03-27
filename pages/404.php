<?php
/**
 * 404 Not Found Page
 */

$pageTitle = 'Page non trouvée';
$activeNav = '';

ob_start();
?>
<div class="container" style="padding: 60px 20px; text-align: center;">
    <h1 style="font-size: 3rem; margin-bottom: 20px;">404</h1>
    <h2 style="font-size: 1.5rem; margin-bottom: 20px;">Page non trouvée</h2>
    <p style="color: var(--clr-text-light); margin-bottom: 30px;">Désolé, la page que vous cherchez n'existe pas.</p>
    <a href="/" style="display: inline-block; padding: 10px 20px; background: var(--clr-primary); color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">← Retour à l'accueil</a>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/../../resources/layouts/base.php';
