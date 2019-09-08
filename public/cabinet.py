#!/usr/bin/python3
import sys
import serial
import time
import socket


ip_address = "127.0.0.1"
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
ser = serial.Serial('/dev/ttyUSB0',baudrate=115200,timeout=2)
s.bind( (ip_address, 4321) )
s.listen(5)
print (f"socket has been establish on " + ip_address)

time.sleep(1)

while True:
    clientsocket, address = s.accept()
    print(f"Connect from {address} has been established!")
    msg = clientsocket.recv(20)
    msg = msg.decode()
    msg = msg.strip()

    if msg == 'ready?':
        clientsocket.send( bytes('ready', 'utf-8') )
        command = clientsocket.recv(20)
        command = command.decode()
        command = command.strip()
        ser.write( bytes( command + '\n', 'utf-8')  )
        clientsocket.close();

          
