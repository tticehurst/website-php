#!/bin/bash

nohup php -S 0.0.0.0:5555 -c php.ini > php.log 2>&1 &
