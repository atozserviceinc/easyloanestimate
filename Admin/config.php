<?php
// 데이터베이스 연결 (필요시 사용)
define('DB_HOST', 'localhost');
define('DB_NAME', 'u628597714_loan_analyzer');
define('DB_USER', 'u628597714_loan_analyzer');
define('DB_PASS', 'Gogo2025!!!');

function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// 테이블 생성 SQL
/*
CREATE TABLE loan_analyses (
    id VARCHAR(50) PRIMARY KEY,
    file_name VARCHAR(255),
    upload_time DATETIME,
    analysis_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/
?>
