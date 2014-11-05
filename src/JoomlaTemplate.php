<?php

namespace Mouf\Integration\Joomla\Moufla;


use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryManager;

class JoomlaTemplate implements TemplateInterface {
    /**
     * The main content block of the page.
     * @var HtmlBlock
     */
    protected $content;

    /**
     * @var boolean if the template has been called or not
     */
    private $templateCalled;

    /**
     * The title of the HTML page
     *
     * @var string
     */
    private $title;

    /**
     * The weblibrarymanager is in charge of handing JS files.
     *
     * @var WebLibraryManagerInterface
     */
    private $webLibraryManager;

    /**
     * @param HtmlBlock $content
     */
    public function __construct($content) {
        $this->templateCalled = false;
        $this->content = $content;
    }

    /**
     * Sets the title for the HTML page
     * @param string $title
     * @return TemplateInterface
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this->title;
    }

    /**
     * Returns the WebLibraryManager object that can be used to add JS/CSS files to this template.
     *
     * @return WebLibraryManager
     */
    public function getWebLibraryManager() {
        return $this->webLibraryManager;
    }

    /**
     * Sets the web library manager for this template.
     *
     * @Property
     * @param WebLibraryManager $webLibraryManager
     * @return JoomlaTemplate
     */
    public function setWebLibraryManager(WebLibraryManager $webLibraryManager) {
        $this->webLibraryManager = $webLibraryManager;
        return $this;
    }

    /**
     * Renders the object in HTML.
     *
     * The Html is echoed directly into the output.
     */
    function toHtml() {
        $this->templateCalled = true;
        $this->webLibraryManager->toHtml();
        $this->content->toHtml();
    }

    /**
     * @return bool if the template has been called or not
     */
    public function getTemplateCalled() {
        return $this->templateCalled;
    }
} 