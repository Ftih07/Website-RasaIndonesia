<html>

<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 300px;
            height: 300px;
            margin: 0;
            padding: 0;
        }

        .logo {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-family: "Playfair Display", serif;
            position: relative;
            padding: 20px;
        }

        .title-container {
            position: absolute;
            left: 105px;
            top: 70px;
            /* Awalnya di posisi ini */
            width: 50%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s ease;
            /* Animasi biar smooth */
        }

        .title {
            font-size: 16px;
            font-weight: 900;
            word-wrap: break-word;
            white-space: normal;
            max-width: 100%;
            height: 20px;
            /* Sesuaikan tinggi agar cuma 2 baris */
            overflow: hidden;
        }

        .line {
            width: 100%;
            height: 3px;
            background-color: black;
            margin: 5px 0;
            border-radius: 10px;
        }

        .text-container {
            font-weight: bolder;
            position: absolute;
            bottom: 55px;
            color: #fcbc30;
            padding: 5px 10px;
            border-radius: 10px;

            left: 100px;
            font-size: 21px;

            max-width: 60%;
            text-align: center;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="file://{{ public_path('assets/images/stickers.svg') }}" alt="Logo" style="position: absolute; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
        <div class="title-container">
            <div class="line"></div>
            <div class="title">{{ $businessName }}</div>
            <div class="line"></div>
        </div>
        <div class="text-container">{{ $uniqueCode }}</div>
    </div>
</body>

</html>