<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porosh — AI-Powered Resume Analysis</title>
    <meta name="description" content="Get instant AI-powered feedback on your resume. Upload your tech resume for deep quality analysis, ATS scoring, and job market fit assessment.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-card: rgba(255, 255, 255, 0.03);
            --bg-card-hover: rgba(255, 255, 255, 0.06);
            --border-subtle: rgba(255, 255, 255, 0.06);
            --border-accent: rgba(99, 102, 241, 0.3);
            --text-primary: #f0f0f5;
            --text-secondary: #8b8b9e;
            --text-muted: #5a5a72;
            --accent-start: #6366f1;
            --accent-end: #a855f7;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --success: #34d399;
            --error-bg: rgba(239, 68, 68, 0.08);
            --error-border: rgba(239, 68, 68, 0.3);
            --error-text: #fca5a5;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ===== Animated Background ===== */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(255,255,255,0.02) 1px, transparent 0);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }
        .bg-glow {
            position: fixed;
            top: -30%;
            left: 50%;
            transform: translateX(-50%);
            width: 900px;
            height: 900px;
            background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, rgba(168,85,247,0.04) 40%, transparent 70%);
            pointer-events: none;
            z-index: 0;
            animation: glowPulse 8s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.6; transform: translateX(-50%) scale(1); }
            50% { opacity: 1; transform: translateX(-50%) scale(1.1); }
        }

        /* ===== Header ===== */
        header {
            position: relative;
            z-index: 10;
            border-bottom: 1px solid var(--border-subtle);
            background: rgba(10, 10, 15, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }
        .logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-start), var(--accent-end));
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 0.75rem;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .logo-text {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text-primary);
        }
        .logo-text span { color: var(--accent-start); }
        .header-badge {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--accent-start);
            background: var(--accent-glow);
            padding: 0.3rem 0.75rem;
            border-radius: 100px;
            border: 1px solid rgba(99, 102, 241, 0.15);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* ===== Main Content ===== */
        main {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }
        .container { max-width: 580px; width: 100%; }

        /* ===== Hero Section ===== */
        .hero { text-align: center; margin-bottom: 2.5rem; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--accent-start);
            background: var(--accent-glow);
            padding: 0.4rem 1rem;
            border-radius: 100px;
            border: 1px solid rgba(99, 102, 241, 0.12);
            margin-bottom: 1.5rem;
            letter-spacing: 0.02em;
        }
        .hero-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--success);
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        .hero h1 {
            font-size: 2.75rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.15;
            margin-bottom: 1rem;
        }
        .hero h1 .gradient-text {
            background: linear-gradient(135deg, var(--accent-start) 0%, var(--accent-end) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            font-size: 1.05rem;
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 460px;
            margin: 0 auto;
        }

        /* ===== Card ===== */
        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            padding: 2.25rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99,102,241,0.3), transparent);
        }

        /* ===== Error Alert ===== */
        .error-alert {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error-alert svg {
            width: 20px;
            height: 20px;
            color: #ef4444;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .error-alert-content h3 {
            font-size: 0.8rem;
            font-weight: 600;
            color: #fca5a5;
            margin-bottom: 0.35rem;
        }
        .error-alert-content ul {
            list-style: none;
            padding: 0;
        }
        .error-alert-content li {
            font-size: 0.8rem;
            color: #fca5a5;
            opacity: 0.85;
            padding-left: 0.8rem;
            position: relative;
        }
        .error-alert-content li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #ef4444;
        }

        /* ===== Form Fields ===== */
        .form-group { margin-bottom: 1.75rem; }
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.65rem;
            letter-spacing: 0.01em;
        }
        .form-label .optional {
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ===== Dropzone ===== */
        .dropzone {
            border: 1.5px dashed rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .dropzone::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(99,102,241,0.03), rgba(168,85,247,0.03));
            opacity: 0;
            transition: opacity 0.35s;
        }
        .dropzone:hover, .dropzone.drag-over {
            border-color: rgba(99, 102, 241, 0.4);
            background: rgba(99, 102, 241, 0.04);
        }
        .dropzone:hover::before, .dropzone.drag-over::before { opacity: 1; }
        .dropzone.file-selected {
            border-color: rgba(52, 211, 153, 0.3);
            border-style: solid;
            background: rgba(52, 211, 153, 0.04);
        }

        .dropzone-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(99, 102, 241, 0.08);
            border: 1px solid rgba(99, 102, 241, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            transition: transform 0.35s, background 0.35s;
        }
        .dropzone:hover .dropzone-icon {
            transform: scale(1.08);
            background: rgba(99, 102, 241, 0.12);
        }
        .dropzone-icon svg {
            width: 24px;
            height: 24px;
            color: var(--accent-start);
        }
        .dropzone-icon.success-icon {
            background: rgba(52, 211, 153, 0.08);
            border-color: rgba(52, 211, 153, 0.15);
        }
        .dropzone-icon.success-icon svg { color: var(--success); }

        .dropzone-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            position: relative;
            z-index: 1;
        }
        .dropzone-text strong {
            color: var(--accent-start);
            font-weight: 600;
        }
        .dropzone-hint {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
            position: relative;
            z-index: 1;
        }
        .file-name-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--success);
            background: rgba(52, 211, 153, 0.06);
            border: 1px solid rgba(52, 211, 153, 0.12);
            padding: 0.4rem 1rem;
            border-radius: 100px;
            margin-top: 0.5rem;
            position: relative;
            z-index: 1;
        }

        /* ===== Textarea ===== */
        .textarea {
            width: 100%;
            background: rgba(255,255,255,0.02);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 1rem 1.15rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            color: var(--text-primary);
            resize: vertical;
            min-height: 120px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
            line-height: 1.6;
        }
        .textarea::placeholder { color: var(--text-muted); }
        .textarea:focus {
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.06);
        }

        /* ===== Submit Button ===== */
        .submit-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 16px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--accent-start), var(--accent-end));
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.01em;
        }
        .submit-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.35s;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.3), 0 2px 8px rgba(99, 102, 241, 0.2);
        }
        .submit-btn:hover::before { opacity: 1; }
        .submit-btn:active { transform: translateY(0); }
        .submit-btn svg { width: 18px; height: 18px; }

        .submit-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== Features ===== */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        .feature {
            text-align: center;
            padding: 1.25rem 0.75rem;
            border-radius: 16px;
            border: 1px solid var(--border-subtle);
            background: var(--bg-card);
            transition: border-color 0.3s;
        }
        .feature:hover { border-color: var(--border-accent); }
        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            margin: 0 auto 0.65rem;
            display: grid;
            place-items: center;
        }
        .feature-icon svg { width: 20px; height: 20px; }
        .feature-icon.blue { background: rgba(99,102,241,0.08); color: var(--accent-start); }
        .feature-icon.purple { background: rgba(168,85,247,0.08); color: var(--accent-end); }
        .feature-icon.green { background: rgba(52,211,153,0.08); color: var(--success); }
        .feature h3 { font-size: 0.75rem; font-weight: 600; margin-bottom: 0.2rem; }
        .feature p { font-size: 0.65rem; color: var(--text-muted); line-height: 1.5; }

        /* ===== Footer ===== */
        .footer {
            text-align: center;
            padding: 2rem 0 1rem;
            font-size: 0.7rem;
            color: var(--text-muted);
        }
        .footer a {
            color: var(--text-secondary);
            text-decoration: none;
        }

        /* ===== Responsive ===== */
        @media (max-width: 640px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 0.95rem; }
            .form-card { padding: 1.5rem; }
            .features { grid-template-columns: 1fr; gap: 0.75rem; }
            main { padding: 2rem 1rem; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <header>
        <div class="header-inner">
            <a href="/" class="logo">
                <div class="logo-icon">RHP</div>
                <div class="logo-text">Resume<span>Analyzer</span></div>
            </a>
            <div class="header-badge">✦ AI-Powered</div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="hero">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Gemini AI Engine Active
                </div>
                <h1>
                    Analyze Your Resume<br>
                    <span class="gradient-text">with AI Precision</span>
                </h1>
                <p>Upload your resume for deep AI analysis — get ATS scoring, keyword gaps, actionable improvements, and a rewritten summary in seconds.</p>
            </div>

            <div class="form-card">
                @if ($errors->any())
                    <div class="error-alert">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="error-alert-content">
                            <h3>Please fix the following:</h3>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form id="analyzeForm" action="{{ route('analyze.resume') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">
                            Upload Resume <span class="optional">(PDF, max 5MB)</span>
                        </label>
                        <div id="dropzone" class="dropzone" onclick="document.getElementById('resume-upload').click()">
                            <input id="resume-upload" name="resume" type="file" accept=".pdf" style="display:none" required onchange="handleFileSelect(this)">

                            <div id="state-initial">
                                <div class="dropzone-icon">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div class="dropzone-text">
                                    <strong>Click to upload</strong> or drag & drop
                                </div>
                                <div class="dropzone-hint">PDF files only • Max 5MB</div>
                            </div>

                            <div id="state-selected" style="display:none">
                                <div class="dropzone-icon success-icon">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="dropzone-text">File ready for analysis</div>
                                <div class="file-name-badge" id="file-name-text">resume.pdf</div>
                                <div class="dropzone-hint">Click to change file</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="job_description" class="form-label">
                            Target Job Description <span class="optional">(Optional — improves accuracy)</span>
                        </label>
                        <textarea id="job_description" name="job_description" class="textarea" rows="4" placeholder="Paste the job requirements here to get tailored feedback, keyword gap analysis, and role-fit scoring...">{{ old('job_description') }}</textarea>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span id="btnText">Generate AI Analysis</span>
                    </button>
                </form>
            </div>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon blue">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h3>ATS Scoring</h3>
                    <p>Compatibility analysis</p>
                </div>
                <div class="feature">
                    <div class="feature-icon purple">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <h3>Keyword Analysis</h3>
                    <p>Missing skills detection</p>
                </div>
                <div class="feature">
                    <div class="feature-icon green">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <h3>AI Rewrite</h3>
                    <p>Optimized summary</p>
                </div>
            </div>

            <footer class="footer">
                &copy; {{ date('Y') }} ResumeAnalytica — Your data is processed securely and never stored.
            </footer>
        </div>
    </main>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('resume-upload');

        // Drag & Drop
        ['dragenter', 'dragover'].forEach(evt => {
            dropzone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('drag-over');
            });
        });
        ['dragleave', 'drop'].forEach(evt => {
            dropzone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('drag-over');
            });
        });
        dropzone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(fileInput);
            }
        });

        function handleFileSelect(input) {
            const initial = document.getElementById('state-initial');
            const selected = document.getElementById('state-selected');
            const nameText = document.getElementById('file-name-text');

            if (input.files && input.files[0]) {
                nameText.textContent = input.files[0].name;
                initial.style.display = 'none';
                selected.style.display = 'block';
                dropzone.classList.add('file-selected');
            } else {
                initial.style.display = 'block';
                selected.style.display = 'none';
                dropzone.classList.remove('file-selected');
            }
        }

        // Loading state on submit
        document.getElementById('analyzeForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            btn.classList.add('loading');
            btn.innerHTML = '<div class="spinner"></div><span>Analyzing with AI...</span>';
        });
    </script>
</body>
</html>
