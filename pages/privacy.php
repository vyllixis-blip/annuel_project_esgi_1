<?php
/*
** ESGI PROJECT, 2025
** pages/privacy.php
** File description:
** Privacy policy page
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Politique de confidentialité';
$pageDesc  = 'Comment GameLib collecte, utilise et protège vos données personnelles.';
$activeNav = '';

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow"><div class="page-hero-eyebrow-line"></div><span>Légal</span></div>
            <h1>Politique de <span class="gradient-text">Confidentialité</span></h1>
            <p>Dernière mise à jour : 1er janvier 2025</p>
        </div>
    </div>
</div>

<main style="padding:60px 0 80px;">
    <div class="container">
        <div class="text-page">

            <h2>1. Collecte des données</h2>
            <p>GameLib collecte les informations que vous fournissez directement lors de la création de votre compte (nom d'utilisateur, adresse e-mail, mot de passe haché) et lors de vos interactions avec la plateforme (critiques, listes, jeux ajoutés à votre collection).</p>
            <p>Nous collectons également automatiquement certaines données techniques : adresse IP, navigateur, pages visitées et durée de session, à des fins d'analyse et de sécurité.</p>

            <h2>2. Utilisation des données</h2>
            <p>Vos données sont utilisées pour :</p>
            <ul>
                <li>Gérer votre compte et personnaliser votre expérience</li>
                <li>Afficher votre collection et vos critiques</li>
                <li>Vous envoyer des notifications liées à votre activité (si activées)</li>
                <li>Améliorer nos services grâce à des statistiques agrégées et anonymisées</li>
                <li>Assurer la sécurité de la plateforme et prévenir les abus</li>
            </ul>

            <h2>3. Partage des données</h2>
            <p>Nous ne vendons ni ne louons vos données personnelles à des tiers. Nous pouvons partager des informations avec :</p>
            <ul>
                <li><strong>Prestataires techniques</strong> : hébergement, envoi d'e-mails transactionnels</li>
                <li><strong>Autorités compétentes</strong> : uniquement si requis par la loi</li>
            </ul>

            <h2>4. Cookies</h2>
            <p>GameLib utilise des cookies strictement nécessaires au fonctionnement du site (session d'authentification). Aucun cookie publicitaire ou de tracking tiers n'est utilisé.</p>

            <h2>5. Conservation des données</h2>
            <p>Vos données sont conservées tant que votre compte est actif. Après suppression de votre compte, vos données personnelles sont effacées sous 30 jours. Les critiques publiées peuvent être anonymisées plutôt que supprimées.</p>

            <h2>6. Vos droits (RGPD)</h2>
            <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :</p>
            <ul>
                <li><strong>Accès</strong> : obtenir une copie de vos données</li>
                <li><strong>Rectification</strong> : corriger des informations inexactes</li>
                <li><strong>Effacement</strong> : demander la suppression de vos données</li>
                <li><strong>Portabilité</strong> : recevoir vos données dans un format structuré</li>
                <li><strong>Opposition</strong> : s'opposer à certains traitements</li>
            </ul>
            <p>Pour exercer ces droits, contactez-nous à <strong>privacy@gamelib.fr</strong>.</p>

            <h2>7. Sécurité</h2>
            <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données : chiffrement des mots de passe (bcrypt), HTTPS, accès restreint aux bases de données.</p>

            <h2>8. Modifications</h2>
            <p>Cette politique peut être modifiée. En cas de changement significatif, nous vous informerons par e-mail ou par notification sur la plateforme.</p>

            <h2>9. Contact</h2>
            <p>Pour toute question relative à cette politique : <a href="/pages/contact.php" style="color:var(--color-primary-light);">privacy@gamelib.fr</a></p>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
