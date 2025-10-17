<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Estimate Analyzer - Understand Your Mortgage</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
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
            margin-bottom: 50px;
            padding: 40px 20px;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.3rem;
            opacity: 0.95;
            margin-bottom: 10px;
        }

        .header .subtitle {
            font-size: 1.1rem;
            opacity: 0.85;
        }

        .upload-section {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            margin-bottom: 40px;
        }

        .upload-area {
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 60px 40px;
            text-align: center;
            background: #f8f9ff;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .upload-area:hover {
            border-color: #764ba2;
            background: #f0f2ff;
            transform: translateY(-2px);
        }

        .upload-area.dragover {
            border-color: #764ba2;
            background: #e8ebff;
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #667eea;
        }

        .upload-area h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 10px;
        }

        .upload-area p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .file-input {
            display: none;
        }

        .upload-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .file-info {
            margin-top: 20px;
            padding: 15px;
            background: #e8f5e9;
            border-radius: 10px;
            display: none;
        }

        .file-info.show {
            display: block;
        }

        .analyze-btn {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            padding: 18px 50px;
            font-size: 1.2rem;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 30px;
            width: 100%;
            transition: all 0.3s ease;
            display: none;
        }

        .analyze-btn.show {
            display: block;
        }

        .analyze-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(17, 153, 142, 0.4);
        }

        .analyze-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .features-section {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            margin-bottom: 40px;
        }

        .features-section h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        .features-section .subtitle {
            text-align: center;
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 50px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            padding: 30px;
            border-radius: 15px;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border: 2px solid #e8ebff;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
            font-size: 1rem;
        }

        .faq-section {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            margin-bottom: 40px;
        }

        .faq-section h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 50px;
        }

        .faq-item {
            margin-bottom: 25px;
            border-bottom: 1px solid #e8ebff;
            padding-bottom: 25px;
        }

        .faq-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .faq-question {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: color 0.3s ease;
        }

        .faq-question:hover {
            color: #667eea;
        }

        .faq-question::after {
            content: '▼';
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .faq-question.active::after {
            transform: rotate(180deg);
        }

        .faq-answer {
            color: #666;
            line-height: 1.8;
            font-size: 1.05rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-answer.show {
            max-height: 500px;
            margin-top: 12px;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 30px;
        }

        .loading.show {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .supported-formats {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 0.9rem;
        }

        footer {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px 40px 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            margin-top: 40px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            color: #333;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer-section p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #667eea;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e8ebff;
            color: #888;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .header p {
                font-size: 1.1rem;
            }

            .upload-section, .features-section, .faq-section {
                padding: 40px 20px;
            }

            .features-section h2, .faq-section h2 {
                font-size: 2rem;
            }

            footer {
                padding: 40px 20px 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 Loan Estimate Analyzer</h1>
            <p>Understand Your Mortgage in Minutes</p>
            <p class="subtitle">Get a clear, simple breakdown of your loan estimate with AI-powered analysis</p>
        </div>

        <div class="upload-section">
            <form id="uploadForm" enctype="multipart/form-data" method="POST" action="analyze">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">📄</div>
                    <h2>Upload Your Loan Estimate</h2>
                    <p>Drag and drop your file here, or click to browse</p>
                    <button type="button" class="upload-btn" onclick="document.getElementById('fileInput').click()">
                        Choose File
                    </button>
                    <input type="file" id="fileInput" name="loanDocument" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    <div class="supported-formats">
                        Supported formats: PDF, JPG, PNG (Max 10MB)
                    </div>
                </div>

                <div class="file-info" id="fileInfo">
                    <strong>Selected file:</strong> <span id="fileName"></span>
                    <br>
                    <strong>Size:</strong> <span id="fileSize"></span>
                </div>

                <button type="submit" class="analyze-btn" id="analyzeBtn">
                    🔍 Analyze My Loan Estimate
                </button>

                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Analyzing your loan estimate... This may take a moment.</p>
                </div>
            </form>
        </div>

        <div class="features-section">
            <h2>Why Choose Our Analysis?</h2>
            <p class="subtitle">Navigate complex mortgage documents with confidence using our expert AI analysis</p>

            <div class="features-grid">
                <div class="feature-card">
                    <span class="feature-icon">🤖</span>
                    <h3>AI-Powered Insights</h3>
                    <p>Our advanced AI analyzes every detail of your loan estimate, identifying potential issues and opportunities you might miss.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">⚡</span>
                    <h3>Instant Results</h3>
                    <p>Get comprehensive analysis in minutes, not hours. No waiting, no appointments needed - just upload and understand.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">💰</span>
                    <h3>Save Money</h3>
                    <p>Identify hidden fees, compare rates, and understand exactly where your money is going. Make informed decisions that save thousands.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">📊</span>
                    <h3>Clear Breakdown</h3>
                    <p>Complex mortgage jargon translated into plain English. See exactly what you're paying for with easy-to-understand visualizations.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">🔒</span>
                    <h3>Secure & Private</h3>
                    <p>Your documents are encrypted and processed securely. We never share your information and delete files after analysis.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">✅</span>
                    <h3>Expert Guidance</h3>
                    <p>Receive personalized recommendations based on your specific situation. Know what questions to ask your lender.</p>
                </div>
            </div>
        </div>

        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>

            <div class="faq-item">
                <div class="faq-question">What is a Loan Estimate?</div>
                <div class="faq-answer">
                    A Loan Estimate is a three-page standardized form that provides important information about a mortgage loan you've requested. Lenders must provide this document within three business days of receiving your application. It includes details about the loan amount, interest rate, monthly payment, closing costs, and other key terms.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">How does the AI analysis work?</div>
                <div class="faq-answer">
                    Our AI-powered system uses advanced optical character recognition (OCR) and natural language processing to extract and analyze data from your Loan Estimate. It compares your terms against current market rates, identifies unusual fees, calculates long-term costs, and provides personalized insights based on industry best practices.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Is my information secure?</div>
                <div class="faq-answer">
                    Yes, absolutely. Your documents are encrypted during upload and transmission using bank-level security. We process your information on secure servers, never share your data with third parties, and automatically delete uploaded files within 24 hours. We take your privacy very seriously.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">How much does this service cost?</div>
                <div class="faq-answer">
                    Our basic Loan Estimate analysis is completely free. We believe everyone should have access to clear, unbiased information about their mortgage. We may offer premium features in the future, but the core analysis will always remain free.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What file formats are supported?</div>
                <div class="faq-answer">
                    We accept PDF files and image formats (JPG, PNG). The maximum file size is 10MB. For best results, ensure your document is clear and readable. If you have a paper Loan Estimate, simply take a clear photo with your smartphone.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Can I compare multiple loan estimates?</div>
                <div class="faq-answer">
                    Yes! We encourage you to analyze multiple Loan Estimates from different lenders. Upload each one separately and we'll provide detailed analysis for each. This helps you make an informed decision and potentially save thousands of dollars over the life of your loan.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">How accurate is the analysis?</div>
                <div class="faq-answer">
                    Our AI system is trained on thousands of loan documents and is regularly updated with current market data. While we strive for maximum accuracy, this tool is designed to provide educational insights and should not replace professional financial advice. Always consult with a qualified mortgage professional for final decisions.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What should I do after receiving my analysis?</div>
                <div class="faq-answer">
                    Use the insights to ask informed questions to your lender, negotiate better terms, or shop around with other lenders. Our analysis highlights key areas to focus on, potential red flags, and opportunities for savings. We recommend sharing our findings with a trusted mortgage advisor or financial planner.
                </div>
            </div>
        </div>

        <footer>
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Have questions or need assistance?</p>
                    <p>📧 <a href="mailto:info@easyloanestimate.com">info@easyloanestimate.com</a></p>
                </div>

                <div class="footer-section">
                    <h3>Legal</h3>
                    <a href="privacy-policy">Privacy Policy</a>
                    <a href="terms-of-service">Terms of Service</a>
                    <a href="disclaimer">Disclaimer</a>
                </div>

                <div class="footer-section">
                    <h3>About</h3>
                    <p>We help homebuyers understand their mortgage options through AI-powered analysis and clear explanations.</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Easy Loan Estimate. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const analyzeBtn = document.getElementById('analyzeBtn');
        const uploadForm = document.getElementById('uploadForm');
        const loading = document.getElementById('loading');

        // FAQ toggle
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                const isActive = this.classList.contains('active');

                document.querySelectorAll('.faq-question').forEach(q => {
                    q.classList.remove('active');
                    q.nextElementSibling.classList.remove('show');
                });

                if (!isActive) {
                    this.classList.add('active');
                    answer.classList.add('show');
                }
            });
        });

        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.remove('dragover');
            });
        });

        uploadArea.addEventListener('drop', handleDrop);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                const maxSize = 10 * 1024 * 1024;

                if (file.size > maxSize) {
                    alert('File size must be less than 10MB');
                    return;
                }

                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please upload a PDF, JPG, or PNG file');
                    return;
                }

                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileInfo.classList.add('show');
                analyzeBtn.classList.add('show');
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!fileInput.files[0]) {
                alert('Please select a file first');
                return;
            }

            analyzeBtn.disabled = true;
            analyzeBtn.textContent = 'Analyzing...';
            loading.classList.add('show');

            const formData = new FormData(this);

            fetch('analyze.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'results.php?id=' + data.analysisId;
                } else {
                    alert('Error: ' + data.message);
                    analyzeBtn.disabled = false;
                    analyzeBtn.textContent = '🔍 Analyze My Loan Estimate';
                    loading.classList.remove('show');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                analyzeBtn.disabled = false;
                analyzeBtn.textContent = '🔍 Analyze My Loan Estimate';
                loading.classList.remove('show');
            });
        });
    </script>
</body>
</html>
