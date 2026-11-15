# CreatorsIPs

Give each content creator their own server address (for example `steve.example.com`) and see how many
players they really bring to your Minecraft server.

CreatorsIPs is made of two parts:

| Part | Role |
|---|---|
| Azuriom plugin | Manage creators IPs and read the statistics from your Azuriom admin panel. |
| Minecraft plugin | Sends the address typed by each player to your website. One jar for Spigot, Paper, Folia, Velocity and BungeeCord. |

The Minecraft plugin is required: only the Minecraft server knows which address a player typed to join.

## Features

- **Creators IPs**: create, edit, disable or delete a custom address for each creator.
- **Website accounts or Minecraft usernames**: link an IP to a website account, or to a Minecraft username
  if the creator has no account yet. The IP is linked automatically when they register.
- **Statistics per IP**:
  - **Unique players**: distinct players who joined with the IP.
  - **New players**: players whose very first join on the server was through the IP.
  - **Active players**: players who used the IP and joined the server (with any address) during the last
    7 days. The period can be changed in the settings.
  - **Active new players** and the retention rate.
  - The list of every player with their first join, last join and number of joins through the IP.
- **Reload command**: `/creatorsips reload` on the Minecraft server or proxy.

## Requirements

- Azuriom 1.2.0 or newer
- Java 17 or newer on the Minecraft server
- Spigot / Paper / Folia 1.13+, Velocity 3.x or BungeeCord / Waterfall

## Installation

### 1. DNS

Every creator address must point to your Minecraft server. The easiest way is a wildcard record in your DNS zone:

| Type | Name | Target |
|---|---|---|
| A | `*` | IP address of your Minecraft server |

Existing records (`www`, `play`, …) keep priority over the wildcard. If your server does not use the default port
`25565`, you need one SRV record per creator address instead, because wildcard SRV records are not supported by
Minecraft.

### 2. Azuriom plugin

Install **CreatorsIPs** from the Azuriom market, or download `creatorsips-azuriom-x.y.z.zip` from the
[releases](https://github.com/BlockFarmers/creatorsips/releases) and extract it into `plugins/creatorsips`.
Then enable it in **Admin → Plugins**.

### 3. Minecraft plugin

1. Download `CreatorsIPs-x.y.z.jar` from the [releases](https://github.com/BlockFarmers/creatorsips/releases).
2. Put it in the `plugins/` folder of the **first server players connect to**:
   - your proxy (Velocity or BungeeCord) if you have one, and **only** the proxy;
   - otherwise your Spigot / Paper server.
3. Start the server once to generate the configuration file:
   - Spigot, Paper, BungeeCord: `plugins/CreatorsIPs/config.properties`
   - Velocity: `plugins/creatorsips/config.properties`
4. In Azuriom, open **Creators IPs → Settings** and copy the `site-url` and `token` lines into this file.
5. Run `/creatorsips reload` or restart the server.

```properties
site-url=https://example.com
token=your-token
debug=false
```

Set `debug=true` to log every join sent to the website.

### 4. Create an IP

In **Creators IPs → IPs & statistics**, click **Create an IP**, enter the address (`steve.example.com`) and the
creator's name. Join the server with this address: you appear in the IP statistics.

## Commands and permissions

| Command | Permission | Description |
|---|---|---|
| `/creatorsips reload` | `creatorsips.reload` | Reloads `config.properties`. |

In Azuriom, the `Manage creators IPs` permission gives access to the admin pages.

## Good to know

- Only joins made after the installation are counted.
- On Spigot / Paper the server knows if a player has played before. On a proxy, a player is considered new when
  the website has never seen them, so during the first weeks some returning players may be counted as new.
- If the website is unreachable when a player joins, that join is not counted. An error is logged in the console.
- Disabling an IP stops the tracking and keeps its statistics. Deleting it removes its statistics.

## Building from source

```bash
cd minecraft
mvn package
```

The jar is created in `minecraft/target/`.