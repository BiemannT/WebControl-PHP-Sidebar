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
Mit den Parametern wird angegeben, dass der generierte HTML-Code in ein  `<nav>`-Element eingebettet werden soll und die darin erzeugten `<input>`-Elemente mit der **ID** `WebCtlNav` beginnen sollen. Das `<nav>`-Element erhält als **ID** den Namen `WebCtlNav`.

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

Folgende Variablen müssen explizit für die Instanz der Sidebar definiert werden:

+ **--WebCtlSidebarColBackground**: Eine Farbe, die als Hintergrundfarbe für die Sidebar verwendet wird
+ **--WebCtlSidebarColForeground**: Eine Farbe, die als Schriftfarbe für die Steuerelemente in der Sidebar verwendet wird
+ **--WebCtlSidebarColHover**: Eine Farbe als Hover-Effekt, die verwendet wird, um ein Steuerelement farblich hervorzuheben, wenn sich der Mauzeiger über dem Steuerelement befindet
+ **--WebCtlSidebarWidth**: Eine Größenangabe, um die Gesamt-Breite der Sidebar zu definieren
+ **--WebCtlSidebarMainItemSymbolSize**: Eine Größenangabe, um die Größe der Symbole auf der ersten Hauptebene zu definieren
+ **--WebCtlSidebarSubItemSymbolSize**: Eine Größenangabe, um die Größe der Symbole für Unterelemente zu definieren
+ **--WebCtlSidebarMainItemTextSize**: Eine Größenangabe, um die Schriftgröße für die Elemente in der ersten Hauptebene zu definieren
+ **--WebCtlSidebarSubItemTextSize**: Eine Größenangabe, um die Schriftgröße für Unterelemente zu definieren

# Funktionsreferenz
## Klasse Main
### Methoden
#### Konstruktor
```php
public function __construct(string $mainElementName, string $IDprefix, bool $hasMainExpander = true)
```
Erstellt eine neue Instanz für die Sidebar. Die Übergabeparameter haben folgende Bedeutung:

+ **$mainElementName**: *Erforderlich* Der Name für das HTML-Element, das als Wurzelelement für die Sidebar dienen soll, z.B. **nav**.
+ **$IDprefix**: *Erforderlich* Ein Name, der allen ID-Namen für die internen \<input>-Elemente vorangestellt wird. Der ID-Name darf an anderen Stellen im HTML-Dokument nicht verwendet werden, um die Eindeutigkeit zu gewährleisten. Zudem erhält das HTML-Element diesen Namen als **ID**. Über die ID kann die Sidebar in CSS-Stylesheets oder in JavaScripts addressiert werden.
+ **$hasMainExpander**: *Optional* Wenn *true*, kann die Sidebar verkleinert und vergrößert werden. In dem Fall wird der Sidebar als erstes Element ein `<input type="checkbox">`-Element hinzugefügt. Die ID für dieses Element lautet *$IDprefix*MainExp. Für die Funktion ist in der Sidebar mindestens ein Item mit aktivierter Eigenschaft *$isMainExpanderController* erforderlich. Durch Auswertung der CSS-Pseudoklasse `:checked` kann in einem benutzerdefinierten Stylesheet die Sidebar verkleinert und vergrößert werden.

#### appendItem()
```php
public function appendItem(Webcontrol\Sidebar\Item $NewItem):void
```
Fügt der Sidebar ein neues Steuerelement hinzu.

+ **$NewItem**: *Erforderlich* Eine Instanz der Klasse `Item`. In der gleichen Reihenfolge wie die Elemente hinzugefügt wurden, werden die Elemente in der Sidebar dargestellt.

#### generateHTML()
```php
public function generateHTML():string
```
Erzeugt entsprechend der definierten Elemente den HTML-Code und gibt diesen als Text zurück. Dabei werden die einzelnen Elemente in der Reihenfolge erzeugt, mit der diese mit der Methode `appendItem()` hinzugefügt wurden.

#### generateResetElementHTML()
```php
public function generateResetElementHTML():string
```
Erzeugt ein `<label class="WebCtlSidebarReset">`-Element, welches auf die Haupt-Checkbox `<input type="checkbox">` der Sidebar verweist und gibt den HTML-Code als Text zurück. Mit diesem Element kann an beliebiger Stelle im HTML-Code eine Reset-Schaltfläche erzeugt werden, durch die die Sidebar verkleinert wird. Diese Reset-Fläche könnte z.B. neben der Sidebar angeordnet werden, um durch einen Klick neben der Sidebar diese zu verkleinern.

