<?php
session_start();
header('Content-Type: application/json');

// 로그인 확인
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_stats':
        echo json_encode(getStatistics());
        break;

    case 'get_analyses':
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 20);
        echo json_encode(getAnalyses($page, $limit));
        break;

    case 'get_analysis':
        $id = intval($_GET['id'] ?? 0);
        echo json_encode(getAnalysisById($id));
        break;

    case 'delete_analysis':
        $id = intval($_POST['id'] ?? 0);
        echo json_encode(deleteAnalysis($id));
        break;

    case 'get_chart_data':
        echo json_encode(getChartData());
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}

function getStatistics() {
    // 실제 데이터베이스 쿼리
    /*
    $pdo = getDBConnection();
    $stmt = $pdo->query("
        SELECT
            COUNT(*) as total_analyses,
            AVG(loan_amount) as avg_loan_amount,
            AVG(interest_rate) as avg_interest_rate
        FROM loan_analyses
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    return $stmt->fetch(PDO::FETCH_ASSOC);
    */

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

function getAnalyses($page, $limit) {
    $offset = ($page - 1) * $limit;

    // 실제 데이터베이스 쿼리
    /*
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        SELECT * FROM loan_analyses
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    */

    return getRecentAnalyses($limit);
}

function getAnalysisById($id) {
    // 실제 데이터베이스 쿼리
    /*
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM loan_analyses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    */

    return [
        'id' => $id,
        'filename' => 'sample.pdf',
        'loan_amount' => 400000,
        'interest_rate' => 6.5,
        'status' => 'completed'
    ];
}

function deleteAnalysis($id) {
    // 실제 데이터베이스 쿼리 및 파일 삭제
    /*
    $pdo = getDBConnection();

    // 파일 경로 가져오기
    $stmt = $pdo->prepare("SELECT file_path FROM loan_analyses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $analysis = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($analysis && file_exists($analysis['file_path'])) {
        unlink($analysis['file_path']);
    }

    // DB에서 삭제
    $stmt = $pdo->prepare("DELETE FROM loan_analyses WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return ['success' => true, 'message' => 'Analysis deleted'];
    */

    return ['success' => true, 'message' => 'Analysis deleted'];
}

function getChartData() {
    // 실제 데이터베이스 쿼리로 차트 데이터 생성
    return [
        'analyses_monthly' => [65, 78, 90, 105, 98, 115, 130, 142, 155, 168, 180, 195],
        'loan_distribution' => [285, 456, 378, 128],
        'interest_rates' => [45, 125, 385, 456, 198, 38]
    ];
}

function getRecentAnalyses($limit) {
    // 샘플 데이터
    return [
        [
            'id' => 1247,
            'date' => '2025-01-17 14:32',
            'filename' => 'loan_estimate_smith.pdf',
            'loan_amount' => 485000,
            'interest_rate' => 6.75,
            'status' => 'completed'
        ]
    ];
}
?>
