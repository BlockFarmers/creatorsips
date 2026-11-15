package fr.pentaist.creatorsips.bungee;

import fr.pentaist.creatorsips.common.JoinTracker;
import fr.pentaist.creatorsips.common.ReloadMessages;
import net.md_5.bungee.api.CommandSender;
import net.md_5.bungee.api.chat.TextComponent;
import net.md_5.bungee.api.plugin.Command;

final class BungeeReloadCommand extends Command {

    private final JoinTracker tracker;

    BungeeReloadCommand(JoinTracker tracker) {
        super(ReloadMessages.COMMAND, ReloadMessages.PERMISSION);
        this.tracker = tracker;
    }

    @Override
    public void execute(CommandSender sender, String[] arguments) {
        if (!ReloadMessages.isReload(arguments)) {
            sender.sendMessage(new TextComponent(ReloadMessages.USAGE));
            return;
        }

        sender.sendMessage(new TextComponent(ReloadMessages.result(tracker.reload())));
    }
}
