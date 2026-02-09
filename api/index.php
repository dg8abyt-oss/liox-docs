<?php
// ==========================================
// 1. LIOX ACTIVATION BACKEND (Hidden Proxy)
// ==========================================
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
    <title>LIOX Protocol | Custom Gemini Environment</title>
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
        header { padding: 15px 20px; position: sticky; top: 0; background: rgba(13,17,23,0.95); backdrop-filter: blur(10px); z-index: 100; border-bottom: 1px solid var(--border); }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        
        /* LOGO STYLE */
        .logo { display: flex; align-items: center; text-decoration: none; gap: 10px; }
        .logo img { height: 45px; width: auto; }
        .logo span { font-weight: 800; font-size: 22px; color: #fff; letter-spacing: -0.5px; }
        
        .nav-links { display: flex; align-items: center; }
        .nav-links a { color: var(--text); text-decoration: none; margin-left: 25px; font-weight: 500; font-size: 14px; transition: 0.2s; }
        .nav-links a:hover { color: #fff; }
        .btn-install { background: var(--accent); color: #fff; padding: 8px 18px; border-radius: 6px; font-weight: 600; text-decoration: none; transition: 0.2s; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; font-size: 14px; margin-left: 20px; }
        .btn-install:hover { background: var(--accent-hover); transform: translateY(-1px); }

        /* HERO SECTION */
        .hero { padding: 120px 0; text-align: center; background: radial-gradient(circle at top, #1c2128 0%, #0d1117 70%); }
        .hero h1 { font-size: 72px; line-height: 1.1; margin-bottom: 25px; color: #fff; letter-spacing: -2px; font-weight: 800; }
        .hero p { font-size: 22px; color: var(--muted); max-width: 700px; margin: 0 auto 50px; line-height: 1.5; }
        .hero-btns { display: flex; gap: 20px; justify-content: center; }
        .hero-btns .btn-primary { background: #fff; color: #000; padding: 14px 30px; border-radius: 6px; font-weight: 700; text-decoration: none; transition: 0.2s; font-size: 18px; cursor: pointer; border: none; }
        .hero-btns .btn-secondary { background: transparent; color: #fff; padding: 14px 30px; border-radius: 6px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); font-size: 18px; cursor: pointer; }

        /* ABOUT SECTION */
        .about { padding: 80px 0; border-top: 1px solid var(--border); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; margin-top: 50px; }
        .card { background: var(--panel); border: 1px solid var(--border); padding: 40px; border-radius: 12px; transition: 0.3s; position: relative; overflow: hidden; }
        .card:hover { transform: translateY(-5px); border-color: var(--muted); }
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
        
        /* Pulse Animation for Status */
        .status-dot { display: inline-block; width: 10px; height: 10px; background: #f85149; border-radius: 50%; margin-right: 8px; }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <a href="/" class="logo">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQwIiBoZWlnaHQ9IjI0MCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgPGRlZnM+CiAgICA8IS0tIFNvZnQgaGlnaGxpZ2h0IGdyYWRpZW50IC0tPgogICAgPGxpbmVhckdyYWRpZW50IGlkPSJnbG9zc1RvcCIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgICA8c3RvcCBvZmZzZXQ9IjAlIiBzdG9wLWNvbG9yPSIjZmZmZmZmIiBzdG9wLW9wYWNpdHk9IjAuOSIvPgogICAgICA8c3RvcCBvZmZzZXQ9IjQwJSIgc3RvcC1jb2xvcj0iI2I0ZmZjZSIgc3RvcC1vcGFjaXR5PSIwLjQiLz4KICAgICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjNGJmZjg1IiBzdG9wLW9wYWNpdHk9IjAuMSIvPgogICAgPC9saW5lYXJHcmFkaWVudD4KCiAgICA8IS0tIE1haW4gZ3JlZW4gZ3JhZGllbnQgLS0+CiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImdyZWVuRmFkZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+CiAgICAgIDxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiM4YWZmYjUiLz4KICAgICAgPHN0b3Agb2Zmc2V0PSI1MCUiIHN0b3AtY29sb3I9IiM0YmZmODgiLz4KICAgICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjMDBiMzRhIi8+CiAgICA8L2xpbmVhckdyYWRpZW50PgogIDwvZGVmcz4KCiAgPCEtLSBPdXRlciBkaWFtb25kIC0tPgogIDxwb2x5Z29uCiAgICBwb2ludHM9IjEwMCwxMCAxODAsODAgMTAwLDE5MCAyMCw4MCIKICAgIGZpbGw9InVybCgjZ3JlZW5GYWRlKSIKICAgIHN0cm9rZT0iIzBmNWMyZSIKICAgIHN0cm9rZS13aWR0aD0iNCIKICAvPgoKICA8IS0tIEdsb3NzIG92ZXJsYXkgLS0+CiAgPHBvbHlnb24KICAgIHBvaW50cz0iMTAwLDEwIDE4MCw4MCAxMDAsMTEwIDIwLDgwIgogICAgZmlsbD0idXJsKCNnbG9zc1RvcCkiCiAgLz4KCiAgPCEtLSBDZW50ZXIgZmFjZXQgLS0+CiAgPHBvbHlnb24KICAgIHBvaW50cz0iMTAwLDQwIDE1MCw4MCAxMDAsMTQwIDUwLDgwIgogICAgZmlsbD0iIzRlYzk3OCIKICAgIHN0cm9rZT0iIzFhN2YzYiIKICAgIHN0cm9rZS13aWR0aD0iMi41IgogIC8+CgogIDwhLS0gVXBwZXIgbGVmdCBmYWNldCAtLT4KICA8cG9seWdvbgogICAgcG9pbnRzPSIxMDAsMTAgNTAsODAgMTAwLDQwIgogICAgZmlsbD0iI2EzZmZjNyIKICAvPgoKICA8IS0tIFVwcGVyIHJpZ2h0IGZhY2V0IC0tPgogIDxwb2x5Z29uCiAgICBwb2ludHM9IjEwMCwxMCAxNTAsODAgMTAwLDQwIgogICAgZmlsbD0iI2MyZmZlMCIKICAvPgoKICA8IS0tIExvd2VyIHJpZ2h0IGZhY2V0IC0tPgogIDxwb2x5Z29uCiAgICBwb2ludHM9IjEwMCwxNDAgMTUwLDgwIDEwMCwxOTAiCiAgICBmaWxsPSIjMjg5NjUwIgogIC8+CgogIDwhLS0gTG93ZXIgbGVmdCBmYWNldCAtLT4KICA8cG9seWdvbgogICAgcG9pbnRzPSIxMDAsMTQwIDUwLDgwIDEwMCwxOTAiCiAgICBmaWxsPSIjMWU3YTNlIgogIC8+Cjwvc3ZnPg==" alt="LIOX">
                <span>LIOX</span>
            </a>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="https://gemini.google.com/gem/1_jPTb3PQ1phZgZE5jhU3Yb-j42AWIP-F?usp=sharing" target="_blank">Launch Gem</a>
                <button onclick="openModal()" class="btn-install">INSTALL APP</button>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container" style="display:block;">
            <h1>Supercharge your<br><span style="color:var(--accent)">Custom Gemini Gem</span></h1>
            <p>LIOX connects your custom Gemini Gem to real-world infrastructure. Generate repositories, push commits, and deploy to Vercel instantly.</p>
            <div class="hero-btns">
                <button onclick="openModal()" class="btn-primary">Download LIOX</button>
                <a href="https://gemini.google.com" target="_blank" class="btn-secondary">Open Gem</a>
            </div>
        </div>
    </section>

    <section class="container about" id="about">
        <h2 style="text-align:center; font-size:32px; color:#fff;">Why Use LIOX?</h2>
        <div class="grid">
            <div class="card">
                <h3>Custom Gem Integration</h3>
                <p>LIOX injects a lightweight terminal directly into your custom Gemini Gem interface. No browser extensions or desktop apps required.</p>
            </div>
            <div class="card">
                <h3>One-Click Deploy</h3>
                <p>Turn AI-generated code into live websites instantly. LIOX handles the git commands and Vercel deployment automatically.</p>
            </div>
            <div class="card">
                <h3>Secure By Design</h3>
                <p>Your API tokens are encrypted locally in your browser. LIOX uses a stealth injection method to bypass CSP restrictions safely.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>
            &copy; <?php echo date("Y"); ?> LIOX Protocol. Powered by <strong style="color:var(--accent)">Dhruvs Host</strong>.
            <br><br>
            <a href="#activate" style="color: #30363d; text-decoration: none; font-size: 11px; transition: 0.2s;" onmouseover="this.style.color='#2ea44f'" onmouseout="this.style.color='#30363d'">
                [ Initialize Secure Kernel ]
            </a>
        </p>
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
                    <label for="c2">I acknowledge that this tool is designed for the <code class="code-pill">LIOX Custom Gem</code>.</label>
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
            <h1 style="color:#fff; font-size:24px; margin-bottom:10px;">LIOX SECURE LINK</h1>
            <p style="color:var(--muted); margin-bottom:30px;">Establish connection with Gateway.</p>
            
            <button id="liox-activate-btn" class="btn-install" style="font-size:16px; padding:15px 30px; width:100%; background:#30363d; cursor:not-allowed;">Waiting for UserScript...</button>
            
            <div id="liox-status" style="margin-top:20px; color:var(--muted); font-size:13px; min-height:20px;">
                <span class="status-dot" id="script-dot"></span> <span id="script-msg">Script Not Detected</span>
            </div>
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
        router(); 
    </script>

</body>
</html>
