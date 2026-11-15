package fr.pentaist.creatorsips.velocity;

import com.velocitypowered.api.command.SimpleCommand;
import fr.pentaist.creatorsips.common.JoinTracker;
import fr.pentaist.creatorsips.common.ReloadMessages;
import net.kyori.adventure.text.Component;

import java.util.List;

final class VelocityReloadCommand implements SimpleCommand {

    private final JoinTracker tracker;

    VelocityReloadCommand(JoinTracker tracker) {
        this.tracker = tracker;
    }

    @Override
    public void execute(Invocation invocation) {
        if (!ReloadMessages.isReload(invocation.arguments())) {
            invocation.source().sendMessage(Component.text(ReloadMessages.USAGE));
            return;
        }

        invocation.source().sendMessage(Component.text(ReloadMessages.result(tracker.reload())));
    }

    @Override
    public boolean hasPermission(Invocation invocation) {
        return invocation.source().hasPermission(ReloadMessages.PERMISSION);
    }

    @Override
    public List<String> suggest(Invocation invocation) {
        return invocation.arguments().length <= 1 ? List.of("reload") : List.of();
    }
}
