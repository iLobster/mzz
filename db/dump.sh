#!/bin/sh

mysqldump --add-drop-database --add-drop-table --routines --net_buffer_length=4K --disable-add-locks --databases mzz -u root > mzz.sql
