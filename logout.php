<?php
session_start();

// Détruire la session.
if (session_destroy()) {
    // Redirection vers la page d'accueil.
    header("Location: index");
}
