<?php

namespace Framework\config;

trait Dump
{
    public function __construct()
    {
        if (!function_exists('dd')) {
            return;
        }
    }
    public static function dd($data)
    {
        // Generate a unique ID for the debug output
        $uniqueId = uniqid();

    // Prepare the JavaScript and CSS for toggling the debug output
    echo <<<HTML
    <style>
        #debug-output-$uniqueId {
            display: none;
            background-color: #f5f5f5;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #debug-toggle-$uniqueId {
            cursor: pointer;
            color: #007bff;
        }
    </style>
    <script>
        function debug() {
            var debugOutput = document.getElementById('debug-output-$uniqueId');
            debugOutput.style.display = (debugOutput.style.display === 'block') ? 'none' : 'block';
        }
    </script>
    HTML;

    // Output a button to toggle the debug output
    echo "<p><span id='debug-toggle-$uniqueId' onclick='debug()'>Toggle Debug Output</span></p>";

    // Output the debug data
    echo "<pre id='debug-output-$uniqueId' style='display: block;'>";
     print_r($data);
    echo "</pre>";

    // Terminate script execution
    die();
    }
}
