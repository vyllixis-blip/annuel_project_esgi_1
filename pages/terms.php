<?php
/*
** ESGI PROJECT, 2025
** pages/terms.php
** File description:
** Terms of service page
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = "Conditions d'utilisation";
$pageDesc  = "Les règles d'utilisation de la plateforme GameLib.";
$activeNav = '';

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow"><div class="page-hero-eyebrow-line"></div><span>Légal</span></div>
            <h1>Conditions <span class="gradient-text">d'utilisation</span></h1>
            <p>Dernière mise à jour : 1er janvier 2025</p>
        </div>
    </div>
</div>

<main style="padding:60px 0 80px;">
    <div class="container">
        <div class="text-page">

            <h2>1. Acceptation des conditions</h2>
            <p>En accédant à GameLib et en créant un compte, vous acceptez d'être lié par les présentes Conditions d'Utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser la plateforme.</p>

            <h2>2. Utilisation autorisée</h2>
            <p>GameLib est une plateforme destinée à :</p>
            <ul>
                <li>Gérer et partager votre bibliothèque de jeux vidéo</li>
                <li>Rédiger et consulter des critiques de jeux</li>
                <li>Créer et partager des listes et collections thématiques</li>
                <li>Interagir de manière respectueuse avec la communauté</li>
            </ul>

            <h2>3. Comportements interdits</h2>
            <p>Il est interdit sur GameLib de :</p>
            <ul>
                <li>Publier du contenu haineux, discriminatoire, illégal ou portant atteinte à des droits de tiers</li>
                <li>Spammer, harceler ou menacer d'autres utilisateurs</li>
                <li>Créer des faux comptes ou usurper l'identité d'une personne</li>
                <li>Tenter de compromettre la sécurité de la plateforme</li>
                <li>Utiliser des bots ou scripts automatisés sans autorisation</li>
                <li>Reproduire le contenu de la plateforme à des fins commerciales sans accord</li>
            </ul>

            <h2>4. Contenu utilisateur</h2>
            <p>En publiant du contenu (critiques, listes, commentaires), vous accordez à GameLib une licence mondiale, non exclusive et gratuite pour afficher, distribuer et promouvoir ce contenu sur la plateforme. Vous conservez l'intégralité de vos droits d'auteur.</p>
            <p>Vous êtes seul responsable du contenu que vous publiez. GameLib se réserve le droit de supprimer tout contenu qui violerait ces conditions.</p>

            <h2>5. Compte utilisateur</h2>
            <p>Vous êtes responsable de la confidentialité de vos identifiants et de toute activité effectuée depuis votre compte. En cas de compromission, contactez-nous immédiatement à <strong>security@gamelib.fr</strong>.</p>
            <p>GameLib se réserve le droit de suspendre ou supprimer tout compte en violation de ces conditions, sans préavis.</p>

            <h2>6. Propriété intellectuelle</h2>
            <p>Le code source, le design, le logo et le contenu éditorial de GameLib sont protégés par le droit d'auteur et appartiennent à GameLib SAS. Toute reproduction non autorisée est interdite.</p>
            <p>Les noms, logos et visuels de jeux vidéo tiers appartiennent à leurs éditeurs respectifs.</p>

            <h2>7. Limitation de responsabilité</h2>
            <p>GameLib est fourni "en l'état". Nous ne garantissons pas l'exactitude des informations sur les jeux (sources : communauté). En aucun cas GameLib ne pourra être tenu responsable de dommages indirects résultant de l'utilisation de la plateforme.</p>

            <h2>8. Modifications du service</h2>
            <p>GameLib se réserve le droit de modifier, suspendre ou interrompre tout ou partie du service à tout moment, avec ou sans préavis.</p>

            <h2>9. Droit applicable</h2>
            <p>Les présentes conditions sont soumises au droit français. En cas de litige, les tribunaux compétents seront ceux du ressort du siège de GameLib (Paris, France).</p>

            <h2>10. Contact</h2>
            <p>Pour toute question : <a href="/pages/contact.php" style="color:var(--color-primary-light);">legal@gamelib.fr</a></p>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
