<style>
        .navbar-custom {
            background-color: #343a40; /* Gris noir */
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .btn {
            color: #ffffff !important; /* Texte blanc */
            font-size: 1.1rem; /* Texte un peu plus grand */
        }
        .navbar-custom .nav-link:hover {
            color: #dcdcdc !important; /* Légère différence de couleur pour le survol */
        }
    </style>

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">Page Administrateur</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="/admin">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/gestionUtilisateurs">Gestion des Utilisateurs</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/historiqueTransactions">Historique des Transactions</a></li>
            <li class="nav-item"><a class="btn btn-danger btn-sm" href="/logout">Déconnexion</a></li>
        </ul>
    </div>
</nav>