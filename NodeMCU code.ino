#include <DHT.h>
#include <ESP8266WiFi.h>
#include <ArduinoJson.h>

#define DHTPIN D2
#define DHTTYPE DHT11 
 
const char* ssid     = "Redmi Note 7 Pro";
const char* password = "b653ac6afd64";
const char* host = "monitorfarm.000webhostapp.com";
const int sensor_pin = A0;
String url;
//  int count = 0;
DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  delay(100);
  dht.begin();
  pinMode(D1, OUTPUT);
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password); 
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
 
  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
}
void loop() {
  float h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();
  // soil moisture 
  float m = ( 100.00 - ( (analogRead(sensor_pin)/1023.00) * 100.00 ) );
  if (isnan(h) || isnan(t)) {
    Serial.println("Failed to read data from sensor!");
    return;
  }

  Serial.print("connecting to ");
  Serial.println(host);

  //parameters
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  
  String url = "/project/partials/insert.php?device_no=1&temp=" + String(t) + "&hum="+ String(h) + "&moisture=" + String(m);
  Serial.print("Requesting URL: ");
  Serial.println(url);
  
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  delay(500);
  
  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  //led
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }

    url = "/project/partials/readled.php?device_no=1";
    Serial.println("Here1");

  Serial.print("Requesting URL: ");
  Serial.println(url);
  
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  delay(500);
  String section="header";
  while(client.available()){
    String line = client.readStringUntil('\r');
    //Serial.print(line);
    // we’ll parse the HTML body here
    if (section=="header") { // headers..    
      if (line=="\n") { // skips the empty space at the beginning 
        section="json";
      }
    }
    else if (section=="json") {  // print the good stuff
      section="ignore";
      String result = line.substring(1);

      // Parse JSON
      int size = result.length() + 1;
      char json[size];
      result.toCharArray(json, size);
      StaticJsonDocument<200> doc;
      DeserializationError error = deserializeJson(doc, json);
      if (error) {
        Serial.println("deserializeJson() failed");
        Serial.println(error.c_str());
        return;
      }
      String led = doc["led"][0]["pump"];

      if(led == "on"){
          digitalWrite(D1, 1);
          delay(500);
          Serial.println("D1 is On..!");
        }
        else if(led == "off"){
          digitalWrite(D1, 0);
          delay(500);
          Serial.println("D1 is Off..!");
        }
      }
 }
  Serial.println();
  Serial.println("closing connection");
  delay(3000);
}
