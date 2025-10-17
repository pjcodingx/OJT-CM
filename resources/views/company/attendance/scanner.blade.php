@extends('layouts.company')

@section('content')

<style>
* {
    box-sizing: border-box;
}

.qr-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

#reader {
    width: 100%;
    max-width: 500px;
    border: 2px solid darkgreen;
    border-radius: 10px;
    padding: 0px;
}

#result {
    margin-top: 15px;
    color: darkgreen;
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    min-height: 40px;
}

.result-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.result-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.result-denied {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

#log-box {
    flex: 1;
    min-width: 280px;
    height: 500px;
    overflow-y: auto;
    background: #f9f9f9;
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 8px;
}

.log-entry {
    background-color: #e0f5e0;
    padding: 10px;
    margin-bottom: 10px;
    border-left: 5px solid #28a745;
    border-radius: 4px;
    word-wrap: break-word;
}

.log-entry.error {
    background-color: #f8d7da;
    border-left-color: #dc3545;
}

.log-entry.denied {
    background-color: #fff3cd;
    border-left-color: #ffc107;
}

.log-entry p {
    margin: 0;
    font-size: 14px;
}

.scanner-status {
    margin: 10px 0;
    padding: 12px;
    border-radius: 8px;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.status-ready {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-processing {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.live-clock {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    background: rgba(255, 255, 255, 0.9);
    padding: 20px 35px;
    border-radius: 20px;
    margin: 20px 0;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    display: inline-block;
}

.date-display {
    color: rgba(0, 0, 0, 0.5);
    font-size: 14px;
    white-space: nowrap;
}

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 10px;
}

.scanner-controls {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.btn-control {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-pause {
    background-color: #ffc107;
    color: #000;
}

.btn-pause:hover {
    background-color: #ffb300;
}

.btn-resume {
    background-color: #28a745;
    color: white;
}

.btn-resume:hover {
    background-color: #218838;
}

.btn-clear {
    background-color: #dc3545;
    color: white;
}

.btn-clear:hover {
    background-color: #c82333;
}

.log-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.scan-count {
    background-color: darkgreen;
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

/* Animations */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.processing {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes slideIn {
    from {
        transform: translateX(-20px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.log-entry {
    animation: slideIn 0.3s ease-out;
}

/* Mobile Responsive Styles */
@media (max-width: 768px) {
    .container {
        padding: 10px !important;
    }

    h2 {
        font-size: 20px !important;
        margin-bottom: 10px !important;
    }

    .header-section {
        flex-direction: column;
        align-items: flex-start;
    }

    .scanner-status {
        font-size: 13px;
        padding: 10px;
        flex-direction: column;
        align-items: flex-start;
    }

    .date-display {
        font-size: 12px;
    }

    .qr-layout {
        flex-direction: column;
        gap: 15px;
    }

    #reader {
        max-width: 100%;


    }



    #log-box {
        height: 400px;
        min-width: 100%;
        padding: 10px;
    }

    .live-clock {
        font-size: 20px;
        padding: 15px 25px;
        width: 100%;
        text-align: center;
    }

    .log-entry p {
        font-size: 13px;
    }

    .scanner-controls {
        width: 100%;
    }

    .btn-control {
        flex: 1;
        min-width: 80px;
        padding: 10px;
    }

    .log-header h4 {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 18px !important;
    }

    .live-clock {
        font-size: 18px;
        padding: 12px 20px;
    }

    #log-box {
        height: 350px;
    }

    .scanner-status {
        font-size: 12px;
    }

    .log-entry {
        padding: 8px;
    }

    .log-entry p {
        font-size: 12px;
    }

    .btn-control {
        font-size: 13px;
        padding: 8px;
    }
}

/* Landscape orientation on mobile */
@media (max-height: 600px) and (orientation: landscape) {
    #log-box {
        height: 250px;
    }

    .live-clock {
        padding: 10px 20px;
        font-size: 16px;
    }
}
</style>

<div class="container mt-4">
    <div class="header-section">
        <h2 style="color:darkgreen;">QR Code Attendance Scanner</h2>
        <div class="live-clock" id="live-clock"></div>
    </div>

    <div id="scanner-status" class="scanner-status status-ready">
        <span>Scanner ready - Point camera at QR code</span>
        <span class="date-display">{{ \Carbon\Carbon::now()->format('F d, Y') }}</span>
    </div>

    <div class="scanner-controls">
        <button id="pauseBtn" class="btn-control btn-pause" onclick="toggleScanner()">Pause Scanner</button>
        <button class="btn-control btn-clear" onclick="clearLogs()">Clear History</button>
    </div>

    <div class="qr-layout">
        <div style="flex: 1; min-width: 280px;">
            <div id="reader"></div>
            <div id="result"></div>
        </div>

        <div id="log-box">
            <div class="log-header">
                <h4 style="color: rgba(3, 71, 3, 0.7); margin: 0;">Recent Scans</h4>
                <span class="scan-count" id="scan-count">0 scans</span>
            </div>
            <p style="color: #838282; font-size: 12px; margin-bottom: 15px;">Scan history will appear here...</p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
 let scanCount = 0;
let isPaused = false;

// Live clock update
function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();
    let ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    let timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
    document.getElementById('live-clock').innerText = timeString;
}
updateClock();
setInterval(updateClock, 1000);

function updateScanCount() {
    scanCount++;
    document.getElementById('scan-count').innerText = scanCount + ' scan' + (scanCount !== 1 ? 's' : '');
}

function clearLogs() {
    if (confirm('Clear all scan history?')) {
        const logBox = document.getElementById('log-box');
        logBox.innerHTML = `
            <div class="log-header">
                <h4 style="color: rgba(3, 71, 3, 0.7); margin: 0;">Recent Scans</h4>
                <span class="scan-count" id="scan-count">0 scans</span>
            </div>
            <p style="color: #838282; font-size: 12px; margin-bottom: 15px;">Scan history will appear here...</p>
        `;
        scanCount = 0;
    }
}

function toggleScanner() {
    isPaused = !isPaused;
    const btn = document.getElementById('pauseBtn');
    const statusEl = document.getElementById('scanner-status');

    if (isPaused) {
        btn.innerText = 'Resume Scanner';
        btn.className = 'btn-control btn-resume';
        statusEl.className = 'scanner-status status-processing';
        statusEl.innerHTML = '<span>Scanner paused</span>';
    } else {
        btn.innerText = 'Pause Scanner';
        btn.className = 'btn-control btn-pause';
        statusEl.className = 'scanner-status status-ready';
        statusEl.innerHTML = '<span>Scanner ready - Point camera at QR code</span>';
    }
}

// Function to capture photo from video stream
async function capturePhoto() {
    try {
        // Try multiple selectors to find the video element
        let video = document.querySelector('#reader video');

        if (!video) {
            video = document.querySelector('video');
        }

        if (!video) {
            console.error('❌ No video element found');
            return null;
        }

        // Check if video is playing and has dimensions
        if (video.videoWidth === 0 || video.videoHeight === 0) {
            console.error('❌ Video dimensions are 0');
            return null;
        }

        console.log('📸 Capturing photo from video:', video.videoWidth + 'x' + video.videoHeight);

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert to blob with higher quality
        return new Promise((resolve) => {
            canvas.toBlob((blob) => {
                if (blob) {
                    console.log('✅ Photo captured successfully, size:', blob.size, 'bytes');
                } else {
                    console.error('❌ Failed to create blob from canvas');
                }
                resolve(blob);
            }, 'image/jpeg', 0.95);
        });
    } catch (error) {
        console.error('❌ Error capturing photo:', error);
        return null;
    }
}

// OPTIMIZED SCANNER CONFIG
let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 15,
    qrbox: { width: 250, height: 250 },
    aspectRatio: 1.0,
    formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ],
    experimentalFeatures: {
        useBarCodeDetectorIfSupported: true
    },
    rememberLastUsedCamera: true,
    showTorchButtonIfSupported: true,
    videoConstraints: {
        facingMode: "environment",
        advanced: [{
            focusMode: "continuous",
            exposureMode: "continuous",
            whiteBalanceMode: "continuous"
        }]
    }
});

let canScan = true;
let lastScannedCode = null;
let lastScanTime = 0;

async function onScanSuccess(decodedText) {
    console.log('🔍 Scanned QR code:', decodedText);

    if (!canScan || isPaused) return;

    const now = Date.now();
    if (decodedText === lastScannedCode && (now - lastScanTime) < 3000) {
        console.log('⚠️ Duplicate scan ignored');
        return;
    }

    lastScannedCode = decodedText;
    lastScanTime = now;
    canScan = false;

    const statusEl = document.getElementById('scanner-status');
    statusEl.className = "scanner-status status-processing processing";
    statusEl.innerHTML = '<span>Capturing photo...</span>';

    // Add small delay to ensure video is ready
    await new Promise(resolve => setTimeout(resolve, 200));

    // Capture photo
    const photoBlob = await capturePhoto();

    if (!photoBlob) {
        console.warn('⚠️ No photo captured, continuing without photo');
    }

    statusEl.innerHTML = '<span>Processing scan...</span>';

    // Prepare form data with photo
    const formData = new FormData();
    formData.append('qr_code', decodedText);
    if (photoBlob) {
        formData.append('photo', photoBlob, 'scan_' + Date.now() + '.jpg');
        console.log('📤 Sending photo with scan data');
    } else {
        console.log('📤 Sending scan data without photo');
    }

    fetch("{{ route('company.attendance.scan') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log('✅ Server response:', data);

        if(data.success){
            new Audio('/sounds/success.mp3').play().catch(e => console.log('Audio play failed'));
        } else if(data.message.toLowerCase().includes("too early") ||
                  data.message.toLowerCase().includes("not allowed")){
            new Audio('/sounds/denied.mp3').play().catch(e => console.log('Audio play failed'));
        } else {
            new Audio('/sounds/denied.mp3').play().catch(e => console.log('Audio play failed'));
        }

        statusEl.className = "scanner-status status-ready";
        statusEl.innerHTML = '<span>Scanner ready - Point camera at QR code</span>';

        let displayName = data.name || 'ID: ' + decodedText;

        let logBox = document.getElementById("log-box");
        let entry = document.createElement("div");
        entry.classList.add("log-entry");

        if (!data.success) {
            entry.classList.add(data.message.toLowerCase().includes("not allowed") ? "denied" : "error");
        }

        entry.innerHTML = `<p style="color:darkgreen;"><strong>${displayName}</strong> - ${data.message} (${new Date().toLocaleTimeString()})</p>`;

        const logHeader = logBox.querySelector('.log-header');
        const infoText = logBox.querySelector('p[style*="color: #838282"]');
        if (infoText) infoText.remove();

        if (logHeader && logHeader.nextSibling) {
            logBox.insertBefore(entry, logHeader.nextSibling);
        } else {
            logBox.appendChild(entry);
        }

        updateScanCount();

        setTimeout(() => {
            canScan = true;
        }, 3000);
    })
    .catch(err => {
        console.error("❌ Scan error:", err);
        statusEl.className = "scanner-status status-error";
        statusEl.innerHTML = '<span>Error occurred - check connection</span>';

        let logBox = document.getElementById("log-box");
        let entry = document.createElement("div");
        entry.classList.add("log-entry", "error");
        entry.innerHTML = `<p><strong>ID: ${decodedText}</strong> - Network error occurred (${new Date().toLocaleTimeString()})</p>`;

        const logHeader = logBox.querySelector('.log-header');
        if (logHeader && logHeader.nextSibling) {
            logBox.insertBefore(entry, logHeader.nextSibling);
        } else {
            logBox.appendChild(entry);
        }

        updateScanCount();

        setTimeout(() => {
            canScan = true;
            statusEl.className = "scanner-status status-ready";
            statusEl.innerHTML = '<span>Scanner ready - Point camera at QR code</span>';
        }, 3000);
    });
}

// Start the scanner
html5QrcodeScanner.render(onScanSuccess);
</script>

@endsection
