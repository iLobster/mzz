@echo off
set /p a="Would you like to import mzz_test.sql? (y/n): "
if %a% neq y (
    goto develop
)
echo Importing mzz_test.sql...
mysql -u root < mzz_test.sql
:develop
echo Importing mzz.sql...
mysql -u root < mzz.sql
set /p a="Done! Press any key."