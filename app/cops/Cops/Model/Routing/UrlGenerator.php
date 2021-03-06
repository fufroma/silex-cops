<?php
/*
 * This file is part of Silex Cops. Licensed under WTFPL
 *
 * (c) Mathieu Duplouy <mathieu.duplouy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cops\Model\Routing;

use Silex\Application as BaseApplication;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Psr\Log\LoggerInterface;

/**
 * Overrided the class to be able to deactive url rewriting
 */
class UrlGenerator extends \Symfony\Component\Routing\Generator\UrlGenerator
{
    /**
     * Application instance
     * @var \Silex\Application
     */
    private $app;

    /**
     * @inheritDoc
     */
    public function __construct(RouteCollection $routes, RequestContext $context, LoggerInterface $logger = null, BaseApplication $app)
    {
        parent::__construct($routes, $context, $logger);
        $this->app = $app;
    }

    /**
     * @inheritDoc
     */
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, array $requiredSchemes = array())
    {
        $url = parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);

        // @codeCoverageIgnoreStart
        // Check for mod_rewrite config then prepend script name to url
        if ($this->app['config']->getValue('use_rewrite') !== true && php_sapi_name() != 'cli') {
            $url = $this->addScriptNameToUrl($url);
        }
        // @codeCoverageIgnoreEnd
        return $url;
    }

    /**
     * Add script name to url when not using rewrite
     *
     * @param  string $url
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    private function addScriptNameToUrl($url)
    {
        $scriptName = $this->app['request']->getScriptName();

        if (strpos($url, $scriptName) === false) {
            $url = $this->app['request']->getBasePath().DS.basename($scriptName).$url;
        }
        return $url;
    }
}