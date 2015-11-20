<?php

namespace Mouf\Integration\Joomla\Moufla;

use Mouf\Actions\InstallUtils;
use Mouf\Html\Renderer\ChainableRendererInterface;
use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;

/**
 * A installer class that install Moufla for route.
 */
class MouflaInstaller implements PackageInstallerInterface {

    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager) {
        $moufManager = MoufManager::getMoufManager();

        // Provide a defaultWebLibraryRenderer adapted to Joomla
        if ($moufManager->instanceExists("defaultWebLibraryRenderer")) {
            // Let's remove the default defaultWebLibraryRenderer :)
            $moufManager->removeComponent("defaultWebLibraryRenderer");
        }

        // Let's create instances.
        $splashDefaultRouter = InstallUtils::getOrCreateInstance('splashDefaultRouter', 'Mouf\\Mvc\\Splash\\Routers\\SplashDefaultRouter', $moufManager);
        $splashCacheApc = InstallUtils::getOrCreateInstance('splashCacheApc', 'Mouf\\Utils\\Cache\\ApcCache', $moufManager);
        $splashCacheFile = InstallUtils::getOrCreateInstance('splashCacheFile', 'Mouf\\Utils\\Cache\\FileCache', $moufManager);
        $joomlaTemplate = InstallUtils::getOrCreateInstance('joomlaTemplate', 'Mouf\\Integration\\Joomla\\Moufla\\JoomlaTemplate', $moufManager);
        $content_block = InstallUtils::getOrCreateInstance('block.content', 'Mouf\\Html\\HtmlElement\\HtmlBlock', $moufManager);
        $moufExplorerUrlProvider = InstallUtils::getOrCreateInstance('moufExplorerUrlProvider', 'Mouf\\Mvc\\Splash\\Services\\MoufExplorerUrlProvider', $moufManager);
        $splashMiddleware = InstallUtils::getOrCreateInstance('splashMiddleware', 'Mouf\\Mvc\\Splash\\SplashMiddleware', $moufManager);
        $anonymousRouter = $moufManager->createInstance('Mouf\\Mvc\\Splash\\Routers\\Router');

        // Let's bind instances together.
        if (!$joomlaTemplate->getSetterProperty('webLibraryManager')->isValueSet()){
            $joomlaTemplate->getSetterProperty('webLibraryManager')->setValue($moufManager->getInstanceDescriptor("defaultWebLibraryManager"));
        }
        if (!$joomlaTemplate->getSetterProperty('setContent')->isValueSet()){
            $joomlaTemplate->getSetterProperty('setContent')->setValue($content_block);
        }
        if (!$splashDefaultRouter->getConstructorArgumentProperty('routeProviders')->isValueSet()) {
            $splashDefaultRouter->getConstructorArgumentProperty('routeProviders')->setValue($moufExplorerUrlProvider);
        }
        if (!$splashDefaultRouter->getConstructorArgumentProperty('cacheService')->isValueSet()) {
            $splashDefaultRouter->getConstructorArgumentProperty('cacheService')->setValue($splashCacheApc);
        }
        if (!$splashCacheApc->getPublicFieldProperty('fallback')->isValueSet()) {
            $splashCacheApc->getPublicFieldProperty('fallback')->setValue($splashCacheFile);
        }
        if (!$splashCacheFile->getPublicFieldProperty('prefix')->isValueSet()) {
            $splashCacheFile->getPublicFieldProperty('prefix')->setValue('SECRET');
            $splashCacheFile->getPublicFieldProperty('prefix')->setOrigin("config");
        }
        if (!$splashCacheFile->getPublicFieldProperty('cacheDirectory')->isValueSet()) {
            $splashCacheFile->getPublicFieldProperty('cacheDirectory')->setValue('splashCache/');
        }
        if (!$splashMiddleware->getConstructorArgumentProperty('routers')->isValueSet()) {
            $splashMiddleware->getConstructorArgumentProperty('routers')->setValue(array(0 => $anonymousRouter, ));
        }
        $anonymousRouter->getConstructorArgumentProperty('middleware')->setValue($splashDefaultRouter);


        $joomlaRenderer = InstallUtils::getOrCreateInstance('joomlaRenderer', 'Mouf\\Html\\Renderer\\FileBasedRenderer', $moufManager);
        $joomlaRenderer->getProperty('directory')->setValue('vendor/mouf/integration.joomla.moufla/src/templates');
        $joomlaRenderer->getProperty('cacheService')->setValue($moufManager->getInstanceDescriptor('rendererCacheService'));
        $joomlaRenderer->getProperty('type')->setValue(ChainableRendererInterface::TYPE_TEMPLATE);
        $joomlaRenderer->getProperty('priority')->setValue(0);
        $joomlaTemplate->getProperty('templateRenderer')->setValue($joomlaRenderer);
        $joomlaTemplate->getProperty('defaultRenderer')->setValue($moufManager->getInstanceDescriptor('defaultRenderer'));

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
