<?php session_start();
include('partials/menu.php');

// Détruire la session.
if (session_destroy()) {
	// Redirection vers la page de connexion
	header("Location: login.php");
}
