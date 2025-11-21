/**
 * WhatsApp HTTP API Server
 * Alternative untuk WAHA - Running lokal dengan whatsapp-web.js
 *
 * Cara jalankan:
 * node whatsapp-server.js
 */

const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');
const app = express();

// Middleware untuk parse JSON
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ extended: true, limit: '50mb' }));

// Port server
const PORT = process.env.WAHA_PORT || 3000;

// Status tracking
let isReady = false;
let qrCodeData = null;
let clientInfo = null;

// Initialize WhatsApp client dengan session storage
const client = new Client({
    authStrategy: new LocalAuth({
        clientId: 'wedding-voucher-session'
    }),
    puppeteer: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu'
        ]
    }
});

// Event: QR Code generated
client.on('qr', (qr) => {
    console.log('\n🔥 WhatsApp QR Code Generated!');
    console.log('📱 Scan QR code ini dengan WhatsApp Anda:\n');

    qrcode.generate(qr, { small: true });

    qrCodeData = qr;
    isReady = false;

    console.log('\n✅ Atau buka browser: http://localhost:' + PORT + '/qr');
    console.log('');
});

// Event: Client ready
client.on('ready', () => {
    console.log('\n✅ WhatsApp Client is READY!');
    console.log('🌐 API Server running on: http://localhost:' + PORT);
    console.log('📚 Test endpoint: http://localhost:' + PORT + '/status\n');

    isReady = true;
    qrCodeData = null;

    // Get client info
    client.info.then(info => {
        clientInfo = info;
        console.log('📱 Connected as:', info.pushname);
        console.log('📞 Phone:', info.wid.user);
        console.log('');
    });
});

// Event: Authenticated
client.on('authenticated', () => {
    console.log('🔐 WhatsApp Authenticated!');
});

// Event: Authentication failure
client.on('auth_failure', (msg) => {
    console.error('❌ Authentication failure:', msg);
    isReady = false;
});

// Event: Disconnected
client.on('disconnected', (reason) => {
    console.log('⚠️  WhatsApp Disconnected:', reason);
    isReady = false;
    clientInfo = null;
});

// Initialize WhatsApp client
console.log('🚀 Starting WhatsApp API Server...\n');
client.initialize();

// ========================================
// HTTP API ENDPOINTS
// ========================================

// Homepage
app.get('/', (req, res) => {
    res.send(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>WhatsApp API Server</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
                h1 { color: #25D366; }
                .status { padding: 10px; border-radius: 5px; margin: 10px 0; }
                .connected { background: #d4edda; color: #155724; }
                .disconnected { background: #f8d7da; color: #721c24; }
                pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
                a { color: #25D366; text-decoration: none; font-weight: bold; }
            </style>
        </head>
        <body>
            <h1>📱 WhatsApp API Server</h1>
            <div class="status ${isReady ? 'connected' : 'disconnected'}">
                Status: <strong>${isReady ? '🟢 CONNECTED' : '🔴 NOT CONNECTED'}</strong>
            </div>
            ${clientInfo ? `
                <p><strong>Connected as:</strong> ${clientInfo.pushname || 'Unknown'}</p>
                <p><strong>Phone:</strong> ${clientInfo.wid.user}</p>
            ` : ''}
            ${!isReady && qrCodeData ? '<p>⚠️ Please scan QR code: <a href="/qr">View QR Code</a></p>' : ''}
            <h2>📚 API Endpoints:</h2>
            <ul>
                <li><a href="/status">GET /status</a> - Check connection status</li>
                <li><a href="/qr">GET /qr</a> - View QR code (if not connected)</li>
                <li>POST /api/sessions/default/messages - Send message</li>
            </ul>
            <h3>Example Request:</h3>
            <pre>
POST http://localhost:${PORT}/api/sessions/default/messages
Content-Type: application/json

{
  "chatId": "6281234567890@c.us",
  "text": "Hello from Laravel!"
}

// Or with media (base64 image):
{
  "chatId": "6281234567890@c.us",
  "media": "data:image/png;base64,iVBORw0KGgo...",
  "caption": "Your voucher QR code"
}
            </pre>
        </body>
        </html>
    `);
});

// Get QR Code (untuk scan di browser)
app.get('/qr', (req, res) => {
    if (isReady) {
        res.send('<h1>✅ Already Connected!</h1><p>WhatsApp is ready.</p>');
    } else if (qrCodeData) {
        // Generate QR as image
        const QRCode = require('qrcode');
        QRCode.toDataURL(qrCodeData, (err, url) => {
            if (err) {
                res.send('<h1>❌ Error generating QR code</h1>');
            } else {
                res.send(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Scan QR Code</title>
                        <style>
                            body { text-align: center; font-family: Arial, sans-serif; padding: 50px; }
                            img { max-width: 400px; border: 2px solid #25D366; border-radius: 10px; }
                            h1 { color: #25D366; }
                        </style>
                        <meta http-equiv="refresh" content="5">
                    </head>
                    <body>
                        <h1>📱 Scan QR Code with WhatsApp</h1>
                        <p>Open WhatsApp → Settings → Linked Devices → Link a Device</p>
                        <img src="${url}" alt="QR Code">
                        <p><small>Page will refresh automatically every 5 seconds</small></p>
                    </body>
                    </html>
                `);
            }
        });
    } else {
        res.send('<h1>⏳ Waiting for QR code...</h1><p>Please wait, generating QR code...</p><meta http-equiv="refresh" content="2">');
    }
});

