<?php

function myConfigPath() {
    return __DIR__ . '/config.ini';
}

/**
 * Grab a value from config/config.ini
 *
 * @param section The section header in the file to look inside for varname
 * @param varname The variable name in the config to attempt to get
 * @return string The matching value from the config, or null if not found
 *
 * Example:
 *  $url = folioConfig('PROD', 'url');
 */
function myConfig($section, $varname) {
    $config = parse_ini_file(myConfigPath(), true);
    return $config[$section][$varname] ?? null;
}

?>
