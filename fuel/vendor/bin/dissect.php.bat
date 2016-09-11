@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../jakubledl/dissect/bin/dissect.php
php "%BIN_TARGET%" %*
