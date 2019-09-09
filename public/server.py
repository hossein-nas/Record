#!/usr/bin/env python3

import socket
import serial
import time
import threading
import requests

ip_address = "127.0.0.1"
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
ser = serial.Serial('/dev/Arduino1',baudrate=115200,timeout=2)
s.bind( (ip_address, 1234) )
s.listen(5)
print (f"socket has been establish on " + ip_address)
control = 0
_lock = threading.Lock();

def manage_serial():
    global control
    while True:
        if( control == 1 ):
            continue
        try:
            ser.flushInput();
            ser.flushOutput();
            ret = ser.read(14);
        except:
            print('not recv')
        if ( len(ret) > 0 and ret[:3].decode() == 'UID' ):
            r = requests.post("http://localhost/cabinet_manager", data={'uid' : ret.decode()})
            print(r.text[:333])
        time.sleep(.25)

def manage_socket():
    global control
    while True:
     clientsocket, address = s.accept()
     print(f"Connect from {address} has been established!")
     msg = clientsocket.recv(7)
     msg = msg.decode()
     # print ("Start : {time.ctime()} ")
     # time.sleep( 5 )
     # print ("END : {time.ctime()} ")

     if msg == 'ready?\n':
          clientsocket.send( bytes('ready', 'utf-8') )
          command = clientsocket.recv(20)
          command = command.decode()
          control=1
          with _lock:
            if command != '#NEWCARD' :
                print(command)
                ser.write( (command+'\n').encode() )
                clientsocket.send ( bytes('done.', 'utf-8') )
            else:
                print('NEWCARD:)')
                ser.write( (command+'\n').encode() )
                r = listen_for_resp();
                if len(r) > 0 :
                    r = "NEWCARD-" + r;
                else:
                    r="NOT DETECTED"
                clientsocket.send( bytes(r, 'utf-8') )
                print(r)
          control=0
          ser.timeout=2;
          continue
     print('not sent')
     clientsocket.send( bytes("Welcome to the server :)", 'utf-8') )

t1 = threading.Thread(target=manage_serial);
t2 = threading.Thread(target=manage_socket);
t1.start();
t2.start();

def listen_for_resp():
    ser.flushInput()
    ser.flushOutput()
    ser.timeout = 15
    try:
        resp = ser.read(14)
    except ser.timeout:
        print('timeout')
    return resp.decode()



