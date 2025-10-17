<?php
session_start();

// 로그인 확인

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}




// 데이터베이스 연결 (필요시)
//require_once 'config.php';
//$pdo = getDBConnection();

// 통계 데이터 가져오기
$stats = getStatistics();
$recentAnalyses = getRecentAnalyses(10);
$chartData = getChartData();

function getStatistics() {
    // 실제로는 데이터베이스에서 가져와야 합니다
    return [
        'total_analyses' => 1247,
        'total_change' => 12,
        'avg_loan_amount' => 425000,
        'loan_change' => 5,
        'avg_interest_rate' => 6.8,
        'rate_change' => -0.3,
        'active_users' => 892,
        'users_change' => 8
    ];
}

function getRecentAnalyses($limit = 10) {
    // 실제로는 데이터베이스에서 가져와야 합니다
    return [
        [
            'id' => 1247,
            'date' => '2025-01-17 14:32',
            'filename' => 'loan_estimate_smith.pdf',
            'loan_amount' => 485000,
            'interest_rate' => 6.75,
            'status' => 'completed'
        ],
        [
            'id' => 1246,
            'date' => '2025-01-17 13:15',
            'filename' => 'mortgage_estimate_jones.pdf',
            'loan_amount' => 325000,
            'interest_rate' => 6.5,
            'status' => 'completed'
        ],
        [
            'id' => 1245,
            'date' => '2025-01-17 12:48',
            'filename' => 'loan_doc_wilson.pdf',
            'loan_amount' => 550000,
            'interest_rate' => 7.0,
            'status' => 'pending'
        ],
        [
            'id' => 1244,
            'date' => '2025-01-17 11:22',
            'filename' => 'estimate_brown.pdf',
            'loan_amount' => 395000,
            'interest_rate' => 6.85,
            'status' => 'completed'
        ],
        [
            'id' => 1243,
            'date' => '2025-01-17 10:05',
            'filename' => 'loan_estimate_davis.pdf',
            'loan_amount' => 275000,
            'interest_rate' => 6.25,
            'status' => 'failed'
        ]
    ];
}

function getChartData() {
    return [
        'analyses_monthly' => [65, 78, 90, 105, 98, 115, 130, 142, 155, 168, 180, 195],
        'loan_distribution' => [285, 456, 378, 128],
        'interest_rates' => [45, 125, 385, 456, 198, 38]
    ];
}

// HTML은 artifact에서 가져온 것 사용
include 'admin-dashboard-template.html';
?>
