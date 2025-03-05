<?php
namespace Webcontrol\Sidebar {
    
    /**
     * This class provides properties and methods for an instance of the sidebar.
     */
    class Main {
        /** The *ID*-name which will be prepended and used for all *input:checkbox*-elements. */
        private string $IDprefix = "";

        /** The HTML-ID of the main &lt;input: checkbox&gt;. The ID will be defined during *__construct()*. */
        private string $IDMainExpander = "";

        /** The HTML-element name which will contain the sidebar, for eg: *nav*. */
        private string $mainElementName = "";

        /** *True*, if the sidebar could be collapsed and expanded. */
        private bool $hasMainExpander = false;

        /** This array contains items of the first layer. All items schould be an instance of the *item*-class. */
        private array $mainItems = array();


        /** *True*, if the sidebar should be shown expanded on page startup. 
         * This property has only an effect, if the property *hasMainExpander* is set *true*.
         */
        public bool $showSidebarExpanded = false;

        /** *True*, if sub lists of the sidebar should be shown expanded on page startup.
         * The property *isActiveItem* should be set *true* for one item in the *mainItems*-array.
         */
        public bool $showActiveElementExpanded = false;

                
        /**
         * This method will create an instance of the main sidebar-class.
         *
         * @param  string $mainElementName The HTML-element name, which will contain the sidebar, e.g. &lt;nav&gt;.
         * @param  string $IDprefix This name will be internally used as prefix to assign an ID to &lt;input&gt;-elements.
         * @param  bool $hasMainExpander *True*, if the sidebar could be collapsed and expanded.
         * @return void
         */
        public function __construct(string $mainElementName, string $IDprefix, bool $hasMainExpander = true) {

            $this->hasMainExpander = $hasMainExpander;

            if ($mainElementName) {
                $this->mainElementName = $mainElementName;

            } else {
                throw new \InvalidArgumentException("A HTML-Element name is required for initialization of the sidebar");

            }

            if ($IDprefix) {
                $this->IDprefix = $IDprefix;
                $this->IDMainExpander = $IDprefix . "MainExp";

            } else {
                throw new \InvalidArgumentException("An ID-Prefix is required for initialization of the sidebar");
                
            }

        }
                
        /**
         * This method will append an item to the internal list.
         *
         * @param  Item $NewItem An instance of Item, which should be appended to the end of the internal list.
         * @return void
         */
        public function appendItem(Item $NewItem):void {
            $this->mainItems[] = $NewItem;
        }
        
        /**
         * This method will generate the HTML-code for this sidebar instance.
         * All items of the list in this instance and also of each list in sub-items will be iterated in the same order, as the items was appended.
         * 
         * Recommended usage: *echo(instance-name->generateHTML())*
         *
         * @return string
         */
        public function generateHTML():string {
            // XML-Dokument erzeugen
            $Doc = new \DOMDocument("1.0", "UTF-8");

            // Wurzelelement erstellen
            $DocRoot = $Doc->createElement($this->mainElementName);
            $DocRoot->setAttribute("class", "WebCtlSidebar");
            $Doc->appendChild($DocRoot);

            // Hauptexpander-Checkbox einfügen, wenn Eigenschaft aktiviert
            if ($this->hasMainExpander) {
                $MainExp = $Doc->createElement("input");
                $MainExp->setAttribute("type", "checkbox");
                $MainExp->setAttribute("id", $this->IDMainExpander);

                // optional als checked markieren, wenn Eigenschaft aktiviert
                if ($this->showSidebarExpanded) {
                    $MainExp->setAttribute("checked", "");
                }

                $DocRoot->appendChild($MainExp);

            }

            // Hauptliste erstellen
            $MainUl = $Doc->createElement("ul");
            
            // "mainItems"-Array durchlaufen
            for ($i = 0; $i < \count($this->mainItems); $i++) {
                
                $MainLi = $this->generateItemElement($Doc, $this->mainItems[$i]);

                $MainUl->appendChild($MainLi);
            }

            // Hauptliste dem Wurzel-Element hinzufügen
            $DocRoot->appendChild($MainUl);

            // Dokument-Inhalt zurückgeben
            return $Doc->saveHTML($DocRoot) . "\n";
        }

