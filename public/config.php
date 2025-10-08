<?php
// haal het juiste protocol op, http of https
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
// haal domein naam op
$host = $_SERVER['HTTP_HOST'];
// haal de directory op (alles na de slash)
$scriptDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
// sla de base op in een variabele, dit is een combinatie van het protocol, de host en de directory
$base = "{$protocol}://{$host}{$scriptDir}";
