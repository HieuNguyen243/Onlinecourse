<?php
session_start();

require_once './config/Database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
} catch (Exception $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

$controllerInput = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$actionInput     = isset($_GET['action']) ? $_GET['action'] : 'index';


$controllerName = ucfirst($controllerInput) . 'Controller'; 
$controllerPath = "./controllers/$controllerName.php";


if (file_exists($controllerPath)) {
    require_once $controllerPath;

    if (class_exists($controllerName)) {
        $myController = new $controllerName($db);
        if (method_exists($myController, $actionInput)) {
            $myController->$actionInput();
        } else {
            handle404("Action '$actionInput' không tồn tại trong $controllerName");
        }
    } else {
        handle404("Class '$controllerName' không tìm thấy");
    }
} else {
    handle404("File Controller '$controllerName' không tìm thấy");
}

function handle404($message) {
    header("HTTP/1.0 404 Not Found"); 
    echo "<div style='text-align:center; margin-top:50px;'>";
    echo "<h1>404 - Not Found</h1>";
    echo "<p>Rất tiếc, trang bạn tìm kiếm không tồn tại.</p>";
    echo "<p style='color:gray; font-size: 0.8em;'>Debug: $message</p>";
    echo "<a href='index.php'>Quay về trang chủ</a>";
    echo "</div>";
}
?>