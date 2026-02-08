<?php
// LIOX Documentation - Single File Hardcoded Version
// By Dhruvs Host
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIOX Protocol | Documentation</title>
    <style>
        :root {
            --bg-dark: #0d1117;
            --bg-panel: #161b22;
            --border: #30363d;
            --text-main: #c9d1d9;
            --text-muted: #8b949e;
            --accent: #2ea44f;
            --accent-hover: #3fb950;
            --link: #58a6ff;
            --danger: #f85149;
            --code-bg: #1f2428;
        }

        * { box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        aside {
            width: 280px;
            background-color: var(--bg-panel);
            border-right: 1px solid var(--border);
            padding: 2rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 2rem;
        }

        .logo-svg {
            width: 50px;
            height: 50px;
            filter: drop-shadow(0 0 10px rgba(106, 26, 255, 0.3));
        }

        h1 {
            font-size: 1.8rem;
            margin: 0;
            letter-spacing: -0.5px;
            color: #fff;
        }

        .by-dhruvs {
            font-size: 0.75rem;
            font-variant: small-caps;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: 1px;
            margin-top: -5px;
            display: block;
            opacity: 0.9;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav li { margin-bottom: 0.5rem; }

        nav a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            display: block;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        nav a:hover, nav a.active {
            background: rgba(255,255,255,0.05);
            color: #fff;
            border-left: 3px solid var(--accent);
        }

        /* Main Content */
        main {
            margin-left: 280px;
            flex: 1;
            padding: 4rem;
            max-width: 900px;
        }

        section {
            margin-bottom: 4rem;
            scroll-margin-top: 2rem;
        }

        h2 {
            font-size: 2rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        h3 {
            font-size: 1.3rem;
            color: var(--link);
            margin-top: 2rem;
        }

        p, li {
            line-height: 1.7;
            color: var(--text-main);
        }

        code {
            font-family: 'Courier New', monospace;
            background: rgba(110,118,129,0.2);
            padding: 0.2em 0.4em;
            border-radius: 4px;
            color: #ff7b72;
            font-size: 0.9em;
        }

        pre {
            background: var(--code-bg);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            overflow-x: auto;
            margin: 1.5rem 0;
        }

        pre code {
            background: transparent;
            padding: 0;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .cmd-block {
            border-left: 4px solid var(--accent);
        }

        .warning {
            background: rgba(248, 81, 73, 0.1);
            border: 1px solid var(--danger);
            padding: 1rem;
            border-radius: 6px;
            color: #ffcecb;
        }

        footer {
            margin-top: 5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            aside { display: none; }
            main { margin-left: 0; padding: 2rem; }
        }
    </style>
</head>
<body>

<aside>
    <div class="brand">
        <svg class="logo-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="glossTop" x1="0%" y1="0%" x2="0%" y2="100%">
              <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9"/>
              <stop offset="40%" stop-color="#d6b4ff" stop-opacity="0.4"/>
              <stop offset="100%" stop-color="#9f4bff" stop-opacity="0.1"/>
            </linearGradient>
            <linearGradient id="purpleFade" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#c78aff"/>
              <stop offset="50%" stop-color="#9f4bff"/>
              <stop offset="100%" stop-color="#6a1aff"/>
            </linearGradient>
          </defs>
          <polygon points="100,10 180,80 100,190 20,80" fill="url(#purpleFade)" stroke="#5d14cc" stroke-width="4" />
          <polygon points="100,10 180,80 100,110 20,80" fill="url(#glossTop)" />
          <polygon points="100,40 150,80 100,140 50,80" fill="#b47aff" stroke="#6a1aff" stroke-width="2.5" />
          <polygon points="100,10 50,80 100,40" fill="#d3b2ff" />
          <polygon points="100,10 150,80 100,40" fill="#e4ccff" />
          <polygon points="100,140 150,80 100,190" fill="#7430d7" />
          <polygon points="100,140 50,80 100,190" fill="#5b1fae" />
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
        </ul>
    </nav>
</aside>

<main>
    <section id="intro">
        <h2>The LIOX Protocol</h2>
        <p>LIOX (Live Injection & Output Exchange) is a browser-based terminal interface designed to bridge the gap between <strong>Google Gemini</strong> and <strong>Production Deployment</strong>.</p>
        <p>It allows you to generate code in Gemini and instantly push it to GitHub and deploy it to Vercel without ever leaving the chat interface or touching a command line.</p>
    </section>

    <section id="install">
        <h2>Installation</h2>
        <p>To use LIOX, you need the UserScript runner.</p>
        <ol>
            <li>Install the <strong>Tampermonkey</strong> extension for your browser.</li>
            <li>Create a new script.</li>
            <li>Paste the latest <strong>LIOX v8.1</strong> source code.</li>
            <li>Navigate to Gemini and look for the <code>[LIOX]</code> HUD in the bottom right corner.</li>
            <li><strong>First Run:</strong> Open the terminal (Alt+M) and set your keys:
                <pre><code>git set &lt;your_github_token&gt;
vercel set &lt;your_vercel_token&gt;</code></pre>
            </li>
        </ol>
    </section>

    <section id="commands">
        <h2>Command Reference</h2>
        <p>LIOX uses a strict whitelist of commands to ensure stability.</p>

        <h3>1. Create Repository</h3>
        <pre class="cmd-block"><code>git repo create &lt;name&gt; "&lt;description&gt;" &lt;private|public&gt;</code></pre>
        <p>Creates a new empty repository on your GitHub account.</p>

        <h3>2. Initial Push (Full Sync)</h3>
        <pre class="cmd-block"><code>git push &lt;repo_name&gt;</code></pre>
        <p><strong>Warning:</strong> This wipes the remote repository and uploads the code block from the current chat. Use this for the first upload.</p>

        <h3>3. Update (Patch)</h3>
        <pre class="cmd-block"><code>git update &lt;repo_name&gt;</code></pre>
        <p>Updates only the files present in the current code block. Existing files in the repo are preserved.</p>

        <h3>4. Production Deploy</h3>
        <pre class="cmd-block"><code>liox --deploy &lt;repo_name&gt;</code></pre>
        <p>Connects Vercel to your GitHub repo and triggers a <strong>Force Build</strong> to Production.</p>

        <h3>5. Delete Project</h3>
        <pre class="cmd-block"><code>liox --delete &lt;project_name&gt;</code></pre>
        <p class="warning">Destroys the project on Vercel immediately.</p>
    </section>

    <section id="arch">
        <h2>Architecture Constraints</h2>
        <p>To ensure successful deployments via LIOX, all generated projects follow the <strong>PHP Serverless</strong> pattern.</p>
        
        <h3>The Golden Rules</h3>
        <ul>
            <li><strong>No Root PHP:</strong> All <code>.php</code> files must reside in the <code>api/</code> directory.</li>
            <li><strong>Routing:</strong> The <code>vercel.json</code> file handles routing from <code>/</code> to <code>api/index.php</code>.</li>
            <li><strong>Runtime:</strong> Must use <code>vercel-php@0.7.4</code> or newer to support modern Node.js environments.</li>
        </ul>

        <h3>Example Structure</h3>
        <pre><code>/
├── vercel.json      (Router Config)
└── api/
    ├── index.php    (Everything in one file)</code></pre>
    </section>

    <section id="trouble">
        <h2>Troubleshooting</h2>
        <h3>"Build Failed: Pattern doesn't match"</h3>
        <p>This means you put a PHP file in the root folder. Move it to <code>api/</code>.</p>

        <h3>"Runtime Discontinued"</h3>
        <p>Update <code>vercel.json</code> to use <code>"runtime": "vercel-php@0.7.4"</code>.</p>

        <h3>"Button not showing"</h3>
        <p>Click the <strong>[FORCE SCRAPE]</strong> button inside the LIOX terminal header to manually find the code block.</p>
    </section>

    <footer>
        <p>LIOX Protocol Documentation &copy; <?php echo date("Y"); ?></p>
        <p><span class="by-dhruvs">BY DHRUVS HOST</span></p>
    </footer>
</main>

</body>
</html>