<?php
// Jika ada data yang dikirim untuk disimpan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $value = $_POST["value"] ?? '';
    $filePath = "C:/laragon/www/iotsederhana/bantu.txt";

    if ($value === "1") {
        file_put_contents($filePath, "1");
        echo "Data berhasil disimpan!";
    } else {
        echo "Data tidak valid!";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachable Machine Image Model - TEAM Yosua SMA Trinitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
</head>
<body class="container py-5">
    <h2 class="text-center mb-4">Teachable Machine Image Model TEAM Yosua SMA Trinitas</h2>

    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div id="webcam-container"></div>
            <input type="file" id="image-upload" accept="image/*" class="form-control my-3" onchange="handleImageUpload(event)" />
            <button id="camera-btn" class="btn btn-primary" onclick="startCamera()">Start Camera</button>
            <button id="upload-btn" class="btn btn-secondary" onclick="useUploadedImage()" disabled>Use Uploaded Image</button>
            <button id="save-btn" class="btn btn-success mt-3" onclick="checkPrediction()" disabled>Simpan Data</button>
        </div>
    </div>

    <div class="mt-3 text-center" id="label-container"></div>
    
    <script>
        const URL = "https://kelyosua.vercel.app/";  // Ganti dengan URL model kamu
        let model, webcam, labelContainer, maxPredictions;
        let uploadedImage = null;

        async function init() {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();

            labelContainer = document.getElementById("label-container");
            labelContainer.innerHTML = "";
            for (let i = 0; i < maxPredictions; i++) {
                labelContainer.appendChild(document.createElement("div"));
            }
        }

        async function startCamera() {
            const flip = true;
            webcam = new tmImage.Webcam(200, 200, flip);
            await webcam.setup();
            await webcam.play();
            window.requestAnimationFrame(loop);
            
            document.getElementById("webcam-container").innerHTML = ''; // Hapus konten lama
            document.getElementById("webcam-container").appendChild(webcam.canvas);
            document.getElementById("camera-btn").disabled = true;
            document.getElementById("upload-btn").disabled = false;
        }

        async function loop() {
            if (!uploadedImage) {
                webcam.update();
                await predict(webcam.canvas);
            }
            window.requestAnimationFrame(loop);
        }

        async function predict(input) {
            if (!model) return;
            const prediction = await model.predict(input);
            labelContainer.innerHTML = "";
            let highestLabel = "";
            let highestValue = 0;

            for (let i = 0; i < maxPredictions; i++) {
                const className = prediction[i].className;
                const probability = prediction[i].probability.toFixed(2);

                const div = document.createElement("div");
                div.innerText = `${className}: ${probability}`;
                labelContainer.appendChild(div);

                if (probability > highestValue) {
                    highestValue = probability;
                    highestLabel = className;
                }
            }

            // Jika nilai tertinggi adalah Euro dengan 1.00
            if (highestLabel === "Euro" && highestValue === "1.00") {
                document.getElementById("save-btn").disabled = false; // Aktifkan tombol simpan
            }
        }

        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadedImage = new Image();
                    uploadedImage.src = e.target.result;
                    uploadedImage.onload = () => {
                        document.getElementById("webcam-container").innerHTML = ''; 
                        const canvas = document.createElement("canvas");
                        const ctx = canvas.getContext("2d");
                        canvas.width = uploadedImage.width;
                        canvas.height = uploadedImage.height;
                        ctx.drawImage(uploadedImage, 0, 0, canvas.width, canvas.height);
                        document.getElementById("webcam-container").appendChild(canvas);
                        document.getElementById("upload-btn").disabled = true;
                        predict(canvas);
                    };
                };
                reader.readAsDataURL(file);
            }
        }

        function useUploadedImage() {
            if (uploadedImage) {
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");
                canvas.width = uploadedImage.width;
                canvas.height = uploadedImage.height;
                ctx.drawImage(uploadedImage, 0, 0, canvas.width, canvas.height);
                document.getElementById("webcam-container").innerHTML = ''; 
                document.getElementById("webcam-container").appendChild(canvas);
                predict(canvas);
            }
        }

        function checkPrediction() {
            const labels = labelContainer.getElementsByTagName("div");
            for (let label of labels) {
                if (label.innerText.includes("Euro: 1.00")) {
                    saveToFile("1");
                    alert("Euro terdeteksi! Data disimpan.");
                    document.getElementById("save-btn").disabled = true;
                    break;
                }
            }
        }

        function saveToFile(value) {
            fetch("index.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "value=" + value
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error("Error:", error));
        }

        window.onload = init;
    </script>
</body>
</html>
