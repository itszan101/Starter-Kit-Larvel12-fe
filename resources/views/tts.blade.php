<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panggilan Antrian</title>

    {{-- Library ResponsiveVoice --}}
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=gOeAi9Ci"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: #343a40;
        }

        .form-container {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        input {
            padding: 10px;
            font-size: 16px;
            width: 250px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            margin-right: 10px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 20px;
            color: #495057;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <h1>Sistem Panggilan Antrian</h1>

    <div class="form-container">
        <input type="text" id="nama" placeholder="Masukkan nama orang">
        <button onclick="panggilNama()">Panggil</button>

        <p id="output"></p>
    </div>

    <script>
        function panggilNama() {
            const nama = document.getElementById('nama').value.trim();

            if (!nama) {
                alert('Masukkan nama terlebih dahulu!');
                return;
            }

            const teks = `Panggilan untuk ${nama}, silakan menuju loket satu.`;
            document.getElementById('output').innerText = teks;

            // Panggil suara
            responsiveVoice.speak(teks, "Indonesian Female");
        }
    </script>

</body>

</html>
