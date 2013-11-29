#!/usr/bin/python

# Raspberry Pi Temperature Logger
# Zagros Robotics, Inc.
# www.zagrosrobotics.com
# 6/25/2013
# ------
# This script called from cron every x mins.  Logs to two text files
# Limits the files to a maximum size.
#
#
#  Owen  - Oct 13 - Second sensor - separate output file
#

import smbus
import time
import datetime

######
#SMBus(0) - Raspberry Pi Model A
#SMBus(1) - Raspberry Pi Model B

bus = smbus.SMBus(1)

#I2C address of sensor
address1 = 0x48
address2 = 0x49


# Data files - todo - this script crashes if 
# they're not the same number of lines
file1='/home/pi/tempLogger/tempdata1.txt'
file2='/home/pi/tempLogger/tempdata2.txt'

# max number of lines per file - will delete from 
# front when this limit hit
maxLines=1440 			# 5 days @ 5min interval (5*24*12)



## functions
def temperature(addr):
    rvalue0 = bus.read_word_data(addr,0)
    rvalue1 = (rvalue0 & 0xff00) >> 8
    rvalue2 = rvalue0 & 0x00ff
    rvalue = (((rvalue2 * 256) + rvalue1) >> 4 ) *.0625
    return rvalue


def writeToFile(filename, sensor):
    # Open file
    f=open(filename,'a')
    # read temp
    outvalue = temperature(sensor)
    outstring = str(timestamp)+" | "+str(outvalue)+" C "
    # write
    print outstring
    f.write(outstring+"\n")
    f.close()

def trimFile(filename):
    # Open 
    f=open(filename,'r')
    # read entire file into a list
    allLines=f.readlines()
    listLen=len(allLines)
    #print "File 1 has "+str(listLen)+" lines"
    f.close()

    # write out last x lines. Overwrite file. 
    f=open(filename,'w')
    for x in range (listLen-maxLines,listLen):
       f.write(allLines[x])

    # Close
    f.close()



now = datetime.datetime.now()
timestamp = now.strftime("%Y/%m/%d %H:%M")

trimFile(file1)
trimFile(file2)

writeToFile (file1 , address1)
writeToFile (file2 , address2)



    

