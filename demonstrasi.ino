const int outputPin = 13;  // Pin output LED atau relay

void setup() {
    pinMode(outputPin, OUTPUT);
    Serial.begin(9600);
}

void loop() {
    if (Serial.available() > 0) {
        char received = Serial.read();
        
        if (received == '1') {
            digitalWrite(outputPin, HIGH);
            delay(3000);  // Aktif 3 detik
            digitalWrite(outputPin, LOW);
        }
    }
}
