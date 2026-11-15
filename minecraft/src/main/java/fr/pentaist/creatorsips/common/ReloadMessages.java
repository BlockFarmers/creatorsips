package fr.pentaist.creatorsips.common;

public final class ReloadMessages {

    public static final String COMMAND = "creatorsips";
    public static final String PERMISSION = "creatorsips.reload";
    public static final String USAGE = "Usage: /creatorsips reload";

    private static final String SUCCESS = "Creators IPs reloaded.";
    private static final String FAILURE = "Creators IPs reloaded, but tracking is disabled. Check the console.";

    private ReloadMessages() {
    }

    public static boolean isReload(String[] arguments) {
        return arguments.length == 1 && arguments[0].equalsIgnoreCase("reload");
    }

    public static String result(boolean success) {
        return success ? SUCCESS : FAILURE;
    }
}
