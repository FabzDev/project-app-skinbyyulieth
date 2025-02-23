<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// Verifica que el usuario esté logeado
function isAuth(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Verifica que el usuario sea admin
function isAdmin(): void
{
    // debuggear($_SESSION);
    if (!(isset($_SESSION['login']) && isset($_SESSION['admin']))) {
        header('Location: /');
    }
}
