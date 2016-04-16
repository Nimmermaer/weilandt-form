@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../umpirsky/twig-gettext-extractor/twig-gettext-extractor
php "%BIN_TARGET%" %*
