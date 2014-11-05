<?php
namespace Mouf\Integration\Joomla\Moufla;

use Mouf\Html\Utils\WebLibraryManager\WebLibrary;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryInterface;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryRendererInterface;

/**
 * The DefaultWebLibraryRenderer class is the default implementation of the WebLibraryRendererInterface interface
 *
 * <p>It is in charge of "renderint" the HTML of a web library.</p>
 * <p>A web library can be made of:</p>
 * <ul>
 * 	<li>CSS files</li>
 * 	<li>Javascript files</li>
 * 	<li>Any other additional scripts.</li>
 * </ul>
 *
 * <p>For performance purpose, CSS files should be rendered first, then JS files.
 * This is why this class has a toCssHtml and toJsHtml method instead of only one toHtml method.</p>
 *
 * @author Guillaume Van Der Putte
 * @Component
 */
class JoomlaWebLibraryRenderer implements WebLibraryRendererInterface {

    /**
     * Renders the CSS part of a web library.
     *
     * @param WebLibrary $webLibrary
     */
    public function toCssHtml(WebLibraryInterface $webLibrary) {
        $files = $webLibrary->getCssFiles();
        if ($files) {
            foreach ($files as $file) {
                if(strpos($file, 'http://') === false && strpos($file, 'https://') === false && strpos($file, '/') !== 0) {
                    $url = ROOT_URL.$file;
                } else {
                    $url = $file;
                }
                $document = \JFactory::getDocument();
                $document->addStyleSheet(htmlspecialchars($url, ENT_QUOTES));
            }
        }
    }

    /**
     * Renders the JS part of a web library.
     *
     * @param WebLibrary $webLibrary
     */
    public function toJsHtml(WebLibraryInterface $webLibrary) {
        $files = $webLibrary->getJsFiles();
        if ($files) {
            foreach ($files as $file) {
                if(strpos($file, 'http://') === false && strpos($file, 'https://') === false && strpos($file, '/') !== 0) {
                    $url = ROOT_URL.$file;
                } else {
                    $url = $file;
                }
                $document = \JFactory::getDocument();
                $document->addScript(htmlspecialchars($url, ENT_QUOTES));
            }
        }

    }

    /**
     * Renders any additional HTML that should be outputed below the JS and CSS part.
     *
     * @param WebLibrary $webLibrary
     */
    public function toAdditionalHtml(WebLibraryInterface $webLibrary) {
        return "";
    }
}