// Check status endpoint
app.get('/status', (req, res) => {
    res.json({
        status: isReady ? 'CONNECTED' : 'DISCONNECTED',
        ready: isReady,
        info: clientInfo
    });
});

// WAHA-compatible endpoint: Get session status
app.get('/api/sessions/default/status', (req, res) => {
    res.json({
        name: 'default',
        status: isReady ? 'WORKING' : 'STOPPED',
        ready: isReady
    });
});

// WAHA-compatible endpoint: Send message
app.post('/api/sessions/default/messages', async (req, res) => {
    // Check if client is ready
    if (!isReady) {
        return res.status(503).json({
            error: 'WhatsApp client is not ready. Please scan QR code first.',
            status: 'NOT_CONNECTED'
        });
    }

    try {
        const { chatId, text, media, caption, mimetype, filename } = req.body;

        // Validate chatId
        if (!chatId) {
            return res.status(400).json({
                error: 'chatId is required',
                example: '6281234567890@c.us'
            });
        }

        // Send message with media (image/file)
        if (media) {
            console.log(`📤 Sending media to ${chatId}...`);

            // Convert base64 data URI to pure base64
            let base64Data = media;
            if (media.includes('base64,')) {
                base64Data = media.split('base64,')[1];
            }

            // Prepare media message
            const messageMedia = {
                mimetype: mimetype || 'image/png',
                data: base64Data,
                filename: filename || 'image.png'
            };

            // Send with caption
            const message = await client.sendMessage(chatId, messageMedia, {
                caption: caption || ''
            });

            console.log(`✅ Media sent to ${chatId}`);

            return res.json({
                success: true,
                messageId: message.id._serialized,
                chatId: chatId,
                timestamp: message.timestamp
            });
        }

        // Send text message only
        if (text) {
            console.log(`📤 Sending text to ${chatId}: ${text.substring(0, 50)}...`);

            const message = await client.sendMessage(chatId, text);

            console.log(`✅ Text sent to ${chatId}`);

            return res.json({
                success: true,
                messageId: message.id._serialized,
                chatId: chatId,
                timestamp: message.timestamp
            });
        }

        // No text or media provided
        return res.status(400).json({
            error: 'Either text or media is required'
        });

    } catch (error) {
        console.error('❌ Error sending message:', error.message);

        return res.status(500).json({
            error: 'Failed to send message',
            message: error.message
        });
    }
});

// Health check
app.get('/health', (req, res) => {
    res.json({
        status: 'OK',
        whatsapp: isReady ? 'CONNECTED' : 'DISCONNECTED',
        uptime: process.uptime()
    });
});

// 404 handler
app.use((req, res) => {
    res.status(404).json({
        error: 'Endpoint not found',
        availableEndpoints: [
            'GET /',
            'GET /status',
            'GET /qr',
            'GET /api/sessions/default/status',
            'POST /api/sessions/default/messages'
        ]
    });
});

// Start Express server
app.listen(PORT, () => {
    console.log(`🌐 HTTP API Server listening on port ${PORT}`);
    console.log(`📖 Open browser: http://localhost:${PORT}`);
    console.log('⏳ Waiting for WhatsApp to connect...\n');
});

// Graceful shutdown
process.on('SIGINT', async () => {
    console.log('\n⏹️  Shutting down gracefully...');
    await client.destroy();
    process.exit(0);
});
