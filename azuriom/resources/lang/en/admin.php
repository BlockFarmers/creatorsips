<?php

return [
    'permission' => 'Manage creators IPs',

    'nav' => [
        'title' => 'Creators IPs',
        'ips' => 'IPs & statistics',
        'settings' => 'Settings',
    ],

    'download' => [
        'button' => 'Download the plugin',
        'info' => 'Tracking requires the Creators IPs plugin on your Minecraft server (Spigot, Paper, Velocity or BungeeCord). Download it from the GitHub releases.',
        'no_joins' => 'No join received from the Minecraft server yet. Install the Creators IPs plugin on your server, then configure it from the Settings page.',
    ],

    'ips' => [
        'title' => 'Creators IPs',
        'create' => 'Create an IP',
        'edit' => 'Edit IP :hostname',
        'show' => 'Statistics for :hostname',
        'created' => 'The IP has been created.',
        'updated' => 'The IP has been updated.',
        'deleted' => 'The IP has been deleted.',
        'empty' => 'No creator IP yet.',
        'pending' => 'No account yet',
        'pending_help' => 'This username has no website account yet. The IP will be linked automatically when they register.',
        'delete_confirm' => 'Delete IP :hostname? All its statistics will be lost.',
        'edit_notice' => 'Changing the address keeps the statistics already recorded. Only new joins through the new address will be counted.',
    ],

    'fields' => [
        'hostname' => 'Address (IP)',
        'hostname_help' => 'The address the creator gives to their community. DNS must point to your Minecraft server.',
        'creator' => 'Creator',
        'creator_help' => 'Website account name, or Minecraft username if they have no account yet.',
        'description' => 'Note (optional)',
        'enabled' => 'Tracking enabled',
        'enabled_short' => 'Enabled',
        'disabled_short' => 'Disabled',
        'status' => 'Status',
        'actions' => 'Actions',
    ],

    'actions' => [
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'stats' => 'Statistics',
    ],

    'stats' => [
        'unique' => 'Unique players',
        'unique_help' => 'Distinct players who joined at least once with this IP.',
        'new' => 'New players',
        'new_help' => 'Players whose very first join on the server was through this IP.',
        'active' => 'Active (:days d)',
        'active_help' => 'Players who used this IP and joined the server (with any IP) in the last :days days.',
        'active_new' => 'Active new (:days d)',
        'retention_help' => 'New players brought who are still active, and their share of all new players.',
    ],

    'players' => [
        'title' => 'Players who used this IP',
        'name' => 'Player',
        'type' => 'Type',
        'new' => 'New',
        'existing' => 'Existing player',
        'first_joined' => 'First join via IP',
        'last_joined' => 'Last join via IP',
        'joins' => 'Joins via IP',
        'last_seen' => 'Last seen on server',
        'active' => 'Active',
        'empty' => 'No player has joined with this IP yet.',
    ],

    'settings' => [
        'title' => 'Creators IPs settings',
        'stats' => 'Statistics',
        'active_days' => 'Activity period (days)',
        'active_days_help' => 'A player is "active" if they joined at least once during this period. 7 = one week.',
        'minecraft' => 'Minecraft server plugin',
        'minecraft_help' => 'Copy these lines into the plugin configuration file, then restart the server or run /creatorsips reload.',
        'path_server' => 'Spigot, Paper, BungeeCord:',
        'path_velocity' => 'Velocity:',
        'endpoint' => 'URL called by the server:',
        'copy' => 'Copy',
        'copied' => 'Copied!',
        'regenerate' => 'Regenerate token',
        'regenerate_confirm' => 'Regenerate the token? The Minecraft server will stop sending data until its configuration is updated.',
        'saved' => 'Settings saved.',
        'token_regenerated' => 'The token has been regenerated. Remember to update the Minecraft server configuration.',
    ],
];
