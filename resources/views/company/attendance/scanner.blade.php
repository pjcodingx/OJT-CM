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

<script src="/js/html5-qrcode.min.js"></script>

<script>
//////////////////// OFFLINE QUEUE SETUP ////////////////////
let db;

const request = indexedDB.open("qrScannerDB", 1);

request.onupgradeneeded = function(event) {
    db = event.target.result;
    const store = db.createObjectStore("scans", { keyPath: "id", autoIncrement: true });
    store.createIndex("timestamp", "timestamp", { unique: false });
};

request.onsuccess = function(event) {
    db = event.target.result;
    console.log("✅ IndexedDB ready for offline queue");
};

request.onerror = function(event) {
    console.error("❌ IndexedDB failed:", event.target.error);
};

async function saveScanOffline(decodedText, photoBlob) {
    if (!db) return console.error("IndexedDB not ready");
    const tx = db.transaction(["scans"], "readwrite");
    const store = tx.objectStore("scans");
    store.add({
        qr_code: decodedText,
        photo: photoBlob,
        timestamp: Date.now(),
        status: "pending"
    });
    console.log("💾 Scan saved locally (offline queue)");

    // Add pending log entry for immediate feedback
    addLogEntry(decodedText, '⏳ Pending Sync', 'pending');
}

async function syncOfflineScans() {
    if (!db) return;
    const tx = db.transaction(["scans"], "readonly");
    const store = tx.objectStore("scans");
    const request = store.getAll();

    request.onsuccess = async function(event) {
        const scans = event.target.result;

        for (let scan of scans) {
            const formData = new FormData();
            formData.append('qr_code', scan.qr_code);
            if (scan.photo) formData.append('photo', scan.photo, 'scan_' + scan.timestamp + '.jpg');

            try {
                const res = await fetch("{{ route('company.attendance.scan') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: formData
                });
                const data = await res.json();
                console.log("📤 Offline scan uploaded:", data);

                // Update pending log entry
                updatePendingLog(scan.qr_code, data.name || 'ID: ' + scan.qr_code, data.message);

                // Delete uploaded scan from IndexedDB
                const delTx = db.transaction(["scans"], "readwrite");
                delTx.objectStore("scans").delete(scan.id);
            } catch (error) {
                console.error("❌ Failed to upload offline scan:", error);
            }
        }
    };
}

window.addEventListener('online', () => {
    console.log("🌐 Internet restored, syncing queued scans...");
    syncOfflineScans();
});

//////////////////// LOG HELPERS ////////////////////
function addLogEntry(displayName, message, status='success') {
    let logBox = document.getElementById("log-box");
    let entry = document.createElement("div");
    entry.classList.add("log-entry");
    if(status === 'pending') entry.classList.add("pending");
    else if(status === 'error') entry.classList.add("error");
    else if(status === 'denied') entry.classList.add("denied");

    entry.innerHTML = `<p style="color:darkgreen;"><strong>${displayName}</strong> - ${message} (${new Date().toLocaleTimeString()})</p>`;

    const logHeader = logBox.querySelector('.log-header');
    const infoText = logBox.querySelector('p[style*="color: #838282"]');
    if (infoText) infoText.remove();
    if (logHeader && logHeader.nextSibling) logBox.insertBefore(entry, logHeader.nextSibling);
    else logBox.appendChild(entry);

    updateScanCount();
}

function updatePendingLog(qrCode, displayName, message) {
    const logBox = document.getElementById("log-box");
    const entries = logBox.querySelectorAll(".log-entry.pending");

    entries.forEach(entry => {
        if(entry.innerHTML.includes(qrCode)) {
            entry.classList.remove('pending');
            entry.innerHTML = `<p style="color:darkgreen;"><strong>${displayName}</strong> - ${message} (Synced at ${new Date().toLocaleTimeString()})</p>`;
        }
    });
}

//////////////////// MAIN SCANNER LOGIC ////////////////////
let scanCount = 0;
let isPaused = false;

// Live clock
function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();
    let ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12 || 12;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds < 10 ? '0'+seconds : seconds;

    document.getElementById('live-clock').innerText = `${hours}:${minutes}:${seconds} ${ampm}`;
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

// Capture photo
async function capturePhoto() {
    try {
        let video = document.querySelector('#reader video') || document.querySelector('video');
        if (!video || video.videoWidth === 0 || video.videoHeight === 0) return null;

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

        return new Promise(resolve => {
            canvas.toBlob(blob => resolve(blob), 'image/jpeg', 0.95);
        });
    } catch (e) {
        console.error('❌ Error capturing photo:', e);
        return null;
    }
}

// Scanner
let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 15,
    qrbox: { width: 250, height: 250 },
    aspectRatio: 1.0,
    formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ],
    experimentalFeatures: { useBarCodeDetectorIfSupported: true },
    rememberLastUsedCamera: true,
    showTorchButtonIfSupported: true,
    videoConstraints: {
        facingMode: "environment",
        advanced: [{ focusMode: "continuous", exposureMode: "continuous", whiteBalanceMode: "continuous" }]
    }
});

let canScan = true;
let lastScannedCode = null;
let lastScanTime = 0;

async function onScanSuccess(decodedText) {
    if (!canScan || isPaused) return;

    const now = Date.now();
    if (decodedText === lastScannedCode && (now - lastScanTime) < 3000) return;

    lastScannedCode = decodedText;
    lastScanTime = now;
    canScan = false;

    const statusEl = document.getElementById('scanner-status');
    statusEl.className = "scanner-status status-processing processing";
    statusEl.innerHTML = '<span>Capturing photo...</span>';

    await new Promise(r => setTimeout(r, 200));
    const photoBlob = await capturePhoto();
    statusEl.innerHTML = '<span>Processing scan...</span>';

    if (!navigator.onLine) {
        await saveScanOffline(decodedText, photoBlob);
        statusEl.innerHTML = "<span>Offline - Scan saved locally</span>";
        canScan = true;
    } else {
        const formData = new FormData();
        formData.append('qr_code', decodedText);
        if (photoBlob) formData.append('photo', photoBlob, 'scan_' + Date.now() + '.jpg');

        fetch("{{ route('company.attendance.scan') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) new Audio('/sounds/success.mp3').play().catch(()=>{});
            else new Audio('/sounds/denied.mp3').play().catch(()=>{});

            addLogEntry(data.name || 'ID: ' + decodedText, data.message, data.success ? 'success' : 'denied');

            statusEl.className = "scanner-status status-ready";
            statusEl.innerHTML = '<span>Scanner ready - Point camera at QR code</span>';

            setTimeout(()=>{ canScan = true; }, 3000);
        })
        .catch(async err => {
            console.error("❌ Scan error:", err);
            statusEl.className = "scanner-status status-error";
            statusEl.innerHTML = '<span>Error occurred - check connection</span>';
            await saveScanOffline(decodedText, photoBlob); // Save offline if failed
            canScan = true;
        });
    }
}

html5QrcodeScanner.render(onScanSuccess);
</script>


@endsection
