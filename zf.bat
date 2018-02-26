@ECHO off
@title Zend Framework Update Programe

REM RUN
@cd %cd%
@SET ZF_SCRIPT=zftool.phar 
@php -d safe_mode=Off -f "%ZF_SCRIPT%" -- %*
::pause