@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../jakubledl/dissect/bin/dissect
php "%BIN_TARGET%" %*
