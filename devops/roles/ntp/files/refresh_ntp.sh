#!/usr/bin/env bash
service ntp stop
ntpupdate ntp.ubuntu.com
service ntp start
