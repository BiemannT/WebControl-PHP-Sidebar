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

# Datei und Ordner-Struktur

## Ordner src
In diesem Ordner befinden sich die php-Modul-Dateien mit den erforderlichen Klassen für dieses Modul. Es wird empfohlen diese Dateien nicht in einem Unterordner vom Wurzelverzeichnis des Web-Projekts abzulegen, sondern in einem separaten Verzeichnis, um diese Dateien vor dem Web-Nutzer zu verstecken.

### Webcontrol_Sidebar.php
Hierbei handelt es sich um die Haupt-Programmdatei, die die erforderlichen Klassen zur Erstellung der Sidebar enthalten.

## Ordner public/css
In diesem Ordner befinden sich die Stylesheet mit generellen Einstellungen zur Nutzung dieses Moduls. Diese Dateien müssen in einem Unterordner vom Wurzelverzeichnis des Web-Projekts abgelegt werden, um vom Web-Nutzer abgerufen werden zu können. Spezifische Stylesheets sind darüberhinausgehend für das Web-Projekt erforderlich, um z.B. die Positionierung und Größe, sowie Farben und Schriften für die Verwendung dieses Moduls festzulegen. Dies ermöglicht eine hohe Flexibilität bei der Verwendung dieses Moduls. Welche Eigenschaften speziell benötigt werden wird in der folgenden Dokumentation genannt.

### Webcontrol_Sidebar.css
Dieses Stylesheet enthält allgemeine Einstellungen zur Verwendung der Sidebar im Web-Projekt.

## Ordner public/js
In diesem Ordner befinden sich JavaScript-Dateien, um zusätzliche Funktionen für den Web-Nutzer bereitzustellen. Diese Dateien müssen in einem Unterordner vom Wurzelverzeichnis des Web-Projekts abgelegt werden, um vom Web-Nutzer abgerufen werden zu können.

## Ordner public/demo
In diesem Ordner befinden sich Beispiel Webseiten zur Demonstration dieses Moduls. Um die Beispiele zu testen ist eine lokale Docker Installation erforderlich. Nachdem die Dateien aus diesem Repository lokal kopiert wurden kann der vorkonfigurierte Webserver über die Datei `compose.yaml` mit Docker gestartet werden. Die Beispiele sind dann über `localhost:8080/demo/` abrufbar.