        /**
         * This method will generate a &lt;label&gt;-element, which can act as hit area to collapse the sidebar.
         * Usually used for mobile versions.
         * It is recommended to place this element in HTML-code as sibling next to the sidebar element.
         *
         * @return string
         */
        public function generateResetElementHTML():string {
            // XML-Dokument erzeugen
            $Doc = new \DOMDocument("1.0", "UTF-8");

            // Wurzelelement erstellen
            $DocRoot = $Doc->createElement("label");
            $DocRoot->setAttribute("class", "WebCtlSidebarReset");
            $DocRoot->setAttribute("for", $this->IDMainExpander);
            $Doc->appendChild($DocRoot);
            
            // Element-Inhalt zurückgeben
            return $Doc->saveHTML($DocRoot) . "\n";
        }
        
        /**
         * This method will generate a DOMElement instance according to the properties given in the ItemData.
         * The generated DOMElement can be used to build the sidebar.
         *
         * @param  DOMDocument $Doc The DOMDocument-instance to which the created DOMElement will be appended afterwards.
         * @param  Item $ItemData An instance of Item with definition properties which will be used to generate this DOMElement instance.
         * @return DOMElement
         */
        private function generateItemElement(\DOMDocument &$Doc, Item $ItemData):\DOMElement {
            // Gibt es Unterelemente? Wenn ja, ID für das Checkbox Element festlegen
            $hasChildItems = false;
            $CheckboxID = "";
            static $CheckboxIDCounter = 0;
            if (\count($ItemData->getChildItems()) > 0) {
                $hasChildItems = true;
                $CheckboxID = $this->IDprefix . "ItemExp$CheckboxIDCounter";
                $CheckboxIDCounter++;
            }

            // Listenelement erstellen
            $xLi = $Doc->createElement("li");

            // Klassenattribut setzen, falls dieses Element die Sidebar öffnen kann
            if ($ItemData->isMainExpanderController) {
                $xLi->setAttribute("class", "WebCtlSidebarItemMenu");
                // In diesem Fall auch die CheckboxID überschreiben
                $CheckboxID = $this->IDMainExpander;
            }

            // Erstes Element ist das Expander-Symbol
            // Nur verfügbar, wenn es Unterelemente gibt
            if ($hasChildItems) {
                $xLabel = $Doc->createElement("label");
                $xLabel->setAttribute("for", $CheckboxID);
                $xLabel->setAttribute("class", "WebCtlSidebarItemExpander");
                
                $xExpSymbol = $this->generateExpanderSymbol($Doc);
                $xLabel->appendChild($xExpSymbol);
                $xLi->appendChild($xLabel);
            }

            // Zweites Element der Titel
            if ($ItemData->isMainExpanderController) {

                // Wenn die Eigenschaft "isMainExpanderController" gesetzt ist, soll der Titel in ein <label>-Element erstellt werden
                $xTitleContainer = $Doc->createElement("label");
                $xTitleContainer->setAttribute("for", $CheckboxID);
                $xTitleContainer->setAttribute("class", "WebCtlSidebarItemTitle");

                    $xTitle = $Doc->createElement("p", $ItemData->getTitle());
                $xTitleContainer->appendChild($xTitle);
                $xLi->appendChild($xTitleContainer);

            } elseif ($ItemData->linkHref) {
                
                // Prüfen, ob das aktuelle Element als aktiv markiert ist. In dem Fall die zusätzliche Klasse für das <a>-Element angeben.
                $xTitleContainerClass = "WebCtlSidebarItemTitle";
                if ($ItemData->isActiveItem) {
                    $xTitleContainerClass .= " WebCtlSidebarItemActive";
                }

                // Wenn ein Link für das Element angegeben wurde, soll der Titel in ein <a>-Element erstellt werden
                $xTitleContainer = $Doc->createElement("a");
                $xTitleContainer->setAttribute("href", $ItemData->linkHref);
                $xTitleContainer->setAttribute("class", $xTitleContainerClass);
                $xTitleContainer->setAttribute("title", $ItemData->getTitle());

                    $xTitle = $Doc->createElement("p", $ItemData->getTitle());
                $xTitleContainer->appendChild($xTitle);
                $xLi->appendChild($xTitleContainer);

            } else {
                
                // Prüfen, ob das aktuelle Element als aktiv markiert ist. In dem Fall die zusätzliche Klasse für das <a>-Element angeben.
                $xTitleContainerClass = "WebCtlSidebarItemTitle";
                if ($ItemData->isActiveItem) {
                    $xTitleContainerClass .= " WebCtlSidebarItemActive";
                }

                // Ansonsten den Titel in einem <div>-Element ausgeben
                $xTitleContainer = $Doc->createElement("div");
                $xTitleContainer->setAttribute("class", $xTitleContainerClass);
                $xTitleContainer->setAttribute("title", $ItemData->getTitle());

                    $xTitle = $Doc->createElement("p", $ItemData->getTitle());
                $xTitleContainer->appendChild($xTitle);
                $xLi->appendChild($xTitleContainer);
            }

            // Drittes Element das Symbol, nur wenn Symbol angegeben wurde
            if ($ItemData->symbolHref && $ItemData->isMainExpanderController) {

                // Wenn die Eigenschaft"isMainExpanderController" gesetzt ist, soll das Symbol in ein <label>-Element erstellt werden
                $xSymbolContainer = $Doc->createElement("label");
                $xSymbolContainer->setAttribute("for", $CheckboxID);
                $xSymbolContainer->setAttribute("class", "WebCtlSidebarItemSymbol");
                
                    $xSymbol = $Doc->createElement("img");
                    $xSymbol->setAttribute("src", $ItemData->symbolHref);
                    $xSymbol->setAttribute("alt", $ItemData->getTitle());
                $xSymbolContainer->appendChild($xSymbol);
                $xLi->appendChild($xSymbolContainer);

            } elseif ($ItemData->symbolHref && $ItemData->linkHref) {

                // Falls ein Link Ziel angegeben wurde, das Symbol in einem <a>-Element erstellen
                $xSymbolContainer = $Doc->createElement("a");
                $xSymbolContainer->setAttribute("href", $ItemData->linkHref);
                $xSymbolContainer->setAttribute("class", "WebCtlSidebarItemSymbol");
                $xSymbolContainer->setAttribute("title", $ItemData->getTitle());

                    $xSymbol = $Doc->createElement("img");
                    $xSymbol->setAttribute("src", $ItemData->symbolHref);
                    $xSymbol->setAttribute("alt", $ItemData->getTitle());
                $xSymbolContainer->appendChild($xSymbol);
                $xLi->appendChild($xSymbolContainer);

            } elseif ($ItemData->symbolHref) {

                // Ansonsten das Symbol in ein <div>-Element erstellen
                $xSymbolContainer = $Doc->createElement("div");
                $xSymbolContainer->setAttribute("class", "WebCtlSidebarItemSymbol");
                $xSymbolContainer->setAttribute("title", $ItemData->getTitle());

                    $xSymbol = $Doc->createElement("img");
                    $xSymbol->setAttribute("src", $ItemData->symbolHref);
                    $xSymbol->setAttribute("alt", $ItemData->getTitle());
                $xSymbolContainer->appendChild($xSymbol);
                $xLi->appendChild($xSymbolContainer);

            }

            // Viertes Element input:checkbox, wenn Unterelemente existieren
            if ($hasChildItems) {
                $xCheckbox = $Doc->createElement("input");
                $xCheckbox->setAttribute("type", "checkbox");
                $xCheckbox->setAttribute("id", $CheckboxID);

                // Falls dieses Element aktive Unterelemente enthält und die Eigenschaft "showActiveElementExpanded" aktiviert ist --> Checkbox aktivieren
                if ($this->showActiveElementExpanded && $ItemData->hasActiveItem()) {
                    $xCheckbox->setAttribute("checked", "");
                }

                $xLi->appendChild($xCheckbox);
            }

            // Fünftes Element Unterliste <ul>, wenn Unterelemente existieren
            if ($hasChildItems) {
                $xSubList = $Doc->createElement("ul");

                // Rekursiv die Unterelemente durchlaufen und an die Unterliste anfügen
                for ($i=0; $i < \count($ItemData->getChildItems()); $i++) { 
                    $xSubListItem = $this->generateItemElement($Doc, $ItemData->getChildItems()[$i]);
                    $xSubList->appendChild($xSubListItem);
                }

                $xLi->appendChild($xSubList);
            }

            return $xLi;
        }
        
