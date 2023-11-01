<?php
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$req = $_SERVER['REQUEST_URI'] ?? '/';
if ($method === 'GET' and $req === '/') {
  echo 'Hello World!';
} else {
  echo "Method: {$method}\n";
}
