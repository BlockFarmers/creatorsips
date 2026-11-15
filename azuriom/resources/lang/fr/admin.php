<?php

return [
    'permission' => 'Gérer les IPs créateurs',

    'nav' => [
        'title' => 'IPs créateurs',
        'ips' => 'IPs & statistiques',
        'settings' => 'Paramètres',
    ],

    'download' => [
        'button' => 'Télécharger le plugin',
        'info' => 'Le suivi nécessite le plugin Creators IPs sur votre serveur Minecraft (Spigot, Paper, Velocity ou BungeeCord). Téléchargez-le depuis les releases GitHub.',
        'no_joins' => 'Aucune connexion reçue du serveur Minecraft pour le moment. Installez le plugin Creators IPs sur votre serveur, puis configurez-le depuis la page Paramètres.',
    ],

    'ips' => [
        'title' => 'IPs créateurs',
        'create' => 'Créer une IP',
        'edit' => 'Modifier l\'IP :hostname',
        'show' => 'Statistiques de :hostname',
        'created' => 'L\'IP a été créée.',
        'updated' => 'L\'IP a été modifiée.',
        'deleted' => 'L\'IP a été supprimée.',
        'empty' => 'Aucune IP créateur pour le moment.',
        'pending' => 'Compte non créé',
        'pending_help' => 'Ce pseudo n\'a pas encore de compte sur le site. L\'IP sera liée automatiquement à son inscription.',
        'delete_confirm' => 'Supprimer l\'IP :hostname ? Toutes ses statistiques seront perdues.',
        'edit_notice' => 'Changer l\'adresse conserve les statistiques déjà enregistrées. Seules les nouvelles connexions via la nouvelle adresse seront comptées.',
    ],

    'fields' => [
        'hostname' => 'Adresse (IP)',
        'hostname_help' => 'L\'adresse que le créateur donne à sa communauté. Le DNS doit pointer vers votre serveur Minecraft.',
        'creator' => 'Créateur',
        'creator_help' => 'Pseudo du compte sur le site, ou pseudo Minecraft s\'il n\'a pas encore de compte.',
        'description' => 'Note (facultatif)',
        'enabled' => 'Suivi activé',
        'enabled_short' => 'Active',
        'disabled_short' => 'Désactivée',
        'status' => 'Statut',
        'actions' => 'Actions',
    ],

    'actions' => [
        'save' => 'Enregistrer',
        'cancel' => 'Annuler',
        'delete' => 'Supprimer',
        'edit' => 'Modifier',
        'stats' => 'Statistiques',
    ],

    'stats' => [
        'unique' => 'Joueurs uniques',
        'unique_help' => 'Joueurs différents qui se sont connectés au moins une fois avec cette IP.',
        'new' => 'Nouveaux joueurs',
        'new_help' => 'Joueurs dont la toute première connexion au serveur s\'est faite avec cette IP.',
        'active' => 'Actifs (:days j)',
        'active_help' => 'Joueurs passés par cette IP qui se sont connectés au serveur (avec n\'importe quelle IP) ces :days derniers jours.',
        'active_new' => 'Nouveaux actifs (:days j)',
        'retention_help' => 'Nouveaux joueurs ramenés encore actifs, et leur part sur le total des nouveaux joueurs.',
    ],

    'players' => [
        'title' => 'Joueurs passés par cette IP',
        'name' => 'Joueur',
        'type' => 'Type',
        'new' => 'Nouveau',
        'existing' => 'Déjà joueur',
        'first_joined' => '1re connexion via l\'IP',
        'last_joined' => 'Dernière connexion via l\'IP',
        'joins' => 'Connexions via l\'IP',
        'last_seen' => 'Dernière connexion au serveur',
        'active' => 'Actif',
        'empty' => 'Aucun joueur ne s\'est encore connecté avec cette IP.',
    ],

    'settings' => [
        'title' => 'Paramètres des IPs créateurs',
        'stats' => 'Statistiques',
        'active_days' => 'Période d\'activité (jours)',
        'active_days_help' => 'Un joueur est « actif » s\'il s\'est connecté au moins une fois pendant cette période. 7 = une semaine.',
        'minecraft' => 'Plugin du serveur Minecraft',
        'minecraft_help' => 'Copiez ces lignes dans le fichier de configuration du plugin, puis redémarrez le serveur ou tapez /creatorsips reload.',
        'path_server' => 'Spigot, Paper, BungeeCord :',
        'path_velocity' => 'Velocity :',
        'endpoint' => 'Adresse appelée par le serveur :',
        'copy' => 'Copier',
        'copied' => 'Copié !',
        'regenerate' => 'Régénérer le jeton',
        'regenerate_confirm' => 'Régénérer le jeton ? Le serveur Minecraft ne pourra plus envoyer de données tant que sa configuration n\'est pas mise à jour.',
        'saved' => 'Les paramètres ont été enregistrés.',
        'token_regenerated' => 'Le jeton a été régénéré. Pensez à mettre à jour la configuration du serveur Minecraft.',
    ],
];
