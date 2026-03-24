<?php
/*
** ESGI PROJECT, 2025
** includes/footer.php
** File description:
** Shared footer — closes body + HTML
*/
?>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>GameLib</h3>
            <p>Votre plateforme communautaire dédiée à la bibliothèque et la découverte de jeux vidéo. Construite par des joueurs, pour des joueurs.</p>
        </div>

        <div class="footer-section">
            <h4>Navigation</h4>
            <ul>
                <li><a href="/index.php">Accueil</a></li>
                <li><a href="/pages/games.php">Catalogue</a></li>
                <li><a href="/pages/categories.php">Catégories</a></li>
                <li><a href="/pages/collections.php">Collections</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Informations</h4>
            <ul>
                <li><a href="/pages/about.php">À propos</a></li>
                <li><a href="/pages/privacy.php">Confidentialité</a></li>
                <li><a href="/pages/terms.php">CGU</a></li>
                <li><a href="/pages/contact.php">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Réseaux</h4>
            <div class="social-links">
                <a href="#" title="Twitter">𝕏</a>
                <a href="#" title="Discord">💬</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="GitHub">⌨️</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> GameLib. Tous droits réservés.</p>
        <div class="footer-bottom-links">
            <a href="/pages/privacy.php">Confidentialité</a>
            <a href="/pages/terms.php">CGU</a>
            <a href="/pages/contact.php">Contact</a>
        </div>
    </div>
</footer>

<script src="/assets/js/main.js"></script>
</body>
</html>