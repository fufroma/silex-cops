<?php
/*
 * This file is part of Silex Cops. Licensed under WTFPL
 *
 * (c) Mathieu Duplouy <mathieu.duplouy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cops\Model\BookFile;

use Cops\Model\Common;
use Cops\Model\BookFile\BookFileInterface;

/**
 * Book file abstract class
 *
 * @author Mathieu Duplouy <mathieu.duplouy@gmail.com>
 */
abstract class BookFileAbstract extends Common implements BookFileInterface
{
    /**
     * Bookfile format
     * @var string
     */
    protected $format;

    /**
     * File size in bytes
     * @var int
     */
    protected $uncompressedSize = 0;

    /**
     * File name without extension
     * @var string
     */
    protected $name;

    /**
     * File storage directory
     * @var string
     */
    protected $directory;

    abstract public function getFilePath();

    /**
     * Get file name with extension
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->name.'.'.strtolower($this->format);
    }
}