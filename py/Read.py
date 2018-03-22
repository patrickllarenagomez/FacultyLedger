#!/usr/bin/env python

import RPi.GPIO as GPIO
import MFRC522
import signal
import time
import lcddriver
import requests
from datetime import datetime

reader = MFRC522.MFRC522()
lcd = lcddriver.lcd()
continuous_reading = True

def end_read(signal, frame):
    global continuous_reading
    continuos_reading = False
    GPIO.cleanup()

def waitingForCard(self)
    lcd.lcd_display_string("  TAP CARD TO LOG.",1)

def retry(self)
    lcd.lcd_display_string("Retry tapping.", 1)
#added codes

#*************************************************************************
#code 0 ; "code" => 0
#code 1 ; "code" => 1, "professor_first_name" => , "professor_last_name"
#code 2 ; "code" => 2, "professor_first_name" => , "professor_last_name", "required_time"
#code 3 ; "code" => 3, "professor_first_name" => , "professor_last_name", "is_late"
#code 4 ; "code" => 4, "professor_first_name" => , "professor_last_name", "is_late"
#code 5 ; "code" => 5, "professor_first_name" => , "professor_last_name", "is_updated"
#code 6 ; "code" => 6, "professor_first_name" => , "professor_last_name", "is_updated"
#code 7 ; "code" => 7, "professor_first_name" => , "professor_last_name", "not_time_yet"
#code 8 ; "code" => 8, "professor_first_name" => , "professor_last_name", "is_updated"
#*************************************************************************

# functions
class printTextLCD:
    def code0(self, data):
        data["server_response"][0]['code']
        
        lcd.lcd_display_string("CN: " + card_number, 1)
        lcd.lcd_display_string("UNREGISTERED CARD! ", 2)
        lcd.lcd_display_string("PLEASE CONTACT ADMIN", 3)
        lcd.lcd_display_string(time_now, 4)

    def code1(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        
        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string(first_name + " " + last_name, 2)
        lcd.lcd_display_string("NO SCHEDULE TODAY.", 3)


    def code2(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        required_time = data["server_response"][0]['required_time'];
        
        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("TIME BEFORE LOGOUT:", 2)
        lcd.lcd_display_string(required_time + "min/s", 3)
        lcd.lcd_display_string(timewithampm, 4)
        #print(name + time before you can log out)

    
    def code3(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        is_late = data["server_response"][0]['is_late'];

        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("LOG IN REGISTERED.", 2)
        lcd.lcd_display_string("ON-TIME", 3)
        lcd.lcd_display_string(timewithampm, 4)
        #print(name + not late)

    def code4(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        is_late = data["server_response"][0]['is_late'];

        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("LOG IN REGISTERED.", 2)
        lcd.lcd_display_string("LATE", 3)
        lcd.lcd_display_string(timewithampm, 4)
        #print(name + late)


    def code5(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        is_updated = data["server_response"][0]['is_updated'];

        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("LOG OUT REGISTERED.", 2)
        lcd.lcd_display_string(timewithampm, 3)
        #print(name + log out success)

    def code6(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        is_updated = data["server_response"][0]['is_updated'];

        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("LOG OUT ALREADY", 2)
        lcd.lcd_display_string("REGISTERED EARLIER.", 3)
        lcd.lcd_display_string(timewithampm, 4)
        #print(name + log out for the schedule already done)


    def code7(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        not_time_yet = data["server_response"][0]['not_time_yet'];

        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("NOT YET YOUR", 2)
        lcd.lcd_display_string("SCHEDULE.", 3)
        lcd.lcd_display_string(timewithampm, 4)
        #print(name + not time yet for his schedule)

    def code8(self, data):
        first_name = data["server_response"][0]['professor_first_name'];
        last_name = data["server_response"][0]['professor_last_name'];
        is_updated = data["server_response"][0]['is_updated'];
        
        lcd.lcd_display_string(first_name + " " + last_name, 1)
        lcd.lcd_display_string("LOG OUT REGISTERED.", 2)
        lcd.lcd_display_string(timewithampm, 3)
        #print(name + log out success)

#functions end



# added codes



signal.signal(signal.SIGINT, end_read)
waitingForCard()

while continuous_reading:

    (status, TagType) = reader.MFRC522_Request(reader.PICC_REQIDL)
    if status == reader.MI_OK:
		card, text = reader.read()


    #variables 

    #room number depends on the room that the Raspberry PI is in
    room_number = '300';

    time_now = datetime.now().strftime('%H:%M:%S') 
    card_number = card_id;
    timewithampm = datetime.now().strftime('%H:%M %p')

    #variables end

    url = "http://pcufacultyledger.000webhostapp.com/timelog.php"
    data = {"card_number" : card_number, "current_time" : time_now, "room_number" : room_number}
    r = requests.post(url, data=data)
    data = r.json();

    #response 

    server_response = data["server_response"][0]['code']
    callback = printTextLCD() 

    if server_response is 0:
        callback.code0(data)
    elif server_response is 1:
        callback.code1(data)
    elif server_response is 2:
        callback.code2(data)
    elif server_response is 3:
        callback.code3(data)
    elif server_response is 4:
        callback.code4(data)
    elif server_response is 5:
        callback.code5(data)
    elif server_response is 6:
        callback.code6(data)
    elif server_response is 7:
        callback.code7(data)
    elif server_response is 8:
        callback.code8(data)
    else:
        retry()


	# Stop
    reader.MFRC522_StopCrypto1()        

    card_removed = False
    card_removed_counter = 3

    while not card_removed:
        (status, TagType) = reader.MFRC522_Request(reader.PICC_REQIDL)
        if status != reader.MI_OK:
            card_removed_counter = card_removed_counter-1
            if card_removed_counter == 0:
                card_removed = True
        else:
            card_removed_counter = 3
            
    waitingForCard()
    time.sleep(3);


