-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 sep. 2024 à 06:21
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `banqueko`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `solde` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `utilisateur_id`, `solde`) VALUES
(1, 1, '0.00'),
(3, 6, '3200.00'),
(5, 8, '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `prets`
--

CREATE TABLE `prets` (
  `id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `rembourser` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('en_cours','rembourse') DEFAULT 'en_cours',
  `date_emprunt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prets`
--

INSERT INTO `prets` (`id`, `compte_id`, `montant`, `rembourser`, `status`, `date_emprunt`) VALUES
(14, 3, '0.00', '0.00', 'en_cours', '2024-09-02 04:09:51'),
(16, 5, '0.00', '0.00', '', '2024-09-03 04:20:10');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `type` enum('depot','retrait') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `compte_id`, `type`, `montant`, `date`) VALUES
(2, 1, 'retrait', '1000.00', '2024-09-01 08:53:56'),
(26, 3, 'depot', '3000.00', '2024-09-02 12:45:17');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telephone` int(200) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `email`, `telephone`, `role`) VALUES
(1, 'admin', '$2y$10$eR8EowyPbeR10nolTYvT8OtSETBOqzPtHrD.yyV2DuVMQs1P.DuYq', 'admin@gmail.com', 340000000, 'admin'),
(6, 'Tohy Ny Aina', '$2y$10$PlLtZjm2UMFQzE7gYFeIWOja9PuzNH4k3VtJUK6qDJu.Bn/8RQePm', 'tohiniainarazafi@gmail.com', 346850871, 'client'),
(8, 'Rakoto', '$2y$10$qcxonzDy325xXY4Wo5Xe.O1bnjYh4tQ2.mQlYYrIWNnSGxLx7NWyG', 'rakoto@gmail.com', 324744588, 'client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `prets`
--
ALTER TABLE `prets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compte_id` (`compte_id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compte_id` (`compte_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `prets`
--
ALTER TABLE `prets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD CONSTRAINT `comptes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `prets`
--
ALTER TABLE `prets`
  ADD CONSTRAINT `prets_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`);

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
