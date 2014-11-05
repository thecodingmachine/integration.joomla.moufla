<?php

namespace Mouf\Integration\Joomla\Moufla;

use Mouf\Actions\InstallUtils;
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

        $configManager = $moufManager->getConfigManager();
        $constants = $configManager->getMergedConstants();
        if ($configManager->getConstantDefinition('SECRET') === null) {
            $configManager->registerConstant('SECRET', 'string', 'BSHVXjnWTgc5ojRHVyCB', 'A random string. It should be different for any application deployed.');
        }

        // Provide a defaultWebLibraryRenderer adapted to Joomla
        if ($moufManager->instanceExists("defaultWebLibraryRenderer")) {
            // Let's remove the default defaultWebLibraryRenderer :)
            $moufManager->removeComponent("defaultWebLibraryRenderer");
        }
        $joomlaWebLibraryRenderer = $moufManager->CreateInstance('Mouf\\Integration\\Joomla\\Moufla\\JoomlaWebLibraryRenderer');
        $joomlaWebLibraryRenderer->setName("defaultWebLibraryRenderer");

        // Let's create instances.
        $splashDefaultRouter = InstallUtils::getOrCreateInstance('splashDefaultRouter', 'Mouf\\Mvc\\Splash\\Routers\\SplashDefaultRouter', $moufManager);
        $mouflaNotFoundRouter = InstallUtils::getOrCreateInstance('mouflaNotFoundRouter', 'Mouf\\Integration\\Joomla\\Moufla\\MouflaNotFoundRouter', $moufManager);
        $splashCacheApc = InstallUtils::getOrCreateInstance('splashCacheApc', 'Mouf\\Utils\\Cache\\ApcCache', $moufManager);
        $splashCacheFile = InstallUtils::getOrCreateInstance('splashCacheFile', 'Mouf\\Utils\\Cache\\FileCache', $moufManager);
        $joomlaTemplate = InstallUtils::getOrCreateInstance('joomlaTemplate', 'Mouf\\Integration\\Joomla\\Moufla\\JoomlaTemplate', $moufManager);
        $content_block = InstallUtils::getOrCreateInstance('block.content', 'Mouf\\Html\\HtmlElement\\HtmlBlock', $moufManager);



        // Let's bind instances together.
        if (!$joomlaTemplate->getConstructorArgumentProperty('content')->isValueSet()){
            $joomlaTemplate->getConstructorArgumentProperty('setWebLibraryManager')->setValue($content_block);
        }
        if (!$joomlaTemplate->getSetterProperty('webLibraryManager')->isValueSet()){
            $joomlaTemplate->getSetterProperty('webLibraryManager')->setValue($moufManager->getInstanceDescriptor("defaultWebLibraryManager"));
        }
        if (!$splashDefaultRouter->getConstructorArgumentProperty('cacheService')->isValueSet()) {
            $splashDefaultRouter->getConstructorArgumentProperty('cacheService')->setValue($splashCacheApc);
        }
        if (!$splashDefaultRouter->getConstructorArgumentProperty('fallBackRouter')->isValueSet()) {
            $splashDefaultRouter->getConstructorArgumentProperty('fallBackRouter')->setValue($mouflaNotFoundRouter);
        }
        if (!$splashCacheApc->getPublicFieldProperty('prefix')->isValueSet()) {
            $splashCacheApc->getPublicFieldProperty('prefix')->setValue('SECRET');
            $splashCacheApc->getPublicFieldProperty('prefix')->setOrigin("config");
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

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}