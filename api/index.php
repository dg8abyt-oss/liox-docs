<?php
// Simple routing logic can go here if needed, but for docs, a single page is fine.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIOX Documentation</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>

<header>
    <div class="logo-container">
        <img src="/api/logo.svg" alt="Dhruvs Host Logo" class="logo">
        <h1>LIOX</h1>
    </div>
    <div class="branding">
        POWERED BY <span class="dhruvs-host">DHRUVS HOST</span>
        <img src="/api/logo.svg" style="width: 20px; height: 20px; vertical-align: middle;">
    </div>
</header>

<div class="container">

    <section id="intro">
        <h2>Introduction</h2>
        <p>LIOX is a browser-injected terminal interface that bridges the gap between AI generation and cloud deployment. It allows you to execute code directly from Google Gemini to GitHub and Vercel.</p>
    </section>

    <section id="installation">
        <h2>Installation</h2>
        <p>1. Install the <strong>Tampermonkey</strong> extension for your browser.</p>
        <p>2. Create a new script and paste the LIOX source code.</p>
        <p>3. Reload Gemini. Look for the <code>[LIOX]</code> HUD in the bottom right.</p>
    </section>

    <section id="commands">
        <h2>Command Reference</h2>
        <p>LIOX supports a strict set of commands to ensure stability.</p>

        <h3>Create Repository</h3>
        <pre><code>git repo create &lt;name&gt; "&lt;description&gt;" &lt;private|public&gt;</code></pre>
        <p>Creates a new GitHub repository. Use this for fresh projects.</p>

        <h3>Push (Full Sync)</h3>
        <pre><code>git push &lt;repo&gt;</code></pre>
        <p>Wipes the remote repository and uploads the current code block. Use for initial setup.</p>

        <h3>Update (Patch)</h3>
        <pre><code>git update &lt;repo&gt;</code></pre>
        <p>Updates only the files present in the current block. Good for bug fixes.</p>

        <h3>Deploy</h3>
        <pre><code>liox --deploy &lt;repo&gt;</code></pre>
        <p>Triggers a Vercel deployment linked to your GitHub repository.</p>

        <h3>Delete</h3>
        <pre><code>liox --delete &lt;project_name&gt;</code></pre>
        <p>Permanently deletes a project from Vercel.</p>
    </section>

    <section id="architecture">
        <h2>Architecture Constraints</h2>
        <p>When generating apps with LIOX, follow the <strong>Serverless PHP</strong> pattern:</p>
        <ul>
            <li><strong>Frontend:</strong> Static files or PHP in the <code>api/</code> folder.</li>
            <li><strong>Backend:</strong> All logic must live in <code>api/</code>.</li>
            <li><strong>Config:</strong> Always include <code>vercel.json</code>.</li>
        </ul>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> LIOX Project. <span class="dhruvs-host">BY DHRUVS HOST</span></p>
    </footer>

</div>

</body>
</html>