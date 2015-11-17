<?php

namespace Mouf\Integration\Joomla\Moufla;


use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\Html\Template\BaseTemplate\BaseTemplate;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryManager;

class JoomlaTemplate extends BaseTemplate {

    /**
     * @var boolean if the template has been called or not
     */
    private $templateCalled;

    /**
     * Tells Joomla that the content should be rendered into the theme.
     * This does actually not call any real rendering.
     * It just sets a flag to inform Drupal that rendering should be performed (instead of going the Ajax way).
     *
     * The toHtml() name is kept so that we can keep the same code between Splash and Druplash.
     */
    public function toHtml()
    {
        $this->templateCalled = true;
        $this->getDefaultRenderer()->setTemplateRenderer($this->getTemplateRenderer());
        $this->getWebLibraryManager()->toHtml();
        $this->content->toHtml();
    }

    /**
     * @return bool if the template has been called or not
     */
    public function getTemplateCalled() {
        return $this->templateCalled;
    }
}
