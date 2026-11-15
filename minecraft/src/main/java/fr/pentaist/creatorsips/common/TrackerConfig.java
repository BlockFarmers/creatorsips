package fr.pentaist.creatorsips.common;

import java.io.IOException;
import java.io.Reader;
import java.net.URI;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.Properties;

public record TrackerConfig(URI endpoint, String token, boolean debug) {

    private static final String FILE_NAME = "config.properties";
    private static final String API_PATH = "/api/creatorsips/join";
    private static final String DEFAULT_CONTENT = "site-url=\ntoken=\ndebug=false\n";

    public static TrackerConfig load(Path dataFolder) throws IOException, InvalidConfigException {
        Path file = dataFolder.resolve(FILE_NAME);
        createDefaultFileIfMissing(file);

        Properties properties = readProperties(file);
        String siteUrl = properties.getProperty("site-url", "").trim().replaceAll("/+$", "");
        String token = properties.getProperty("token", "").trim();
        boolean debug = Boolean.parseBoolean(properties.getProperty("debug", "false").trim());

        if (siteUrl.isEmpty() || token.isEmpty()) {
            throw new InvalidConfigException("site-url and token must be set in " + file);
        }

        return new TrackerConfig(parseEndpoint(siteUrl), token, debug);
    }

    private static void createDefaultFileIfMissing(Path file) throws IOException {
        if (Files.exists(file)) {
            return;
        }

        Files.createDirectories(file.getParent());
        Files.writeString(file, DEFAULT_CONTENT, StandardCharsets.UTF_8);
    }

    private static Properties readProperties(Path file) throws IOException {
        Properties properties = new Properties();

        try (Reader reader = Files.newBufferedReader(file, StandardCharsets.UTF_8)) {
            properties.load(reader);
        }

        return properties;
    }

    private static URI parseEndpoint(String siteUrl) throws InvalidConfigException {
        try {
            URI endpoint = URI.create(siteUrl + API_PATH);
            String scheme = endpoint.getScheme();

            if (!"http".equalsIgnoreCase(scheme) && !"https".equalsIgnoreCase(scheme)) {
                throw new InvalidConfigException("site-url must start with https:// or http://");
            }

            return endpoint;
        } catch (IllegalArgumentException exception) {
            throw new InvalidConfigException("Invalid site-url: " + siteUrl);
        }
    }
}
