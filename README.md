# WebControl-PHP-Sidebar
Mit diesem Modul können serverseitig mithilfe von *PHP* Navigationsleisten erstellt werden.

## Beispiele
Beispiele sind im Ordner *demo* enthalten.

Navigationsleiste mit verschiedenen Untermenüpunkten:

![Beispiel einer Navigationsleiste](/doc/example-navigation-left.PNG)

# Voraussetzungen
Für die Verwendung dieses Moduls ist eine konfigurierte **PHP**-Umgebung mindestens in Version **8.0** erforderlich.

Des Weiteren wird die PHP-Erweiterung **libxml** benötigt, die von PHP standardmäßig aktiviert ist.

# Installation
Dieses Modul kann mit Hilfe von [Composer](https://getcomposer.org) in die Umgebung der Web-Entwicklung geladen werden. Hierzu folgende Anweisungen in der `composer.json` angeben:
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/biemannt/webcontrol-php-sidebar"
        }
    ],

    "require": {
        "php": ">=8.0",
        "biemannt/webcontrol-php-sidebar": "^1.0"
    }
}
```

# Datei-Struktur
Folgende Dateien sind in diesem Modul-Paket enthalten:

## /src/Webcontrol_Sidebar.php
Hierbei handelt es sich um die Haupt-Programmdatei, die die erforderlichen Klassen zur Erstellung der Sidebar enthalten. Es wird empfohlen diese Datei in einem Ordner abzulegen, die nicht vom Webserver erreichbar ist, sondern nur vom PHP Interpreter erreicht werden kann.

## /public/css/Webcontrol_Sidebar.css
Dieses Stylesheet enthält allgemeine Einstellungen zur Verwendung der Sidebar im Web-Projekt. Grundlegende Einstellungen wie die Positionierung und Größe der Sidebar, sowie Farben und Schriften müssen übergeordnet in einem Stylesheet im Web-Projekt definiert werden. Dies ermöglicht eine überaus flexible Verwendung der Sidebar. Diese Datei soll in einem zentralen Stylesheet-Ordner abgelegt werden, welcher vom Webserver abgerufen werden kann.