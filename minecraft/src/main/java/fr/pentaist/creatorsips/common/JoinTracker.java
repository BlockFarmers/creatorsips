package fr.pentaist.creatorsips.common;

import com.google.gson.JsonObject;

import java.io.IOException;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.nio.charset.StandardCharsets;
import java.nio.file.Path;
import java.time.Duration;
import java.util.UUID;

public final class JoinTracker {

    private static final int MAX_LOGGED_BODY_LENGTH = 200;

    private final Path dataFolder;
    private final PluginLogger logger;
    private final HttpClient httpClient = HttpClient.newBuilder()
            .connectTimeout(Duration.ofSeconds(5))
            .build();

    private volatile TrackerConfig config;

    public JoinTracker(Path dataFolder, PluginLogger logger) {
        this.dataFolder = dataFolder;
        this.logger = logger;
    }

    public boolean reload() {
        try {
            config = TrackerConfig.load(dataFolder);
            logger.info("Tracking enabled, joins are sent to " + config.endpoint());
            return true;
        } catch (IOException | InvalidConfigException exception) {
            config = null;
            logger.warn("Tracking disabled: " + exception.getMessage());
            return false;
        }
    }

    public void trackJoin(UUID uuid, String playerName, String hostname, Boolean firstJoin) {
        TrackerConfig currentConfig = config;

        if (currentConfig == null) {
            return;
        }

        String body = toJson(uuid, playerName, hostname, firstJoin);

        httpClient.sendAsync(buildRequest(currentConfig, body), HttpResponse.BodyHandlers.ofString())
                .whenComplete((response, error) -> {
                    if (error != null) {
                        logger.warn("Could not send the join of " + playerName + ": " + error.getMessage());
                    } else if (response.statusCode() >= 300) {
                        logger.warn("The website answered HTTP " + response.statusCode() + " for " + playerName + ": " + shorten(response.body()));
                    } else if (currentConfig.debug()) {
                        logger.info("Join of " + playerName + " via '" + hostname + "' sent: " + response.body());
                    }
                });
    }

    private static HttpRequest buildRequest(TrackerConfig config, String body) {
        return HttpRequest.newBuilder(config.endpoint())
                .timeout(Duration.ofSeconds(10))
                .header("Content-Type", "application/json")
                .header("Accept", "application/json")
                .header("Authorization", "Bearer " + config.token())
                .header("User-Agent", "CreatorsIPs")
                .POST(HttpRequest.BodyPublishers.ofString(body, StandardCharsets.UTF_8))
                .build();
    }

    private static String toJson(UUID uuid, String playerName, String hostname, Boolean firstJoin) {
        JsonObject json = new JsonObject();
        json.addProperty("uuid", uuid.toString());
        json.addProperty("name", playerName);
        json.addProperty("hostname", hostname);
        json.addProperty("first_join", firstJoin);

        return json.toString();
    }

    private static String shorten(String text) {
        if (text == null || text.length() <= MAX_LOGGED_BODY_LENGTH) {
            return text;
        }

        return text.substring(0, MAX_LOGGED_BODY_LENGTH) + "...";
    }
}
