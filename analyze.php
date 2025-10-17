<?php
session_start();

// 설정
$uploadDir = 'uploads/';
$maxFileSize = 10 * 1024 * 1024; // 10MB
$allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

// 업로드 디렉토리 생성
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// AJAX 요청 처리
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_FILES['loanDocument'])) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['loanDocument'];

// 파일 검증
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Upload error occurred']);
    exit;
}

if ($file['size'] > $maxFileSize) {
    echo json_encode(['success' => false, 'message' => 'File too large (max 10MB)']);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type']);
    exit;
}

// 파일 저장
$analysisId = uniqid('loan_', true);
$fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
$newFileName = $analysisId . '.' . $fileExtension;
$uploadPath = $uploadDir . $newFileName;

if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    exit;
}

// 파일 분석 (여기에 AI 분석 로직 추가)
$analysisResult = analyzeLoanDocument($uploadPath, $mimeType);

// 결과 저장 (세션 또는 데이터베이스에)
$_SESSION['analysis_' . $analysisId] = [
    'id' => $analysisId,
    'fileName' => $file['name'],
    'uploadTime' => date('Y-m-d H:i:s'),
    'result' => $analysisResult
];

// 24시간 후 파일 삭제 예약 (cron job으로 처리 권장)
// cleanupOldFiles($uploadDir);

echo json_encode([
    'success' => true,
    'analysisId' => $analysisId,
    'message' => 'Analysis complete'
]);

/**
 * 대출 문서 분석 함수
 * 실제로는 OCR + AI API를 사용해야 합니다
 */
function analyzeLoanDocument($filePath, $mimeType) {
    // PDF 텍스트 추출 (pdftotext 또는 PDF parser 라이브러리 필요)
    if ($mimeType === 'application/pdf') {
        $text = extractTextFromPDF($filePath);
    } else {
        // 이미지 OCR (Google Cloud Vision, Tesseract 등 필요)
        $text = extractTextFromImage($filePath);
    }

    // AI 분석 (OpenAI API, Claude API 등)
    $analysis = analyzeWithAI($text);

    return $analysis;
}

/**
 * PDF에서 텍스트 추출
 * 실제로는 smalot/pdfparser 같은 라이브러리 사용 권장
 */
function extractTextFromPDF($filePath) {
    // Composer로 설치: composer require smalot/pdfparser
    /*
    require_once 'vendor/autoload.php';
    $parser = new \Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($filePath);
    $text = $pdf->getText();
    return $text;
    */

    // 임시 샘플 데이터
    return "Sample loan estimate text...";
}

/**
 * 이미지에서 텍스트 추출 (OCR)
 * Google Cloud Vision API 사용 예시
 */
function extractTextFromImage($filePath) {
    // Google Cloud Vision API 또는 Tesseract OCR 사용
    /*
    require 'vendor/autoload.php';
    use Google\Cloud\Vision\V1\ImageAnnotatorClient;

    $imageAnnotator = new ImageAnnotatorClient();
    $image = file_get_contents($filePath);
    $response = $imageAnnotator->textDetection($image);
    $texts = $response->getTextAnnotations();

    if ($texts) {
        return $texts[0]->getDescription();
    }
    */

    return "Sample OCR text...";
}

/**
 * AI를 사용한 대출 문서 분석
 * OpenAI API 또는 Claude API 사용
 */
function analyzeWithAI($text) {
    // OpenAI API 예시
    /*
    $apiKey = 'your-openai-api-key';
    $prompt = "Analyze this loan estimate and provide key insights:\n\n" . $text;

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'gpt-4',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a mortgage expert.'],
            ['role' => 'user', 'content' => $prompt]
        ]
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'];
    */

    // 샘플 분석 결과
    return [
        'loanAmount' => 400000,
        'interestRate' => 6.5,
        'loanTerm' => 30,
        'monthlyPayment' => 2528.27,
        'closingCosts' => 12500,
        'propertyTax' => 6000,
        'homeInsurance' => 1200,
        'pmi' => 250,
        'insights' => [
            'Your interest rate of 6.5% is slightly above the current market average.',
            'Consider shopping around with other lenders to potentially save thousands.',
            'Your closing costs represent about 3.1% of the loan amount, which is reasonable.',
            'With 20% down payment, you could eliminate PMI and save $250/month.'
        ],
        'warnings' => [
            'Review all fees carefully before signing.',
            'Ask about rate lock period and potential changes.',
            'Consider getting a second opinion from another lender.'
        ]
    ];
}

/**
 * 오래된 파일 정리 (24시간 이상)
 */
function cleanupOldFiles($directory) {
    $files = glob($directory . '*');
    $now = time();

    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= 24 * 60 * 60) {
                unlink($file);
            }
        }
    }
}
?>
