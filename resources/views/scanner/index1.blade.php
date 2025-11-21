@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2>Scanner Voucher</h2>
    <p>Arahkan kamera ke QR Code tamu.</p>

    <div id="reader" style="width: 350px; margin: auto;"></div>

    <div id="result" class="mt-4 p-3 border rounded" style="display:none;">
        <h4 id="statusText"></h4>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText) {
        fetch("{{ route('voucher.redeem') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ code: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            const box = document.getElementById("result");
            const status = document.getElementById("statusText");

            box.style.display = "block";

            if (data.status === 'success') {
                box.style.border = "3px solid green";
                status.innerHTML = "✔ " + data.message + "<br>Atas nama: <b>" + data.guest + "</b>";
            } else if (data.status === 'used') {
                box.style.border = "3px solid orange";
                status.innerHTML = "⚠ " + data.message;
            } else {
                box.style.border = "3px solid red";
                status.innerHTML = "✖ " + data.message;
            }
        });
    }

    const scanner = new Html5Qrcode("reader");
    scanner.start({ facingMode: "environment" }, {
        fps: 10,
        qrbox: 250
    }, onScanSuccess);
</script>
@endsection