        /**
         * This method will create a predefined symbol as &lt;svg&gt;-element.
         *
         * @param  DOMDocument $Doc The DOMDocument-instance to which the created &lt;svg&gt;-element will be appended afterwards.
         * @return DOMElement
         */
        private function generateExpanderSymbol(\DOMDocument &$Doc):\DOMElement {
            $SvgNS = "http://www.w3.org/2000/svg";
            $xSvg = $Doc->createElement("svg");
            $xSvg->setAttribute("xmlns", $SvgNS);
            $xSvg->setAttribute("viewbox", "0 0 50 50");
                $xCircle = $Doc->createElement("circle");
                $xCircle->setAttribute("class", "WebCtlIcon");
                $xCircle->setAttribute("cx", "25");
                $xCircle->setAttribute("cy", "25");
                $xCircle->setAttribute("r", "23");
                $xCircle->setAttribute("stroke-width", "3");
                $xCircle->setAttribute("fill", "none");
            $xSvg->appendChild($xCircle);

                $xLine = $Doc->createElement("line");
                $xLine->setAttribute("class", "WebCtlIcon HideExpanded");
                $xLine->setAttribute("x1", "25");
                $xLine->setAttribute("x2", "25");
                $xLine->setAttribute("y1", "10");
                $xLine->setAttribute("y2", "40");
                $xLine->setAttribute("stroke-width", "5");
            $xSvg->appendChild($xLine);

                $xLine = $Doc->createElement("line");
                $xLine->setAttribute("class", "WebCtlIcon");
                $xLine->setAttribute("x1", "10");
                $xLine->setAttribute("x2", "40");
                $xLine->setAttribute("y1", "25");
                $xLine->setAttribute("y2", "25");
                $xLine->setAttribute("stroke-width", "5");
            $xSvg->appendChild($xLine);

            return $xSvg;
        }
    }
    
