<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Analysis Results — ResumeAnalyzer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --bg:#0a0a0f;--bg2:#12121a;--card:rgba(255,255,255,0.03);
            --border:rgba(255,255,255,0.06);--border-acc:rgba(99,102,241,0.3);
            --text:#f0f0f5;--text2:#8b8b9e;--muted:#5a5a72;
            --accent:#6366f1;--accent2:#a855f7;--green:#34d399;
            --amber:#fbbf24;--red:#f87171;
        }
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;-webkit-font-smoothing:antialiased}
        .bg-grid{position:fixed;inset:0;background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,0.02) 1px,transparent 0);background-size:40px 40px;pointer-events:none;z-index:0}
        .bg-glow{position:fixed;top:-30%;left:50%;transform:translateX(-50%);width:900px;height:900px;background:radial-gradient(circle,rgba(99,102,241,0.08) 0%,rgba(168,85,247,0.04) 40%,transparent 70%);pointer-events:none;z-index:0;animation:gp 8s ease-in-out infinite}
        @keyframes gp{0%,100%{opacity:.6;transform:translateX(-50%) scale(1)}50%{opacity:1;transform:translateX(-50%) scale(1.1)}}

        header{position:relative;z-index:10;border-bottom:1px solid var(--border);background:rgba(10,10,15,0.8);backdrop-filter:blur(20px)}
        .header-inner{max-width:1200px;margin:0 auto;padding:1rem 1.5rem;display:flex;align-items:center;justify-content:space-between}
        .logo{display:flex;align-items:center;gap:.6rem;text-decoration:none}
        .logo-icon{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent2));display:grid;place-items:center;font-weight:800;font-size:.75rem;color:#fff}
        .logo-text{font-size:1.3rem;font-weight:700;letter-spacing:-.03em;color:var(--text)}
        .logo-text span{color:var(--accent)}
        .back-btn{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;font-weight:500;color:var(--text2);text-decoration:none;padding:.5rem 1rem;border-radius:10px;border:1px solid var(--border);transition:all .3s}
        .back-btn:hover{border-color:var(--border-acc);color:var(--accent)}
        .back-btn svg{width:16px;height:16px}

        main{position:relative;z-index:10;max-width:1100px;margin:0 auto;padding:2.5rem 1.5rem 4rem}

        /* Score Header */
        .score-header{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem}
        .score-card{background:var(--card);border:1px solid var(--border);border-radius:20px;padding:2rem;display:flex;align-items:center;gap:1.75rem;position:relative;overflow:hidden}
        .score-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(99,102,241,0.3),transparent)}

        .score-ring{position:relative;width:100px;height:100px;flex-shrink:0}
        .score-ring svg{width:100%;height:100%;transform:rotate(-90deg)}
        .score-ring .track{fill:none;stroke:rgba(255,255,255,0.05);stroke-width:6}
        .score-ring .fill{fill:none;stroke-width:6;stroke-linecap:round;transition:stroke-dashoffset 1.5s cubic-bezier(0.4,0,0.2,1)}
        .score-ring .fill.blue{stroke:url(#blueGrad)}
        .score-ring .fill.green{stroke:url(#greenGrad)}
        .score-value{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center}
        .score-value .num{font-size:1.75rem;font-weight:800;letter-spacing:-.03em;line-height:1}
        .score-value .of{font-size:.6rem;color:var(--muted);margin-top:2px}

        .score-info h3{font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-bottom:.35rem;font-weight:600}
        .score-info .title{font-size:1.15rem;font-weight:700;letter-spacing:-.02em;margin-bottom:.35rem}
        .score-label{font-size:.7rem;font-weight:600;padding:.25rem .65rem;border-radius:100px;display:inline-block}
        .score-label.excellent{background:rgba(52,211,153,0.1);color:var(--green);border:1px solid rgba(52,211,153,0.15)}
        .score-label.good{background:rgba(99,102,241,0.1);color:var(--accent);border:1px solid rgba(99,102,241,0.15)}
        .score-label.fair{background:rgba(251,191,36,0.1);color:var(--amber);border:1px solid rgba(251,191,36,0.15)}
        .score-label.poor{background:rgba(248,113,113,0.1);color:var(--red);border:1px solid rgba(248,113,113,0.15)}

        /* Summary */
        .summary-card{background:var(--card);border:1px solid var(--border);border-radius:20px;padding:2rem;margin-bottom:2rem;position:relative;overflow:hidden}
        .summary-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(99,102,241,0.3),transparent)}
        .section-title{display:flex;align-items:center;gap:.5rem;font-size:.85rem;font-weight:700;letter-spacing:-.01em;margin-bottom:1rem}
        .section-title .icon{width:32px;height:32px;border-radius:10px;display:grid;place-items:center;flex-shrink:0}
        .section-title .icon svg{width:16px;height:16px}
        .section-title .icon.blue{background:rgba(99,102,241,0.1);color:var(--accent)}
        .section-title .icon.green{background:rgba(52,211,153,0.1);color:var(--green)}
        .section-title .icon.red{background:rgba(248,113,113,0.1);color:var(--red)}
        .section-title .icon.amber{background:rgba(251,191,36,0.1);color:var(--amber)}
        .section-title .icon.purple{background:rgba(168,85,247,0.1);color:var(--accent2)}

        .summary-text{font-size:.9rem;line-height:1.8;color:var(--text2)}

        /* Grid */
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem}
        .card{background:var(--card);border:1px solid var(--border);border-radius:20px;padding:1.75rem;position:relative;overflow:hidden;transition:border-color .3s}
        .card:hover{border-color:var(--border-acc)}
        .card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(99,102,241,0.2),transparent)}

        .list{list-style:none;padding:0}
        .list li{display:flex;align-items:flex-start;gap:.6rem;padding:.6rem 0;font-size:.82rem;color:var(--text2);line-height:1.6;border-bottom:1px solid rgba(255,255,255,0.03)}
        .list li:last-child{border-bottom:none}
        .list li .bullet{width:6px;height:6px;border-radius:50%;flex-shrink:0;margin-top:7px}
        .list li .bullet.green{background:var(--green)}
        .list li .bullet.red{background:var(--red)}
        .list li .bullet.amber{background:var(--amber)}
        .list li .bullet.blue{background:var(--accent)}
        .list li .bullet.purple{background:var(--accent2)}

        /* Tags */
        .tags{display:flex;flex-wrap:wrap;gap:.5rem;margin-top:.25rem}
        .tag{font-size:.72rem;font-weight:500;padding:.35rem .75rem;border-radius:100px;border:1px solid}
        .tag.amber{background:rgba(251,191,36,0.06);color:var(--amber);border-color:rgba(251,191,36,0.15)}
        .tag.purple{background:rgba(168,85,247,0.06);color:var(--accent2);border-color:rgba(168,85,247,0.15)}

        /* Rewritten Summary */
        .rewrite-card{background:linear-gradient(135deg,rgba(99,102,241,0.04),rgba(168,85,247,0.04));border:1px solid rgba(99,102,241,0.12);border-radius:20px;padding:2rem;position:relative;overflow:hidden}
        .rewrite-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(99,102,241,0.4),transparent)}
        .rewrite-text{font-size:.9rem;line-height:1.9;color:var(--text2);font-style:italic;padding-left:1rem;border-left:2px solid rgba(99,102,241,0.3)}
        .copy-btn{display:inline-flex;align-items:center;gap:.4rem;margin-top:1rem;font-size:.72rem;font-weight:600;color:var(--accent);background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.15);padding:.4rem .9rem;border-radius:100px;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif}
        .copy-btn:hover{background:rgba(99,102,241,0.15)}
        .copy-btn svg{width:14px;height:14px}

        .footer{text-align:center;padding:2rem 0 1rem;font-size:.7rem;color:var(--muted)}

        /* Animations */
        .fade-up{opacity:0;transform:translateY(20px);animation:fadeUp .6s ease-out forwards}
        @keyframes fadeUp{to{opacity:1;transform:translateY(0)}}
        .delay-1{animation-delay:.1s}.delay-2{animation-delay:.2s}.delay-3{animation-delay:.3s}
        .delay-4{animation-delay:.4s}.delay-5{animation-delay:.5s}.delay-6{animation-delay:.6s}

        @media(max-width:768px){
            .score-header,.grid-2{grid-template-columns:1fr}
            main{padding:1.5rem 1rem 3rem}
            .score-card{padding:1.5rem}
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <!-- SVG Gradients -->
    <svg width="0" height="0" style="position:absolute">
        <defs>
            <linearGradient id="blueGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#6366f1"/><stop offset="100%" stop-color="#a855f7"/>
            </linearGradient>
            <linearGradient id="greenGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#34d399"/><stop offset="100%" stop-color="#6ee7b7"/>
            </linearGradient>
        </defs>
    </svg>

    <header>
        <div class="header-inner">
            <a href="/" class="logo">
                <div class="logo-icon">RA</div>
                <div class="logo-text">Resume<span>Analytica</span></div>
            </a>
            <a href="/" class="back-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                New Analysis
            </a>
        </div>
    </header>

    <main>
        @php
            $overall = $analysis['overall_score'] ?? 0;
            $ats = $analysis['ats_score'] ?? 0;
            $circumference = 2 * 3.14159 * 42;
            $overallOffset = $circumference - ($circumference * $overall / 100);
            $atsOffset = $circumference - ($circumference * $ats / 100);

            $overallLabel = $overall >= 80 ? 'Excellent' : ($overall >= 60 ? 'Good' : ($overall >= 40 ? 'Fair' : 'Needs Work'));
            $overallClass = $overall >= 80 ? 'excellent' : ($overall >= 60 ? 'good' : ($overall >= 40 ? 'fair' : 'poor'));
            $atsLabel = $ats >= 80 ? 'Excellent' : ($ats >= 60 ? 'Good' : ($ats >= 40 ? 'Fair' : 'Needs Work'));
            $atsClass = $ats >= 80 ? 'excellent' : ($ats >= 60 ? 'good' : ($ats >= 40 ? 'fair' : 'poor'));
        @endphp

        <!-- Scores -->
        <div class="score-header fade-up">
            <div class="score-card">
                <div class="score-ring">
                    <svg viewBox="0 0 100 100">
                        <circle class="track" cx="50" cy="50" r="42"/>
                        <circle class="fill blue" cx="50" cy="50" r="42"
                            stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $overallOffset }}"
                        />
                    </svg>
                    <div class="score-value">
                        <span class="num">{{ $overall }}</span>
                        <span class="of">/ 100</span>
                    </div>
                </div>
                <div class="score-info">
                    <h3>Overall Score</h3>
                    <div class="title">Resume Quality</div>
                    <span class="score-label {{ $overallClass }}">{{ $overallLabel }}</span>
                </div>
            </div>
            <div class="score-card">
                <div class="score-ring">
                    <svg viewBox="0 0 100 100">
                        <circle class="track" cx="50" cy="50" r="42"/>
                        <circle class="fill green" cx="50" cy="50" r="42"
                            stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $atsOffset }}"
                        />
                    </svg>
                    <div class="score-value">
                        <span class="num">{{ $ats }}</span>
                        <span class="of">/ 100</span>
                    </div>
                </div>
                <div class="score-info">
                    <h3>ATS Score</h3>
                    <div class="title">ATS Compatibility</div>
                    <span class="score-label {{ $atsClass }}">{{ $atsLabel }}</span>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="summary-card fade-up delay-1">
            <div class="section-title">
                <div class="icon blue"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                Analysis Summary
            </div>
            <p class="summary-text">{{ $analysis['summary'] ?? 'No summary available.' }}</p>
        </div>

        <!-- Strengths & Weaknesses -->
        <div class="grid-2 fade-up delay-2">
            <div class="card">
                <div class="section-title">
                    <div class="icon green"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                    Strengths
                </div>
                <ul class="list">
                    @forelse(($analysis['strengths'] ?? []) as $item)
                        <li><span class="bullet green"></span>{{ $item }}</li>
                    @empty
                        <li><span class="bullet green"></span>No specific strengths identified.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card">
                <div class="section-title">
                    <div class="icon red"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
                    Weaknesses
                </div>
                <ul class="list">
                    @forelse(($analysis['weaknesses'] ?? []) as $item)
                        <li><span class="bullet red"></span>{{ $item }}</li>
                    @empty
                        <li><span class="bullet red"></span>No specific weaknesses identified.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Suggestions & ATS Issues -->
        <div class="grid-2 fade-up delay-3">
            <div class="card">
                <div class="section-title">
                    <div class="icon blue"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg></div>
                    Suggestions
                </div>
                <ul class="list">
                    @forelse(($analysis['suggestions'] ?? []) as $item)
                        <li><span class="bullet blue"></span>{{ $item }}</li>
                    @empty
                        <li><span class="bullet blue"></span>No suggestions at this time.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card">
                <div class="section-title">
                    <div class="icon amber"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                    ATS Issues
                </div>
                <ul class="list">
                    @forelse(($analysis['ats_issues'] ?? []) as $item)
                        <li><span class="bullet amber"></span>{{ $item }}</li>
                    @empty
                        <li><span class="bullet amber"></span>No ATS issues detected.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Missing Keywords & Recommended Roles -->
        <div class="grid-2 fade-up delay-4">
            <div class="card">
                <div class="section-title">
                    <div class="icon amber"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg></div>
                    Missing Keywords
                </div>
                <div class="tags">
                    @forelse(($analysis['missing'] ?? $analysis['missing_keywords'] ?? []) as $kw)
                        <span class="tag amber">{{ $kw }}</span>
                    @empty
                        <span class="tag amber">No missing keywords</span>
                    @endforelse
                </div>
            </div>
            <div class="card">
                <div class="section-title">
                    <div class="icon purple"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    Recommended Roles
                </div>
                <div class="tags">
                    @forelse(($analysis['recommended_roles'] ?? []) as $role)
                        <span class="tag purple">{{ $role }}</span>
                    @empty
                        <span class="tag purple">No roles suggested</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Rewritten Summary -->
        <div class="rewrite-card fade-up delay-5">
            <div class="section-title">
                <div class="icon purple"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></div>
                AI-Rewritten Professional Summary
            </div>
            <p class="rewrite-text" id="rewrittenText">{{ $analysis['rewritten_summary'] ?? 'No rewritten summary available.' }}</p>
            <button class="copy-btn" onclick="copyRewrite()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span id="copyLabel">Copy Summary</span>
            </button>
        </div>

        <div class="footer fade-up delay-6">
            &copy; {{ date('Y') }} ResumeAnalytica — Analysis generated by Gemini AI
        </div>
    </main>

    <script>
    function copyRewrite(){
        const text=document.getElementById('rewrittenText').innerText;
        navigator.clipboard.writeText(text).then(()=>{
            const label=document.getElementById('copyLabel');
            label.textContent='Copied!';
            setTimeout(()=>label.textContent='Copy Summary',2000);
        });
    }
    </script>
</body>
</html>
