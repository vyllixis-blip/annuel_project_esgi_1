<?php
/*
** ESGI PROJECT, 2025
** logout.php
** File description:
** Destroys session and redirects to home
*/

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

if (isLoggedIn()) {
    logoutUser();
    flashSet('success', 'Vous avez été déconnecté avec succès.');
}

redirect('index.php');
