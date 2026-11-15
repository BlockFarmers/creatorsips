package fr.pentaist.creatorsips.velocity;

import com.google.inject.Inject;
import com.velocitypowered.api.command.CommandManager;
import com.velocitypowered.api.event.Subscribe;
import com.velocitypowered.api.event.connection.PostLoginEvent;
import com.velocitypowered.api.event.proxy.ProxyInitializeEvent;
import com.velocitypowered.api.plugin.annotation.DataDirectory;
import com.velocitypowered.api.proxy.Player;
import com.velocitypowered.api.proxy.ProxyServer;
import fr.pentaist.creatorsips.common.JoinTracker;
import fr.pentaist.creatorsips.common.PluginLogger;
import fr.pentaist.creatorsips.common.ReloadMessages;
import org.slf4j.Logger;

import java.net.InetSocketAddress;
import java.nio.file.Path;

public final class CreatorsIpsVelocity {

    private final ProxyServer proxy;
    private final JoinTracker tracker;

    @Inject
    public CreatorsIpsVelocity(ProxyServer proxy, Logger logger, @DataDirectory Path dataDirectory) {
        this.proxy = proxy;
        this.tracker = new JoinTracker(dataDirectory, PluginLogger.of(logger::info, logger::warn));
    }

    @Subscribe
    public void onProxyInitialize(ProxyInitializeEvent event) {
        tracker.reload();

        CommandManager commandManager = proxy.getCommandManager();
        commandManager.register(commandManager.metaBuilder(ReloadMessages.COMMAND).build(), new VelocityReloadCommand(tracker));
    }

    @Subscribe
    public void onPostLogin(PostLoginEvent event) {
        Player player = event.getPlayer();
        String hostname = player.getVirtualHost()
                .map(InetSocketAddress::getHostString)
                .orElse(null);

        tracker.trackJoin(player.getUniqueId(), player.getUsername(), hostname, null);
    }
}
