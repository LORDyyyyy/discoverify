<?php

declare(strict_types=1);

use Framework\HTTP;

/**
 * Debug function
 *
 * @param mixed $value
 * @param bool $end
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
 * Escape HTML
 *
 * @param mixed $value
 * @return string
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
 * @param string $path
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
