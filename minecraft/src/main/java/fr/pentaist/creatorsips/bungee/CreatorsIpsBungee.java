package fr.pentaist.creatorsips.bungee;

import fr.pentaist.creatorsips.common.JoinTracker;
import fr.pentaist.creatorsips.common.PluginLogger;
import net.md_5.bungee.api.connection.ProxiedPlayer;
import net.md_5.bungee.api.event.PostLoginEvent;
import net.md_5.bungee.api.plugin.Listener;
import net.md_5.bungee.api.plugin.Plugin;
import net.md_5.bungee.event.EventHandler;

import java.net.InetSocketAddress;

public final class CreatorsIpsBungee extends Plugin implements Listener {

    private JoinTracker tracker;

    @Override
    public void onEnable() {
        tracker = new JoinTracker(getDataFolder().toPath(), PluginLogger.of(getLogger()::info, getLogger()::warning));
        tracker.reload();

        getProxy().getPluginManager().registerListener(this, this);
        getProxy().getPluginManager().registerCommand(this, new BungeeReloadCommand(tracker));
    }

    @EventHandler
    public void onPostLogin(PostLoginEvent event) {
        ProxiedPlayer player = event.getPlayer();
        InetSocketAddress virtualHost = player.getPendingConnection().getVirtualHost();
        String hostname = virtualHost != null ? virtualHost.getHostString() : null;

        tracker.trackJoin(player.getUniqueId(), player.getName(), hostname, null);
    }
}