    /**
     * This class provides properties and methods for an item of the sidebar.
     */
    class Item {
        /** The title of the item. The name will be shown in the sidebar. */
        private string $title = "";

        /** This array contains associated child items. The child items will be an instance of *Item*. */
        private array $childItems = array();

        /** *True*, if the property *isActiveItem* is true of any associated child item. */
        private bool $_hasActiveItem = false;

        /** A valid URL (relative or absolute). If this property is set, the *title* will be embedded in an &lt;a&gt;-element. */
        public string $linkHref = "";

        /** A valid URL (relative or absolute) to an image file.
         * Every MIME-type which is also accepted as source for an &lt;img&gt;-element can be used.
         * If the property is set, the symbol will be shown next to the *title*-element. */
        public string $symbolHref = "";

        /** *True*, if this item should be highlighted as actual selected item.
         * This property will be ignored, if the property *isMainExpanderController* is *true*.
         */
        public bool $isActiveItem = false;

        /** *True*, if this item should control the visibility of the sidebar itself.
         * If *true* the property *linkHref* will be ignored.
         */
        public bool $isMainExpanderController = false;
        
        /**
         * This method will create a new item instance which can be associated to the main-instance of the sidebar, or as sub-item to another item instance.
         *
         * @param  string $title The title name of the new item. This name will be shown in the sidebar.
         * @return void
         */
        public function __construct(string $title) {
            if ($title) {
                $this->title = $title;

            } else {
                throw new \InvalidArgumentException("A title is required for the Sidebar-Item");

            }
        }
        
        /**
         * This method will append another Item-instance to the internal list.
         *
         * @param  Item $NewItem An instance of Item, which should be appended to the end of the internal list.
         * @return void
         */
        public function appendItem(Item $NewItem):void {
            // Falls das anzufügende Element ein aktives Element ist, oder deren Auflistung ein aktives Element enthält die Eigenschaft hasActiveElement setzen
            if ($NewItem->isActiveItem || $NewItem->hasActiveItem()) {
                $this->_hasActiveItem = true;
            }

            $this->childItems[] = $NewItem;
        }
        
        /**
         * Returns the title name of this instance.
         *
         * @return string
         */
        public function getTitle():string {
            return $this->title;
        }
        
        /** Returns an array of all associated Item-instances of this Item-instance.
         * If the property *isMainExpanderController* is *true* the returned array will be empty.
         *
         * @return array
         */
        public function getChildItems():array {
            // Wenn das Element als "isMainExpanderController" definiert ist, dürfen keine Unterelemente enthalten sein
            if ($this->isMainExpanderController) {
                return array();
            } else {
                return $this->childItems;
            }
        }
        
        /**
         * Returns *true*, if the property *isActiveItem* of minimum one associated child-item is *true*.
         *
         * @return bool
         */
        public function hasActiveItem():bool {
            return $this->_hasActiveItem;
        }
    }
}
?>