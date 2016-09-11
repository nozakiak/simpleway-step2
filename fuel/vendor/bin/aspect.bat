@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../goaop/framework/bin/aspect
php "%BIN_TARGET%" %*
