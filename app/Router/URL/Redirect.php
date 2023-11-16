<?php

namespace Framework\Router\URL;

use Framework\config\Dump;

class Redirect
{
    use Dump;
    public static function to($url, $statusCode = 302)
    {
        self::validateUrl($url);
        self::validateStatusCode($statusCode);
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
    public static function back()
    {
        // Check if the HTTP_REFERER header exists
        if (isset($_SERVER['HTTP_REFERER'])) {
            $previousUrl = $_SERVER['HTTP_REFERER'];

            // Validate the URL before redirecting
            if (filter_var($previousUrl, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                // Redirect to the previous URL if it's valid
                self::to($previousUrl);
            } else {
                // Handle invalid URL case (redirect to default or display error)
                // Redirect to a default URL
                self::to('/home');
            }
        } else {
            // Handle empty HTTP_REFERER case (redirect to default or display error)
            // Redirect to a default URL
            self::to('/home');
        }
    }

    public static function with($url, $type, $message, $statusCode = 302)
    {
        // Validate the message type
        if (!in_array($type, ['primary', 'success', 'info', 'warning', 'danger', 'light', 'dark'])) {
            throw new \InvalidArgumentException("Invalid message type provided");
        }
        // Map message types to session keys
        $sessionKeyMap = [
            'primary' => 'primary_message',
            'success' => 'success_message',
            'info' => 'info_message',
            'warning' => 'warning_message',
            'light' => 'light_message',
            'dark' => 'dark_message',
            'danger' => 'danger_message',
        ];

        // Get the session key for the message type
        $sessionKey = $sessionKeyMap[$type];

        // Validate the URL
        self::validateUrl($url);

        // Validate the status code
        self::validateStatusCode($statusCode);

        // Set the message in the session
        $_SESSION[$sessionKey] = $message;

        // Redirect to the specified URL with the status code
        self::to($url, $statusCode);

        return $message; // Returning the message set in the session
    }

    public static function error($url, $error, $statusCode = 302)
    {
        self::validateUrl($url);
        self::validateStatusCode($statusCode);

        $_SESSION['error'] = $error;
        self::to($url, $statusCode);
    }
    private static function validateUrl($url)
    {
        if (substr($url, 0, 1) !== '/') {
            throw new \InvalidArgumentException("Invalid relative URL provided");
        }
    }
    private static function validateStatusCode($statusCode)
    {
        if (!is_int($statusCode) || $statusCode < 300 || $statusCode > 399) {
            // Handle invalid status code: throw an exception, log an error, or handle it as appropriate
            throw new \InvalidArgumentException("Invalid status code provided");
        }
    }
}
