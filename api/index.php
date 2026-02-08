<?php
// ==========================================
// 1. LIOX ACTIVATION BACKEND (Hidden Proxy)
// ==========================================
// This part runs silently when the Tampermonkey script requests the payload.

if (isset($_GET['action']) && $_GET['action'] === 'fetch_payload') {
    $GATEWAY_URL = "https://rdhh23urdhhrdhh9asbody.gateway.dhruvs.host/auth/handshake";
    
    $opts = [
        "http" => [
            "method" => "POST",
            "header" => "Content-type: application/json\r\n" . "X-LIOX-Mode: Stealth-Active\r\n",
            "content" => json_encode(["ts" => time()])
        ]
    ];
    
    $context = stream_context_create($opts);
    $response = @file_get_contents($GATEWAY_URL, false, $context);
    
    if ($response === FALSE) {
        http_response_code(502);
        echo json_encode(["error" => "Gateway Unreachable"]);
    } else {
        header('Content-Type: application/json');
        echo $response;
    }
    exit; // Stop here so we don't send HTML to the script
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIOX Protocol | Documentation</title>
    <style>
        :root {
            --bg-dark: #0d1117; --bg-panel: #161b22; --border: #30363d;
            --text-main: #c9d1d9; --text-muted: #8b949e;
            --accent: #2ea44f; --link: #58a6ff; --danger: #f85149;
            --code-bg: #1f2428;
        }
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            background-color: var(--bg-dark); color: var(--text-main);
            margin: 0; display: flex; min-height: 100vh; overflow-x: hidden;
        }

        /* SIDEBAR */
        aside {
            width: 280px; background-color: var(--bg-panel); border-right: 1px solid var(--border);
            padding: 2rem; position: fixed; height: 100vh; overflow-y: auto; z-index: 10;
        }
        .brand { display: flex; align-items: center; gap: 15px; margin-bottom: 2rem; }
        .logo-svg { width: 40px; height: 40px; }
        h1 { font-size: 1.5rem; margin: 0; color: #fff; }
        .by-dhruvs { font-size: 0.7rem; font-weight: 800; color: var(--accent); letter-spacing: 1px; display: block; opacity: 0.8; }
        
        nav ul { list-style: none; padding: 0; }
        nav li { margin-bottom: 0.5rem; }
        nav a {
            color: var(--text-muted); text-decoration: none; font-size: 0.95rem;
            display: block; padding: 8px 12px; border-radius: 6px; transition: all 0.2s;
        }
        nav a:hover, nav a.active { background: rgba(255,255,255,0.05); color: #fff; border-left: 3px solid var(--accent); }

        /* CONTENT */
        main { margin-left: 280px; flex: 1; padding: 4rem; max-width: 900px; }
        section { margin-bottom: 4rem; scroll-margin-top: 2rem; }
        h2 { font-size: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-bottom: 1.5rem; color: #fff; }
        h3 { font-size: 1.3rem; color: var(--link); margin-top: 2rem; }
        p, li { line-height: 1.7; color: var(--text-main); }
        code { font-family: 'Courier New', monospace; background: rgba(110,118,129,0.2); padding: 0.2em 0.4em; border-radius: 4px; color: #ff7b72; font-size: 0.9em; }
        pre { background: var(--code-bg); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border); overflow-x: auto; margin: 1.5rem 0; }
        pre code { background: transparent; padding: 0; color: var(--text-main); font-size: 0.9rem; }
        .cmd-block { border-left: 4px solid var(--accent); }
        .warning { background: rgba(248, 81, 73, 0.1); border: 1px solid var(--danger); padding: 1rem; border-radius: 6px; color: #ffcecb; }

        /* ACTIVATION OVERLAY (Hidden by default) */
        #activation-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: var(--bg-dark); z-index: 9999;
            flex-direction: column; align-items: center; justify-content: center;
        }
        .act-box {
            text-align: center; background: var(--bg-panel); padding: 3rem; 
            border: 1px solid var(--border); border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .act-btn {
            background: var(--accent); color: white; border: none; padding: 12px 24px;
            border-radius: 6px; font-size: 1.1rem; font-weight: bold; cursor: pointer; margin-top: 20px;
            transition: transform 0.1s;
        }
        .act-btn:active { transform: scale(0.98); }
        #liox-status { margin-top: 20px; min-height: 20px; color: var(--text-muted); }

        @media (max-width: 768px) {
            aside { display: none; }
            main { margin-left: 0; padding: 2rem; }
        }
    </style>
</head>
<body>

<div id="activation-overlay">
    <div class="act-box">
        <svg class="logo-svg" style="width:80px; height:80px; margin-bottom:20px;" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <polygon points="100,10 180,80 100,190 20,80" fill="#2ea44f" fill-opacity="0.2" stroke="#2ea44f" stroke-width="4" />
            <polygon points="100,40 150,80 100,140 50,80" fill="#2ea44f" />
        </svg>
        <h1>LIOX SECURE ACTIVATION</h1>
        <p>Establish a secure link with the Gateway to install the kernel.</p>
        <button id="liox-activate-btn" class="act-btn">ACTIVATE PROTOCOL</button>
        <div id="liox-status">Waiting for user authorization...</div>
    </div>
</div>

<aside>
    <div class="brand">
        <svg class="logo-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#2ea44f"/><stop offset="100%" stop-color="#1b5e20"/></linearGradient>
          </defs>
          <polygon points="100,10 180,80 100,190 20,80" fill="none" stroke="#2ea44f" stroke-width="4" />
          <polygon points="100,40 150,80 100,140 50,80" fill="url(#g1)" />
        </svg>
        <div>
            <h1>LIOX</h1>
            <span class="by-dhruvs">BY DHRUVS HOST</span>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="#intro">Introduction</a></li>
            <li><a href="#install">Installation</a></li>
            <li><a href="#commands">Command Reference</a></li>
            <li><a href="#arch">Architecture</a></li>
            <li><a href="#trouble">Troubleshooting</a></li>
            <li style="margin-top: 20px; border-top: 1px solid #30363d; padding-top: 10px;">
                <a href="#activate" style="color: var(--accent);">Initialize LIOX</a>
            </li>
        </ul>
    </nav>
</aside>

<main>
    <section id="intro">
        <h2>The LIOX Protocol</h2>
        <p>LIOX (Live Injection & Output Exchange) is a browser-based terminal interface designed to bridge the gap between <strong>Google Gemini</strong> and <strong>Production Deployment</strong>.</p>
    </section>

    <section id="install">
        <h2>Installation</h2>
        <p>To use LIOX, install the UserScript via Tampermonkey.</p>
        <ol>
            <li>Install Tampermonkey.</li>
            <li>Add the <strong>LIOX Loader Script</strong>.</li>
            <li>Click <strong><a href="#activate" style="color:var(--accent)">Initialize LIOX</a></strong> in the sidebar to activate.</li>
        </ol>
    </section>

    <section id="commands">
        <h2>Command Reference</h2>
        <h3>1. Create Repository</h3>
        <pre class="cmd-block"><code>git repo create &lt;name&gt; "&lt;desc&gt;" &lt;private|public&gt;</code></pre>

        <h3>2. Deploy</h3>
        <pre class="cmd-block"><code>liox --deploy &lt;repo_name&gt;</code></pre>
        
        <h3>3. Push Code</h3>
        <pre class="cmd-block"><code>git push &lt;repo_name&gt;</code></pre>
    </section>

    <section id="arch">
        <h2>Architecture</h2>
        <p>LIOX runs on a <strong>Netlify/Vercel Serverless</strong> architecture.</p>
        <ul>
            <li><strong>Frontend:</strong> Pure DOM injection (CSP Bypass).</li>
            <li><strong>Backend:</strong> Secure Gateway Handshake.</li>
            <li><strong>Storage:</strong> 50x Encrypted Local Storage.</li>
        </ul>
    </section>

    <footer>
        <p>LIOX Protocol Documentation &copy; <?php echo date("Y"); ?></p>
        <p><span class="by-dhruvs">BY DHRUVS HOST</span></p>
    </footer>
</main>

<script>
    // ROUTER: Checks if user wants to activate
    function checkHash() {
        if (window.location.hash === '#activate') {
            document.getElementById('activation-overlay').style.display = 'flex';
            document.querySelector('aside').style.filter = 'blur(5px)';
            document.querySelector('main').style.filter = 'blur(5px)';
        } else {
            document.getElementById('activation-overlay').style.display = 'none';
            document.querySelector('aside').style.filter = 'none';
            document.querySelector('main').style.filter = 'none';
        }
    }
    
    window.addEventListener('hashchange', checkHash);
    checkHash(); // Run on load
</script>

</body>
</html>
