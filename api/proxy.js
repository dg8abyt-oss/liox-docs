// api/proxy.js
// This runs on Vercel Serverless (Node.js)
const https = require('https');

export default function handler(req, res) {
    // 1. GATEWAY URL (The Hidden Secret)
    const GATEWAY_URL = "https://rdhh23urdhhrdhh9asbody.gateway.dhruvs.host/auth/handshake";

    // 2. Only allow GET requests (or matches your script)
    res.setHeader('Access-Control-Allow-Origin', '*');
    
    // 3. Forward the request to the Gateway
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-LIOX-Mode': 'Stealth-Active'
        }
    };

    const proxyReq = https.request(GATEWAY_URL, options, (proxyRes) => {
        let data = '';
        proxyRes.on('data', (chunk) => data += chunk);
        proxyRes.on('end', () => {
            res.status(proxyRes.statusCode).json(JSON.parse(data));
        });
    });

    proxyReq.on('error', (e) => {
        res.status(500).json({ error: "Gateway Connection Failed: " + e.message });
    });

    proxyReq.write(JSON.stringify({ ts: Date.now() }));
    proxyReq.end();
}
