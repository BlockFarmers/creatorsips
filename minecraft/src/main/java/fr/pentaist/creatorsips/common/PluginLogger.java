package fr.pentaist.creatorsips.common;

import java.util.function.Consumer;

public interface PluginLogger {

    void info(String message);

    void warn(String message);

    static PluginLogger of(Consumer<String> info, Consumer<String> warn) {
        return new PluginLogger() {
            @Override
            public void info(String message) {
                info.accept(message);
            }

            @Override
            public void warn(String message) {
                warn.accept(message);
            }
        };
    }
}
