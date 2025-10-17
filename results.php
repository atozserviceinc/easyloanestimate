<?php
session_start();

if (!isset($_GET['id'])) {
    header('Location: index.html');
    exit;
}

$analysisId = $_GET['id'];

if (!isset($_SESSION['analysis_' . $analysisId])) {
    die('Analysis not found or expired');
}

$data = $_SESSION['analysis_' . $analysisId];
$result = $data['result'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Analysis Results</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            padding: 30px 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-value {
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .stat-card.primary .stat-value {
            color: #667eea;
        }

        .stat-card.warning .stat-value {
            color: #f59e0b;
        }

        .details-section {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .details-section h2 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: #333;
        }

        .insight-item {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }

        .warning-item {
            background: #fff7ed;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #f59e0b;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .stat-value {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Your Loan Analysis</h1>
            <p>File: <?php echo htmlspecialchars($data['fileName']); ?></p>
            <p style="opacity: 0.8; font-size: 0.9rem;">Analyzed: <?php echo $data['uploadTime']; ?></p>
        </div>

        <div class="results-grid">
            <div class="stat-card primary">
                <div class="stat-label">Loan Amount</div>
                <div class="stat-value">$<?php echo number_format($result['loanAmount']); ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Interest Rate</div>
                <div class="stat-value"><?php echo $result['interestRate']; ?>%</div>
            </div>

            <div class="stat-card primary">
                <div class="stat-label">Monthly Payment</div>
                <div class="stat-value">$<?php echo number_format($result['monthlyPayment'], 2); ?></div>
            </div>

            <div class="stat-card warning">
                <div class="stat-label">Closing Costs</div>
                <div class="stat-value">$<?php echo number_format($result['closingCosts']); ?></div>
            </div>
        </div>

        <div class="details-section">
            <h2>💡 Key Insights</h2>
            <?php foreach ($result['insights'] as $insight): ?>
                <div class="insight-item">
                    ✓ <?php echo htmlspecialchars($insight); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="details-section">
            <h2>⚠️ Important Reminders</h2>
            <?php foreach ($result['warnings'] as $warning): ?>
                <div class="warning-item">
                    ⚡ <?php echo htmlspecialchars($warning); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center;">
            <a href="index.html" class="btn">Analyze Another Loan</a>
        </div>
    </div>
</body>
</html>
