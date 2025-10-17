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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Loan Estimate Analyzer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 1.8rem;
        }

        .logout-btn {
            background: #667eea;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-card h3 {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-value {
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-change {
            font-size: 0.9rem;
            color: #10b981;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        .content-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .content-section h2 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            text-align: left;
            padding: 15px;
            background: #f8f9fa;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #e8ebff;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }

        table tr:hover {
            background: #f8f9ff;
        }

        .status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status.completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status.failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .view-btn {
            background: #667eea;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .stat-value {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Admin Dashboard</h1>
        <a href="admin-login.php?logout" class="logout-btn">Logout</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Analyses</h3>
            <div class="stat-value"><?php echo number_format($stats['total_analyses']); ?></div>
            <div class="stat-change">+<?php echo $stats['total_change']; ?>% from last month</div>
        </div>

        <div class="stat-card">
            <h3>Avg Loan Amount</h3>
            <div class="stat-value">$<?php echo number_format($stats['avg_loan_amount']); ?></div>
            <div class="stat-change">+<?php echo $stats['loan_change']; ?>% from last month</div>
        </div>

        <div class="stat-card">
            <h3>Avg Interest Rate</h3>
            <div class="stat-value"><?php echo $stats['avg_interest_rate']; ?>%</div>
            <div class="stat-change <?php echo $stats['rate_change'] < 0 ? 'negative' : ''; ?>">
                <?php echo $stats['rate_change']; ?>% from last month
            </div>
        </div>

        <div class="stat-card">
            <h3>Active Users</h3>
            <div class="stat-value"><?php echo number_format($stats['active_users']); ?></div>
            <div class="stat-change">+<?php echo $stats['users_change']; ?>% from last month</div>
        </div>
    </div>

    <div class="content-section">
        <h2>Recent Analyses</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Filename</th>
                    <th>Loan Amount</th>
                    <th>Interest Rate</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentAnalyses as $analysis): ?>
                <tr>
                    <td>#<?php echo $analysis['id']; ?></td>
                    <td><?php echo $analysis['date']; ?></td>
                    <td><?php echo htmlspecialchars($analysis['filename']); ?></td>
                    <td>$<?php echo number_format($analysis['loan_amount']); ?></td>
                    <td><?php echo $analysis['interest_rate']; ?>%</td>
                    <td>
                        <span class="status <?php echo $analysis['status']; ?>">
                            <?php echo ucfirst($analysis['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="analysis-detail.php?id=<?php echo $analysis['id']; ?>" class="view-btn">View</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
