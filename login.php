<?php
session_start();
$host = 'localhost';
$db   = 'userDB';
$user = 'root'; // PHPMyAdmin 사용자명
$pass = ''; // PHPMyAdmin 비밀번호
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // 사용자 검증
    if ($user) {
        // 로그인 성공 처리...
        header("Location: recommendation.html");
    } else {
        // 로그인 실패 처리...
        echo "로그인 실패: 사용자명 또는 비밀번호가 잘못되었습니다.";
    }
}
?>
