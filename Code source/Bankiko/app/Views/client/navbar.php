<style>
    .navbar-client {
        background-color: #343a40;
        /* Gris noir */
    }

    .navbar-client .navbar-brand,
    .navbar-client .nav-link,
    .navbar-client .btn {
        color: #ffffff !important;
        /* Texte blanc */
        font-size: 1.1rem;
        /* Texte un peu plus grand */
    }

    .navbar-client .nav-link:hover {
        color: #dcdcdc !important;
        /* Couleur de survol légèrement différente */
    }
</style>

<nav class="navbar navbar-expand-lg navbar-client">
    <a class="navbar-brand" href="#">Plateforme Client</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="/client">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/client/depot">Faire un Dépôt</a></li>
            <li class="nav-item"><a class="nav-link" href="/client/retrait">Faire un Retrait</a></li>
            <li class="nav-item"><a class="nav-link" href="/client/pret">Demande de Prêt</a></li>
            <li class="nav-item"><a class="btn btn-danger btn-sm" href="/logout">Déconnexion</a></li>
        </ul>
    </div>
</nav>