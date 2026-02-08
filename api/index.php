<?php
// ==========================================
// 1. LIOX ACTIVATION BACKEND (Hidden Proxy)
// ==========================================
// This keeps your Gateway URL hidden from the frontend source code.

if (isset($_GET['action']) && $_GET['action'] === 'fetch_payload') {
    // REPLACE WITH YOUR ACTUAL GATEWAY URL
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
    <title>LIOX Protocol | The Bridge to Production</title>
    <style>
        :root {
            --bg: #0d1117; --panel: #161b22; --border: #30363d;
            --text: #c9d1d9; --muted: #8b949e;
            --accent: #2ea44f; --accent-hover: #2c974b; --danger: #f85149;
            --font: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: var(--font); line-height: 1.6; overflow-x: hidden; }
        
        /* LAYOUT */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        header { padding: 20px 0; border-bottom: 1px solid var(--border); position: sticky; top: 0; background: rgba(13,17,23,0.9); backdrop-filter: blur(10px); z-index: 100; }
        .nav-flex { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-weight: 800; font-size: 24px; color: #fff; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo span { color: var(--accent); }
        .nav-links a { color: var(--text); text-decoration: none; margin-left: 20px; font-weight: 500; font-size: 14px; transition: color 0.2s; }
        .nav-links a:hover { color: #fff; }
        .btn-install { background: var(--accent); color: #fff; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; transition: 0.2s; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; }
        .btn-install:hover { background: var(--accent-hover); transform: translateY(-1px); }

        /* HERO */
        .hero { padding: 100px 0; text-align: center; background: radial-gradient(circle at top, #1c2128 0%, #0d1117 100%); }
        .hero h1 { font-size: 64px; line-height: 1.1; margin-bottom: 20px; color: #fff; letter-spacing: -1px; }
        .hero p { font-size: 20px; color: var(--muted); max-width: 600px; margin: 0 auto 40px; }
        .hero-btns { display: flex; gap: 20px; justify-content: center; }
        
        /* FEATURES */
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; padding: 80px 0; }
        .card { background: var(--panel); border: 1px solid var(--border); padding: 30px; border-radius: 12px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); border-color: var(--accent); }
        .card h3 { color: #fff; margin-bottom: 10px; font-size: 20px; }
        .card p { font-size: 14px; color: var(--muted); }

        /* INSTALL MODAL */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
        .modal { background: #1c2128; border: 1px solid var(--border); width: 500px; border-radius: 12px; padding: 0; box-shadow: 0 50px 100px rgba(0,0,0,0.5); animation: popIn 0.3s ease; }
        .modal-header { padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .modal-header h2 { font-size: 18px; color: #fff; margin: 0; }
        .modal-body { padding: 25px; }
        .checklist { margin: 20px 0; }
        .check-item { display: flex; gap: 12px; margin-bottom: 15px; align-items: flex-start; }
        .check-item input { margin-top: 4px; accent-color: var(--accent); transform: scale(1.2); cursor: pointer; }
        .check-item label { font-size: 14px; color: var(--text); cursor: pointer; }
        .modal-footer { padding: 20px; border-top: 1px solid var(--border); text-align: right; background: var(--panel); border-radius: 0 0 12px 12px; }
        
        .code-snippet { background: #000; padding: 15px; border-radius: 6px; font-family: monospace; font-size: 12px; color: #2ea44f; overflow-x: auto; white-space: nowrap; margin-top: 10px; border: 1px solid var(--border); }
        .warning-box { background: rgba(248, 81, 73, 0.1); border: 1px solid var(--danger); padding: 12px; border-radius: 6px; color: #ffcecb; font-size: 13px; margin-bottom: 15px; }

        @keyframes popIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        /* ACTIVATION SCREEN (HIDDEN) */
        #activation-screen { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #0d1117; z-index: 10000; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .act-box { border: 1px solid var(--border); padding: 40px; border-radius: 16px; background: var(--panel); max-width: 450px; }
    </style>
</head>
<body>

    <header>
        <div class="container nav-flex">
            <a href="/" class="logo">LIOX<span>PROTOCOL</span></a>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#docs">Documentation</a>
                <a href="https://github.com/dhruvs/liox" target="_blank">GitHub</a>
                <button onclick="openInstallModal()" class="btn-install">INSTALL v14.1</button>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>The Bridge Between<br><span style="color:var(--accent)">Gemini & Production</span></h1>
            <p>Inject real development capabilities into Google Gemini. <br>Create repositories, push code, and deploy to Vercel instantly.</p>
            <div class="hero-btns">
                <button onclick="openInstallModal()" class="btn-install" style="padding: 12px 24px; font-size: 18px;">Get Started</button>
                <a href="#docs" style="padding: 12px 24px; border: 1px solid var(--border); border-radius: 6px; color: #fff; text-decoration: none;">Read Docs</a>
            </div>
        </div>
    </section>

    <section class="container" id="features">
        <div class="grid">
            <div class="card">
                <h3>Stealth Injection</h3>
                <p>LIOX runs inside a secure, sandboxed blob that bypasses Google's CSP and Trusted Types protections seamlessly.</p>
            </div>
            <div class="card">
                <h3>Auto-Authentication</h3>
                <p>Configure your GitHub and Vercel tokens once. LIOX encrypts and stores them locally for zero-friction access.</p>
            </div>
            <div class="card">
                <h3>Live Terminal</h3>
                <p>A fully functional command-line interface injected directly into the Gemini UI for real-time control.</p>
            </div>
        </div>
    </section>

    <footer style="border-top: 1px solid var(--border); padding: 40px 0; text-align: center; color: var(--muted); font-size: 13px;">
        <p>&copy; <?php echo date("Y"); ?> LIOX Protocol. Created by <strong style="color:var(--accent)">Dhruvs Host</strong>.</p>
    </footer>

    <div class="modal-overlay" id="installModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Install LIOX Protocol</h2>
                <span onclick="closeInstallModal()" style="cursor:pointer; color:var(--muted)">✕</span>
            </div>
            <div class="modal-body">
                <div class="warning-box">
                    <strong>⚠️ PROTOCOL WARNING</strong><br>
                    LIOX is a powerful developer tool. Improper use may violate platform terms. Use at your own risk.
                </div>
                
                <p style="font-size:14px; margin-bottom:15px;">Please confirm the following to proceed:</p>
                
                <div class="checklist">
                    <div class="check-item">
                        <input type="checkbox" id="chk1" onchange="checkAgreements()">
                        <label for="chk1">I understand that after installing, I must visit <code>/#activate</code> on this site to initialize the secure kernel.</label>
                    </div>
                    <div class="check-item">
                        <input type="checkbox" id="chk2" onchange="checkAgreements()">
                        <label for="chk2">I acknowledge that the active kernel is hosted on <code>code.liox-kernel.dhruvs.host</code> and I may need to verify my connection there.</label>
                    </div>
                    <div class="check-item">
                        <input type="checkbox" id="chk3" onchange="checkAgreements()">
                        <label for="chk3">I agree to the LIOX Acceptable Use Policy.</label>
                    </div>
                </div>

                <div id="download-section" style="opacity:0.5; pointer-events:none; transition:0.3s;">
                    <p style="font-size:12px; color:var(--muted); margin-bottom:5px;">LIOX Loader Script (Tampermonkey)</p>
                    <a href="https://your-raw-script-url-here.user.js" target="_blank" class="btn-install" style="display:block; text-align:center;">DOWNLOAD USER SCRIPT</a>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeInstallModal()" style="background:transparent; border:none; color:var(--muted); cursor:pointer; margin-right:15px;">Cancel</button>
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
        // MODAL LOGIC
        function openInstallModal() {
            document.getElementById('installModal').style.display = 'flex';
        }
        function closeInstallModal() {
            document.getElementById('installModal').style.display = 'none';
        }
        function checkAgreements() {
            const chk1 = document.getElementById('chk1').checked;
            const chk2 = document.getElementById('chk2').checked;
            const chk3 = document.getElementById('chk3').checked;
            const btn = document.getElementById('download-section');
            
            if (chk1 && chk2 && chk3) {
                btn.style.opacity = "1";
                btn.style.pointerEvents = "all";
            } else {
                btn.style.opacity = "0.5";
                btn.style.pointerEvents = "none";
            }
        }

        // ROUTER LOGIC
        function handleHash() {
            if (window.location.hash === '#activate') {
                document.getElementById('activation-screen').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                document.getElementById('activation-screen').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
        window.addEventListener('hashchange', handleHash);
        handleHash(); // Run on load
    </script>

</body>
</html>
