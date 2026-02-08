<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIOX Protocol | Documentation</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>

<aside>
    <div class="brand">
        <img src="/api/logo.svg" alt="LIOX Logo" class="logo">
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
    ├── index.php    (Homepage)
    ├── style.css    (Assets)
    └── data.php     (API Logic)</code></pre>
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