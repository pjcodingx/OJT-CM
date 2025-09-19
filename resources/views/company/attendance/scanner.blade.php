@extends('layouts.company')

@section('content')

<style>
.qr-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
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
    max-width: 500px;
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
    padding: 5px;
    border-radius: 4px;
    font-size: 14px;

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
</style>

<div class="container mt-4">
    <h2 style="color:darkgreen;">QR Code Attendance Scanner</h2>

    <div id="scanner-status" class="scanner-status status-ready">
        Scanner ready - Point camera at QR code
        <p style="color: rgba(0, 0, 0, 0.3); font-size: 14px; margin-left: 88%;">{{ (\Carbon\Carbon::now()->format('F d, Y')) }}</p>
    </div>

    <div class="qr-layout">

        <div style="flex: 1;">
            <div id="reader"></div>
            <div id="result"></div>
        </div>


        <div id="log-box">

            <p style="color: #838282; font-size: 12px;">Scan history will appear here...</p>
            <h4 style="color: rgba(3, 71, 3, 0.7); margin-bottom: 15px;">Recent Scans </h4>

        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });


let canScan = true;

function onScanSuccess(decodedText) {
    if (!canScan) return;

    canScan = false;


    const statusEl = document.getElementById("scanner-status");
    statusEl.className = "scanner-status status-processing";
    statusEl.innerText = "Processing scan...";

    fetch("{{ route('company.attendance.scan') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ qr_code: decodedText })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Scan response:', data);


        statusEl.className = "scanner-status status-ready";
        statusEl.innerText = "Scanner ready - Point camera at QR code";


        let displayName = data.name || 'ID: ' + decodedText;


        let logBox = document.getElementById("log-box");
        let entry = document.createElement("div");
        entry.classList.add("log-entry");

        if (!data.success) {
            entry.classList.add(data.message.toLowerCase().includes("not allowed") ? "denied" : "error");
        }

        entry.innerHTML = `<p style="color:darkgreen;"><strong>${displayName}</strong> - ${data.message} (${new Date().toLocaleTimeString()})</p>`;
        logBox.prepend(entry);


        setTimeout(() => {
            canScan = true;
        }, 3000);
    })
    .catch(err => {
        console.error("Scan error:", err);
        statusEl.className = "scanner-status status-error";
        statusEl.innerText = "Error occurred - see console.";


        let logBox = document.getElementById("log-box");
        let entry = document.createElement("div");
        entry.classList.add("log-entry", "error");
        entry.innerHTML = `<p><strong>ID: ${decodedText}</strong> - Network error occurred (${new Date().toLocaleTimeString()})</p>`;
        logBox.prepend(entry);


        setTimeout(() => {
            canScan = true;
            statusEl.className = "scanner-status status-ready";
            statusEl.innerText = "Scanner ready - Point camera at QR code";
        }, 3000);
    });
}

html5QrcodeScanner.render(onScanSuccess);
</script>

@endsection
