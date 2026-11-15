package fr.pentaist.creatorsips.bukkit;

import fr.pentaist.creatorsips.common.JoinTracker;
import fr.pentaist.creatorsips.common.PluginLogger;
import fr.pentaist.creatorsips.common.ReloadMessages;
import org.bukkit.command.Command;
import org.bukkit.command.CommandSender;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.EventPriority;
import org.bukkit.event.Listener;
import org.bukkit.event.player.PlayerJoinEvent;
import org.bukkit.event.player.PlayerLoginEvent;
import org.bukkit.event.player.PlayerQuitEvent;
import org.bukkit.plugin.java.JavaPlugin;

import java.util.List;
import java.util.Map;
import java.util.UUID;
import java.util.concurrent.ConcurrentHashMap;

public final class CreatorsIpsBukkit extends JavaPlugin implements Listener {

    private final Map<UUID, String> hostnamesByPlayer = new ConcurrentHashMap<>();
    private JoinTracker tracker;

    @Override
    public void onEnable() {
        tracker = new JoinTracker(getDataFolder().toPath(), PluginLogger.of(getLogger()::info, getLogger()::warning));
        tracker.reload();

        getServer().getPluginManager().registerEvents(this, this);
    }

    @Override
    public boolean onCommand(CommandSender sender, Command command, String label, String[] arguments) {
        if (!ReloadMessages.isReload(arguments)) {
            sender.sendMessage(ReloadMessages.USAGE);
            return true;
        }

        sender.sendMessage(ReloadMessages.result(tracker.reload()));
        return true;
    }

    @Override
    public List<String> onTabComplete(CommandSender sender, Command command, String alias, String[] arguments) {
        return arguments.length == 1 ? List.of("reload") : List.of();
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onLogin(PlayerLoginEvent event) {
        if (event.getResult() == PlayerLoginEvent.Result.ALLOWED) {
            hostnamesByPlayer.put(event.getPlayer().getUniqueId(), event.getHostname());
        }
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onJoin(PlayerJoinEvent event) {
        Player player = event.getPlayer();
        String hostname = hostnamesByPlayer.remove(player.getUniqueId());

        tracker.trackJoin(player.getUniqueId(), player.getName(), hostname, !player.hasPlayedBefore());
    }

    @EventHandler
    public void onQuit(PlayerQuitEvent event) {
        hostnamesByPlayer.remove(event.getPlayer().getUniqueId());
    }
}
