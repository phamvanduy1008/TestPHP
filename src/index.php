<?php
echo "hello";

// header('Content-Type: application/json');

// $host = 'localhost';
// $dbname = 'todoapp';
// $username = 'root';
// $password = '';

// $conn = mysqli_connect($host, $username, $password, $dbname);

// if (!$conn) {
//     echo json_encode(["error" => "Connection failed: " . mysqli_connect_error()]);
//     exit;
// }

// $method = $_SERVER['REQUEST_METHOD'];
// $uri = $_SERVER['REQUEST_URI'];

// $query = parse_url($uri, PHP_URL_QUERY);
// parse_str($query, $params);

// if (isset($params['user']) && isset($params['pass']) && $method == 'GET') {
//     $user = mysqli_real_escape_string($conn, $params['user']);
//     $pass = mysqli_real_escape_string($conn, $params['pass']);

//     $query = "INSERT INTO users (username, password, created_at, updated_at) 
//               VALUES ('$user', '$pass', NOW(), NOW())";
//     if (mysqli_query($conn, $query)) {
//         echo json_encode(["message" => "User added successfully"]);
//     } else {
//         echo json_encode(["error" => "Failed to add user: " . mysqli_error($conn)]);
//     }
// } elseif ($method == 'GET' && strpos($uri, '/all') !== false) {
//     $query = "SELECT * FROM users";
//     $result = mysqli_query($conn, $query);

//     if ($result) {
//         $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
//         echo json_encode($users);
//     } else {
//         echo json_encode(["error" => "Failed to fetch users: " . mysqli_error($conn)]);
//     }
// } else {
//     echo json_encode(["error" => "Invalid request"]);
// }

// mysqli_close($conn);
?>
