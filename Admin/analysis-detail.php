<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$analysisId = $_GET['id'] ?? null;
if (!$analysisId) {
    header('Location: admin-dashboard.php');
    exit;
}

// 분석 데이터 가져오기
$analysis = getAnalysisDetail($analysisId);

function getAnalysisDetail($id) {
    // 실제로는 데이터베이스에서 가져와야 합니다
    return [
        'id' => $id,
        'upload_date' => '2025-01-17 14:32:15',
        'filename' => 'loan_estimate_smith.pdf',
        'file_size' => '2.4 MB',
        'status' => 'completed',
        'loan_amount' => 485000,
        'interest_rate' => 6.75,
        'loan_term' => 30,
        'monthly_payment' => 3145.89,
        'property_value' => 600000,
        'down_payment' => 115000,
        'closing_costs' => 14500,
        'property_tax' => 7200,
        'home_insurance' => 1440,
        'pmi' => 285,
        'lender' => 'Wells Fargo',
        'insights' => [
            'Interest rate is 0.25% above current market average',
            'Closing costs are within normal range at 2.99% of loan amount',
            'PMI will be required until 20% equity is reached',
            'Consider shopping with 2-3 more lenders for comparison'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analysis Detail #<?php echo $analysisId; ?> - Admin</title>
    <style>
        /* 이전 대시보드 스타일 재사용 + 추가 스타일 */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            padding: 30px;
        }
        .detail-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .detail-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .detail-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .detail-card h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #888;
            font-weight: 600;
        }
        .detail-value {
            color: #333;
            font-weight: 600;
        }
        .back-btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="detail-container">
        <div class="detail-header">
            <a href="admin-dashboard.php" class="back-btn">← Back to Dashboard</a>
            <h1 style="margin-top: 20px; color: #333;">Analysis Detail #<?php echo $analysisId; ?></h1>
            <p style="color: #888;">Uploaded: <?php echo $analysis['upload_date']; ?></p>
        </div>

        <div class="detail-grid">
            <div class="detail-card">
                <h3>File Information</h3>
                <div class="detail-row">
                    <span class="detail-label">File Name</span>
                    <span class="detail-value"><?php echo htmlspecialchars($analysis['filename']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">File Size</span>
                    <span class="detail-value"><?php echo $analysis['file_size']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value"><?php echo ucfirst($analysis['status']); ?></span>
                </div>
            </div>

            <div class="detail-card">
                <h3>Loan Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Loan Amount</span>
                    <span class="detail-value">$<?php echo number_format($analysis['loan_amount']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Interest Rate</span>
                    <span class="detail-value"><?php echo $analysis['interest_rate']; ?>%</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Loan Term</span>
                    <span class="detail-value"><?php echo $analysis['loan_term']; ?> years</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Monthly Payment</span>
                    <span class="detail-value">$<?php echo number_format($analysis['monthly_payment'], 2); ?></span>
                </div>
            </div>

            <div class="detail-card">
                <h3>Property & Costs</h3>
                <div class="detail-row">
                    <span class="detail-label">Property Value</span>
                    <span class="detail-value">$<?php echo number_format($analysis['property_value']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Down Payment</span>
                    <span class="detail-value">$<?php echo number_format($analysis['down_payment']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Closing Costs</span>
                    <span class="detail-value">$<?php echo number_format($analysis['closing_costs']); ?></span>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <h3>AI Insights</h3>
            <?php foreach ($analysis['insights'] as $insight): ?>
                <div style="background: #f8f9fa; padding: 15px; margin-bottom: 10px; border-radius: 8px;">
                    💡 <?php echo htmlspecialchars($insight); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
