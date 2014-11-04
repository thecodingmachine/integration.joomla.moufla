<?php

namespace Mouf\Integration\Joomla\Moufla;


use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryManager;

class JoomlaTemplate extends TemplateInterface {
    /**
     * The main content block of the page.
     * @var HtmlBlock
     */
    private $content;

    /**
     * @var boolean if the template has been called or not
     */
    private $templateCalled;

    /**
     * @param $content
     */
    public function __construct($content) {
       $this->templateCalled = false;
        $this->content = $content;
    }

    /**
     * Sets the title for the HTML page
     * @param $title
     * @return TemplateInterface
     */
    public function setTitle($title) {
        return $this;
    }

    /**
     * Returns the WebLibraryManager object that can be used to add JS/CSS files to this template.
     *
     * @return WebLibraryManager
     */
    public function getWebLibraryManager() {

    }

    /**
     * Renders the object in HTML.
     * 
     * The Html is echoed directly into the output.
     */
    function toHtml() {
        $this->templateCalled = true;
        $this->content->toHtml();
    }

    /**
     * @return bool if the template has been called or not
     */
    public function getTemplateCalled() {
        return $this->templateCalled;
    }
} 