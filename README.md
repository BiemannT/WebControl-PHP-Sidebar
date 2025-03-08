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

# Verwendung
## Webseite
Zu Beginn der PHP-Datei müssen die PHP-Moduldateien aus dem Ordner `src` mit `require_once` geladen werden. Im folgenden wird die Verwendung des Moduls mit den wichtigsten Elementen gezeigt. Die weiteren Methoden und Eigenschaften der jeweiligen Klassen werden im Kapitel Funktionsreferenz erklärt.

Zur weiteren Vereinfachung wird empfohlen die Modul-Klassen mit einem Alias zu verknüpfen, z.B.:
```php
use Webcontrol\Sidebar\Main as SbMain;
use Webcontrol\Sidebar\Item as SbItem;
```

Die Sidebar kann dann über den Konstruktor der Klasse `Main` initialisiert werden:
```php
$NavSidebar = new SbMain("nav", "WebCtlNav");
```
Mit den Parametern wird angegeben, dass der generierte HTML-Code in ein  `<nav>`-Element eingebettet werden soll und die darin erzeugten `<input>`-Elemente mit der **ID** `WebCtlNav` beginnen sollen.

Ein Steuerelement für die Sidebar kann über den Konstruktor der Klasse `Item` initialisiert werden:
```php
$NavSidebarItem = new SbItem("Start");
```
Mit dem übergebenen Parameter wird bereits angegeben, dass das Steuerelement **Start** heißen soll.

Optional können diesem Steuerelement noch ein Symbol-Bild und ein http-Link hinzugefügt werden:
```php
$NavSidebarItem->symbolHref = "./path/to/symbol.svg";
$NavSidebarItem->linkHref = "/link/to/target.php";
```

Nachdem das Steuerelement für die Sidebar definiert wurde, kann dieses der Main-Instanz hinzugefügt werden:
```php
$NavSidebar->appendItem($NavSidebarItem);
```

Auf die gleiche Weise können der Sidebar nun beliebig weitere Steuerelemente hinzugefügt werden. Die Methode `appendItem()` kann auch bei Item-Elementen angewendet werden, wodurch Steuerelemente als Unterelemente hinzugefügt werden können. Nachdem auf diese Weise der Sidebar alle Steuerelemente hinzugefügt wurden, kann der HTML-Code wie folgt generiert werden und an beliebiger Stelle in der HTML-Datei platziert werden:
```php
<?php echo($NavSidebar->generateHTML()); ?>
```

## Stylesheet
Um die Sidebar fehlerfrei darzustellen müssen ein paar Variablen in einem zusätzlichen css-Stylesheet definiert werden und die Positionierung der Sidebar festgelegt werden. Weitere Beispiele können den demo-Dateien entnommen werden.

### Globale Variablen
Folgende globale Variablen müssen definiert werden, die auch von anderen Webcontrol-Steuerelemente wiederverwendet werden. Üblicherweise erfolgt die Definition im `:root {}`-Element.

+ **--ColNavBackground**: Eine Farbe, die als Hintergrundfarbe für die Sidebar verwendet wird
+ **--ColNavBackgrundHover**: Eine Farbe als Hover-Effekt, die verwendet wird, um ein Steuerelement farblich hervorzuheben, wenn der Mauszeiger sich über diesem Steuerelement befindet
+ **--ColNavForeground**: Eine Farbe, die als Schriftfarbe für die Steuerelemente in der Sidebar verwendet wird

### Lokale Variablen
Folgende lokale Variablen müssen explizit für die Instanz der Sidebar definiert werden.

+ **--WebCtlSidebarWidth**: Eine Größenangabe, um die Gesamt-Breite der Sidebar zu definieren
+ **--WebCtlSidebarMainItemSymbolSize**: Eine Größenangabe, um die Größe der Symbole auf der ersten Hauptebene zu definieren
+ **--WebCtlSidebarSubItemSymbolSize**: Eine Größenangabe, um die Größe der Symbole für Unterelemente zu definieren
+ **--WebCtlSidebarMainItemTextSize**: Eine Größenangabe, um die Schriftgröße für die Elemente in der ersten Hauptebene zu definieren
+ **--WebCtlSidebarSubItemTextSize**: Eine Größenangabe, um die Schriftgröße für Unterelemente zu definieren
