Here is the updated LIOX Landing Page v15.1.

This version transforms your "Docs" site into a sleek Product Homepage.

The Docs are gone: Replaced by a professional "About the App" showcase.

New Install Flow: The modal now directs users to install.liox-kernel.dhruvs.host for the script.

Usage Info: It clearly states that code.liox-kernel.dhruvs.host is the powerhouse where code generation happens.

Backend: The hidden PHP proxy remains active to secure your API keys.

Instructions
Open your LIOX Docs repository.

Open api/index.php.

Delete everything and paste the code below.

Deploy.

PHP
liox.(start)
(api/index.php)
<?php
// ==========================================
// 1. LIOX ACTIVATION BACKEND (Hidden Proxy)
// ==========================================
// This handles the secure handshake between the user script and your Gateway.

if (isset($_GET['action']) && $_GET['action'] === 'fetch_payload') {
    // GATEWAY URL
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
        echo json_encode(["error" => "Gateway Connection Failed"]);
    } else {
        header('Content-Type: application/json');
        echo $response;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIOX Protocol | The Developer's Bridge</title>
    <style>
        :root {
            --bg: #0d1117; --panel: #161b22; --border: #30363d;
            --text: #c9d1d9; --muted: #8b949e;
            --accent: #2ea44f; --accent-hover: #2c974b; --danger: #f85149;
            --font: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: var(--font); line-height: 1.6; overflow-x: hidden; }
        
        /* HEADER */
        header { padding: 20px 0; position: sticky; top: 0; background: rgba(13,17,23,0.9); backdrop-filter: blur(10px); z-index: 100; border-bottom: 1px solid var(--border); }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-weight: 800; font-size: 24px; color: #fff; text-decoration: none; letter-spacing: -0.5px; }
        .logo span { color: var(--accent); }
        .nav-links a { color: var(--text); text-decoration: none; margin-left: 25px; font-weight: 500; font-size: 14px; transition: 0.2s; }
        .nav-links a:hover { color: #fff; }
        .btn-install { background: var(--accent); color: #fff; padding: 8px 18px; border-radius: 6px; font-weight: 600; text-decoration: none; transition: 0.2s; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; font-size: 14px; }
        .btn-install:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(46,164,79,0.3); }

        /* HERO SECTION */
        .hero { padding: 120px 0; text-align: center; background: radial-gradient(circle at top, #1c2128 0%, #0d1117 70%); }
        .hero h1 { font-size: 72px; line-height: 1.1; margin-bottom: 25px; color: #fff; letter-spacing: -2px; font-weight: 800; }
        .hero p { font-size: 22px; color: var(--muted); max-width: 700px; margin: 0 auto 50px; line-height: 1.5; }
        .hero-btns { display: flex; gap: 20px; justify-content: center; }
        .hero-btns .btn-primary { background: #fff; color: #000; padding: 14px 30px; border-radius: 6px; font-weight: 700; text-decoration: none; transition: 0.2s; font-size: 18px; cursor: pointer; border: none; }
        .hero-btns .btn-primary:hover { background: #e0e0e0; }
        .hero-btns .btn-secondary { background: transparent; color: #fff; padding: 14px 30px; border-radius: 6px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); font-size: 18px; cursor: pointer; }
        .hero-btns .btn-secondary:hover { border-color: #fff; }

        /* ABOUT SECTION */
        .about { padding: 80px 0; border-top: 1px solid var(--border); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; margin-top: 50px; }
        .card { background: var(--panel); border: 1px solid var(--border); padding: 40px; border-radius: 12px; transition: 0.3s; position: relative; overflow: hidden; }
        .card::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--accent); opacity: 0; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); border-color: var(--muted); }
        .card:hover::before { opacity: 1; }
        .card h3 { color: #fff; margin-bottom: 15px; font-size: 24px; }
        .card p { font-size: 16px; color: var(--muted); }

        /* FOOTER */
        footer { border-top: 1px solid var(--border); padding: 60px 0; text-align: center; color: var(--muted); font-size: 14px; margin-top: 80px; }

        /* MODAL */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .modal { background: #1c2128; border: 1px solid var(--border); width: 550px; border-radius: 16px; box-shadow: 0 50px 100px rgba(0,0,0,0.8); animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .modal-header { padding: 25px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .modal-body { padding: 30px; }
        .check-item { display: flex; gap: 15px; margin-bottom: 20px; align-items: flex-start; }
        .check-item input { margin-top: 5px; accent-color: var(--accent); transform: scale(1.3); cursor: pointer; }
        .check-item label { font-size: 15px; color: var(--text); cursor: pointer; line-height: 1.4; }
        .code-pill { background: rgba(46,164,79,0.15); color: var(--accent); padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 0.9em; }

        @keyframes popIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        
        /* ACTIVATION SCREEN */
        #activation-screen { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #0d1117; z-index: 10000; flex-direction: column; align-items: center; justify-content: center; }
        .act-box { border: 1px solid var(--border); padding: 50px; border-radius: 20px; background: var(--panel); max-width: 500px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <a href="/" class="logo">LIOX<span>PROTOCOL</span></a>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="https://code.liox-kernel.dhruvs.host" target="_blank">Web IDE</a>
                <button onclick="openModal()" class="btn-install">INSTALL APP</button>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container" style="display:block;">
            <h1>Code directly inside<br><span style="color:var(--accent)">Google Gemini</span></h1>
            <p>LIOX connects your AI chat to real-world infrastructure. Generate repositories, push commits, and deploy to Vercel instantly without leaving the conversation.</p>
            <div class="hero-btns">
                <button onclick="openModal()" class="btn-primary">Download LIOX</button>
                <a href="#about" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <section class="container about" id="about">
        <h2 style="text-align:center; font-size:32px; color:#fff;">Why Use LIOX?</h2>
        <div class="grid">
            <div class="card">
                <h3>Seamless Integration</h3>
                <p>LIOX injects a lightweight terminal directly into the Gemini interface. No browser extensions or desktop apps required—just pure JavaScript power.</p>
            </div>
            <div class="card">
                <h3>One-Click Deploy</h3>
                <p>Turn AI-generated code into live websites instantly. LIOX handles the git commands, repository creation, and Vercel deployment automatically.</p>
            </div>
            <div class="card">
                <h3>Secure By Design</h3>
                <p>Your API tokens are encrypted locally in your browser. LIOX uses a stealth injection method to bypass CSP restrictions safely.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> LIOX Protocol. Powered by <strong style="color:var(--accent)">Dhruvs Host</strong>.</p>
    </footer>

    <div class="modal-overlay" id="installModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="color:#fff; font-size:20px;">Install LIOX Protocol</h2>
                <span onclick="closeModal()" style="cursor:pointer; color:var(--muted); font-size:24px;">&times;</span>
            </div>
            <div class="modal-body">
                <p style="margin-bottom:20px; font-size:15px; color:#fff;">Before downloading, please confirm setup requirements:</p>
                
                <div class="check-item">
                    <input type="checkbox" id="c1" onchange="validate()">
                    <label for="c1">I understand I must activate the kernel at <code>/#activate</code> after installing.</label>
                </div>
                <div class="check-item">
                    <input type="checkbox" id="c2" onchange="validate()">
                    <label for="c2">I acknowledge that <code class="code-pill">code.liox-kernel.dhruvs.host</code> is the dedicated environment for generating code.</label>
                </div>
                <div class="check-item">
                    <input type="checkbox" id="c3" onchange="validate()">
                    <label for="c3">I agree to the LIOX Terms of Service.</label>
                </div>

                <div id="dl-btn" style="opacity:0.5; pointer-events:none; transition:0.3s; margin-top:25px;">
                    <a href="https://install.liox-kernel.dhruvs.host" target="_blank" class="btn-install" style="display:block; text-align:center; padding:15px; font-size:16px;">
                        DOWNLOAD SCRIPT
                    </a>
                    <p style="text-align:center; font-size:12px; color:var(--muted); margin-top:10px;">
                        Redirects to secure installer
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="activation-screen">
        <div class="act-box">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#2ea44f" stroke-width="2" style="margin-bottom:20px"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
            <h1 style="color:#fff; font-size:24px; margin-bottom:10px;">LIOX SECURE LINK</h1>
            <p style="color:var(--muted); margin-bottom:30px;">Ready to install the kernel payload from Gateway.</p>
            <button id="liox-activate-btn" class="btn-install" style="font-size:16px; padding:15px 30px; width:100%;">ESTABLISH CONNECTION</button>
            <div id="liox-status" style="margin-top:20px; color:var(--muted); font-size:13px; min-height:20px;">Waiting for script...</div>
        </div>
    </div>

    <script>
        // UI LOGIC
        function openModal() { document.getElementById('installModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('installModal').style.display = 'none'; }
        
        function validate() {
            const allChecked = ['c1','c2','c3'].every(id => document.getElementById(id).checked);
            const btn = document.getElementById('dl-btn');
            if (allChecked) {
                btn.style.opacity = "1";
                btn.style.pointerEvents = "all";
            } else {
                btn.style.opacity = "0.5";
                btn.style.pointerEvents = "none";
            }
        }

        // ROUTER LOGIC
        function router() {
            if (window.location.hash === '#activate') {
                document.getElementById('activation-screen').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                document.getElementById('activation-screen').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
        window.addEventListener('hashchange', router);
        router(); // Init
    </script>

</body>
</html>
