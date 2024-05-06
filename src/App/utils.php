<?php

declare(strict_types=1);

use Framework\HTTP;

/**
 * Debug function.
 * Dump the value to the browser and die.
 *
 * @param mixed $value The value to dump
 * @param bool $end Should the browser die after dumping the value or not
 *
 */
function debug(mixed $value, bool $end = true)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    if ($end) {
        die();
    }
}

/**
 * Escape HTML.
 * Escape the value to prevent XSS attacks
 *
 * @param mixed $value The value to escape
 * @return string The escaped value
 *
 */
function esc(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Debug to the browser console
 *
 * @param mixed $data
 *
 */
function debugToConsole($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . (string) $output . "');</script>";
}

/**
 * Redirect to a specific path with status code 302 of a temporary redirect
 *
 * @param string $path The path to redirect to (default is '.' current path)
 * @return void
 * 
 */
function redirectTo(string $path)
{
    if ($path === "." || $path === "./") {
        $path = $_SERVER['HTTP_REFERER'] ?? "/";
    }

    header("Location: {$path}");
    http_response_code(HTTP::REDIRECT_STATUS_CODE);

    exit;
}

/**
 * Generates a UUID (Universally Unique Identifier) using the version 4 variant.
 * 
 * @source https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
 *
 * @return string The generated UUID.
 */
function gen_uuid(): string
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}