<?php
    chdir("..");
    try {
        require_once realpath("./../modules/Webcontrol_Sidebar.php");
    } catch (Error $e) {
        error_log("Fehler in Datei " . __FILE__ . " in Zeile " . __LINE__ . "\nDie notwendigen PHP-Dateien konnten nicht gefunden werden.");
        exit;
    }

    use Webcontrol\Sidebar\Main as SbMain;
    use Webcontrol\Sidebar\Item as SbItem;

    // Sidebar-Klasse initialisieren
    $NavSidebar = new SbMain("nav" ,"WebCtlNav");
    $NavSidebar->showSidebarExpanded = true;
    $NavSidebar->showActiveElementExpanded = true;

    // Menüstruktur aufbauen

    // Menü
    $NavSidebarItem = new SbItem("Menu");
    $NavSidebarItem->symbolHref = "./pic/menu.svg";
    $NavSidebarItem->isMainExpanderController = true;
    $NavSidebar->appendItem($NavSidebarItem);

    // Start
    $NavSidebarItem = new SbItem("Start");
    $NavSidebarItem->symbolHref = "./pic/home.svg";
    $NavSidebarItem->linkHref = "#";
    $NavSidebar->appendItem($NavSidebarItem);

    // Item 1
    $NavSidebarItem = new SbItem("Item 1");
    $NavSidebarItem->symbolHref = "./pic/star.svg";
    $NavSidebarItem->linkHref = "#";

        // Subitem 1
        $NavSidebarSubItem = new SbItem("Subitem 1");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";
        $NavSidebarItem->appendItem($NavSidebarSubItem);

        // Subitem 2
        $NavSidebarSubItem = new SbItem("Subitem 2");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";
        $NavSidebarItem->appendItem($NavSidebarSubItem);

        // Subitem 3
        $NavSidebarSubItem = new SbItem("Subitem 3");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";
        $NavSidebarItem->appendItem($NavSidebarSubItem);
    $NavSidebar->appendItem($NavSidebarItem);

    // Item 2
    $NavSidebarItem = new SbItem("Item 2");
    $NavSidebarItem->symbolHref = "./pic/star.svg";
    $NavSidebarItem->linkHref = "#";

        // Subitem 1
        $NavSidebarSubItem = new SbItem("Subitem 1");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";

            // New Subitem 1
            $NavSidebarSubSubItem = new SbItem("New Subitem 1");
            $NavSidebarSubSubItem->linkHref = "#";
            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

            // New Subitem 2
            $NavSidebarSubSubItem = new SbItem("New Subitem 2");
            $NavSidebarSubSubItem->linkHref = "#";
            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

            // New Subitem 3
            $NavSidebarSubSubItem = new SbItem("New Subitem 3");
            $NavSidebarSubSubItem->linkHref = "#";
            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

        $NavSidebarItem->appendItem($NavSidebarSubItem);

        // Subitem 2
        $NavSidebarSubItem = new SbItem("Subitem 2");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";
        $NavSidebarItem->appendItem($NavSidebarSubItem);

        // Subitem 3
        $NavSidebarSubItem = new SbItem("Subitem 3");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";
        $NavSidebarItem->appendItem($NavSidebarSubItem);
        
    $NavSidebar->appendItem($NavSidebarItem);

    // Item 3
    $NavSidebarItem = new SbItem("Item 3");
    $NavSidebarItem->symbolHref = "./pic/star.svg";
    $NavSidebarItem->linkHref = "#";

        // Subitem 1
        $NavSidebarSubItem = new SbItem("Subitem 1");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";
        $NavSidebarItem->appendItem($NavSidebarSubItem);

        // Subitem 2
        $NavSidebarSubItem = new SbItem("Subitem 2");
        $NavSidebarSubItem->symbolHref = "./pic/label.svg";
        $NavSidebarSubItem->linkHref = "#";

            // New Subitem 1
            $NavSidebarSubSubItem = new SbItem("New Subitem 1");
            $NavSidebarSubSubItem->symbolHref = "./pic/label.svg";
            $NavSidebarSubSubItem->linkHref = "#";

                // Extralong newest new Subitem 1
                $NavSidebarExtraItem = new SbItem("Extralong newest new Subitem 1");
                $NavSidebarExtraItem->symbolHref = "./pic/label.svg";
                $NavSidebarExtraItem->linkHref = "#";
                $NavSidebarSubSubItem->appendItem($NavSidebarExtraItem);

            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

            // New Subitem 2
            $NavSidebarSubSubItem = new SbItem("New Subitem 2");
            $NavSidebarSubSubItem->symbolHref = "./pic/label.svg";
            $NavSidebarSubSubItem->linkHref = "#";
            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

            // New Subitem 3
            $NavSidebarSubSubItem = new SbItem("New Subitem 3");
            $NavSidebarSubSubItem->symbolHref = "./pic/label.svg";
            $NavSidebarSubSubItem->linkHref = "#";
            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

            // New Subitem 4
            $NavSidebarSubSubItem = new SbItem("New Subitem 4");
            $NavSidebarSubSubItem->symbolHref = "./pic/label.svg";
            // Hier kein Link
        
                // Inactive old item 123
                $NavSidebarInactiveItem = new SbItem("Inactive old item 123");
                $NavSidebarInactiveItem->symbolHref = "./pic/label.svg";
                $NavSidebarInactiveItem->linkHref = "#";
                // Aktives Element
                $NavSidebarInactiveItem->isActiveItem = true;
                $NavSidebarSubSubItem->appendItem($NavSidebarInactiveItem);

            $NavSidebarSubItem->appendItem($NavSidebarSubSubItem);

        $NavSidebarItem->appendItem($NavSidebarSubItem);

    $NavSidebar->appendItem($NavSidebarItem);
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Webcontrol PHP Sidebar Demo</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="referrer" content="no-referrer" />
        <meta name="apple-mobile-web-app-title" content="Biemann Controls" />
        <link rel="icon" type="image/x-icon" href="./favicon.ico" sizes="48x48" />
        <link rel="icon" type="image/png" href="./favicon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="./favicon/favicon.svg" sizes="any" />
        <link rel="apple-touch-icon" href="./favicon/apple-touch-icon.png" sizes="180x180" />
        <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" sizes="48x48" />
        <link rel="manifest" href="./favicon/site.webmanifest" />
        <link rel="stylesheet" type="text/css" href="./css/general.css" />
        <link rel="stylesheet" type="text/css" href="/css/Webcontrol_Sidebar.css" />
        <link rel="stylesheet" type="text/css" href="./css/navigation.css" />
    </head>
    <body>
        <?php echo($NavSidebar->generateHTML()); ?>
        <?php echo($NavSidebar->generateResetElementHTML()); ?>
        <main>
            <h1>Webcontrol PHP Sidebar Demo</h1>
        </main>
    </body>
</html>