In der Stylesheet Definition der Sidebar ist dieses Element standardmäßig ausgeblendet. Durch Auswertung der CSS-Pseudoklasse `:checked` von der Hauptcheckbox der Sidebar könnte diese Reset-Fläche aktiviert werden. Diese Definition muss in einem benutzerdefinierten Stylesheet erfolgen. Ein Beispiel hierzu kann dem Stylesheet aus dem `demo`-Ordner entnommen werden.

Damit dieses HTML-Element funktionieren kann ist es erforderlich, dass die `Main`-Klasse mit der Eigenschaft `$hasMainExpander = true` instanziiert wurde.

### Eigenschaften
#### showSidebarExpanded
```php
public bool $showSidebarExpanded
```
Wenn **true**, wird die Sidebar beim Öffnen der HTML-Seite vergrößert dargestellt, ansonsten verkleinert.

Der Standardwert ist **false**.

Damit diese Eigenschaft wirksam ist, muss die Klasse mit der Eigenschaft `$hasMainExpander = true` instanziiert werden.

#### showActiveElementExpanded
```php
public bool $showActiveElementExpanded
```
Wenn **true**, werden die Unterebenen zu den als aktiv gekennzeichneten Elementen geöffnet dargestellt. Ansonsten werden alle Ebenen geschlossen dargestellt.

Mindestens bei einem `Item`-Element muss die Eigenschaft `$isActiveItem = true` gesetzt werden.

## Klasse Item
### Methoden
#### Konstruktor
```php
public function __construct(string $title)
```
Erstellt eine neue Instanz für ein Steuerelement in der Sidebar.

+ **$title**: *Erforderlich* Der Name für das Steuerelement, welcher in der Sidebar angezeigt wird.

#### appendItem()
```php
public function appendItem(Webcontrol\Sidebar\Item $NewItem):void
```
Fügt diesem Steuerelement weitere Unterelemente hinzu.

+ **$NewItem**: *Erforderlich* Eine Instanz der Klasse `Item`. In der gleichen Reihenfolge wie die Elemente hinzugefügt wurden, werden die Elemente in der Sidebar dargestellt.

#### hasActiveItem()
```php
public function hasActiveItem():bool
```
Diese Funktion gibt **true** zurück, wenn mindestens ein Unterelement mit der Eigenschaft `$isActiveItem = true` markiert ist. Ansonsten wird **false** zurückgegeben.

#### getChildItems()
```php
public function getChildItems():array
```
Diese Funktion gibt alle zugeordneten Unterelemente als Array zurück, in der gleichen Reihenfolge wie die Elemente mit der Methode `appendItem()` hinzugefügt wurden. Bei allen Elementen handelt es sich um eine Instanz vom Typ `Webcontrol\Sidebar\Item`.

Wenn noch keine Unterelemente hinzugefügt wurden, wird ein leeres Array zurückgegeben.

Wenn die Eigenschaft `isMainExpanderController = true` ist, wird ein leeres Array zurückgegeben, unabhängig davon ob Unterelemente hinzugefügt wurden, oder nicht.

#### getTitle()
```php
public function getTitle():string
```
Gibt den Namen des Steuerelements als Text zurück, der bei der Instanzierung angegeben wurde.

### Eigenschaften
#### isActiveItem
```php
public bool $isActiveItem
```
Wenn **true**, wird dieses Steuerelement in der Sidebar als aktives Element farblich hervorgehoben.

Der Standardwert ist **false**.

Diese Eigenschaft wird ignoriert, wenn die Eigenschaft `isMainExpanderController = true` ist.

#### isMainExpanderController
```php
public bool $isMainExpanderController
```
Wenn **true**, wird dieses Steuerelement dazu verwendet, die Sidebar zu vergrößern und zu verkleinern. In diesem Fall wird die Eigenschaft `linkHref` ignoriert. Damit dieses Steuerelement wirksam ist, muss die Eigenschaft `hasMainExpander = true` bei der Instanzierung der `Main`-Klasse gesetzt werden.

#### linkHref
```php
public string $linkHref
```
Diese Eigenschaft ist optional und legt eine URL für dieses Steuerelement fest. Wenn eine URL gesetzt wurde, wird der Titel dieses Elements als Link definiert.

#### symbolHref
```php
public string $symbolHref
```
Diese Eigenschaft ist optional und legt eine URL zu einer Symbol-Datei fest, das neben dem Titel angezeigt wird. Es kann jeder Dateityp verlinkt werden, der in einem `<img>`-Element verwendet werden kann. Es wird empfohlen ein Symbol mit quadratischen Abmessungen zu verwenden.