import serial
import time

# Sesuaikan COM port dengan yang digunakan oleh Arduino
arduino_port = "COM3"  # Ganti dengan COM port Arduino kamu
baud_rate = 9600

ser = serial.Serial(arduino_port, baud_rate, timeout=1)
time.sleep(2)  # Tunggu koneksi serial stabil

file_path = "C:/laragon/www/iotsederhana/bantu.txt"

while True:
    try:
        with open(file_path, "r") as file:
            content = file.read().strip()
        
        if content == "1":
            ser.write(b'1')  # Kirim angka 1 ke Arduino
            print("Mengirim sinyal 1 ke Arduino")
        else:
            ser.write(b'0')  # Kirim angka 0 ke Arduino
            print("Mengirim sinyal 0 ke Arduino")

    except Exception as e:
        print(f"Error membaca file: {e}")

    time.sleep(5)  # Tunggu 5 detik sebelum membaca ulang
