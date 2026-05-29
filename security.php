<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$max_requests = 30;
$time_window = 60;

if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

$current_time = time();

$_SESSION['requests'] = array_filter(
    $_SESSION['requests'],
    function($timestamp) use ($current_time, $time_window) {
        return ($current_time - $timestamp) < $time_window;
    }
);

if (count($_SESSION['requests']) >= $max_requests) {
    http_response_code(429);
    die('Слишком много запросов');
}

$_SESSION['requests'][] = $current_time;

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}