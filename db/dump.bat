@echo off

echo Exporting mzz.sql...
mysqldump --add-drop-table --routines --net_buffer_length=4K --disable-add-locks mzz -u root > mzz.sql

set /p a="Done! Press any key."