<?php
/*
 * This file is part of Silex Cops. Licensed under WTFPL
 *
 * (c) Mathieu Duplouy <mathieu.duplouy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cops\Model\ImageProcessor;

use Cops\Model\FactoryAbstract;
use Silex\Application as BaseApplication;
use Cops\Exception\ImageProcessor\AdapterException;

/**
 * Image processor factory
 * @author Mathieu Duplouy <mathieu.duplouy@gmail.com>
 */
class ImageProcessorFactory extends FactoryAbstract
{
    /**
     * Instance types
     */
    const TYPE_GD       = 'gd';
    const TYPE_IMAGICK  = 'imagick';

    /**
     * Instance type storage
     * @var array
     */
    private $instanceTypeStorage;

    /**
     * Constructor
     *
     * @param string $processingType
     */
    public function __construct(BaseApplication $app)
    {
        parent::__construct($app);

        $this->instanceTypeStorage = array(
            self::TYPE_GD      => self::TYPE_GD,
            self::TYPE_IMAGICK => self::TYPE_IMAGICK,
        );
    }

    /**
     * Instance getter
     *
     * @return \Cops\Model\ImageProcessor\ImageProcessorInterface
     */
    public function getInstance($instance = self::TYPE_GD )
    {
        if (!isset($this->instanceTypeStorage[$instance])) {
            throw new AdapterException(
                sprintf('No model configured for the %s image processor', $instance)
            );
        }
        $className = __NAMESPACE__.'\\Adapter\\' . ucfirst(strtolower($instance));
        return new $className($this->app);
    }
}