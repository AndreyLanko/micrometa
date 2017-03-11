<?php

/**
 * micrometa
 *
 * @category Jkphl
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Application\Item
 * @author Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright Copyright © 2017 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

/***********************************************************************************
 *  The MIT License (MIT)
 *
 *  Copyright © 2017 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of
 *  this software and associated documentation files (the "Software"), to deal in
 *  the Software without restriction, including without limitation the rights to
 *  use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 *  the Software, and to permit persons to whom the Software is furnished to do so,
 *  subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 *  COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 *  IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 *  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 ***********************************************************************************/

namespace Jkphl\Micrometa\Application\Item;

/**
 * Item
 *
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Application
 */
class Item extends \Jkphl\Micrometa\Domain\Item\Item implements ItemInterface
{
    /**
     * Parser format
     *
     * @var int
     */
    protected $format;
    /**
     * Item value
     *
     * @var string
     */
    protected $value;

    /**
     * Item constructor
     *
     * @param int $format Parser format
     * @param string|array $type Item type(s)
     * @param array[] $properties Item properties
     * @param string|null $itemId Item id
     * @param string|null $value Item value
     */
    public function __construct($format, $type, array $properties = [], $itemId = null, $value = null)
    {
        $this->format = $format;
        $this->value = $value;
        parent::__construct($type, $properties, $itemId);
    }

    /**
     * Return the parser format
     *
     * @return int Parser format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Return the item value
     *
     * @return string Item value
     */
    public function getValue()
    {
        return $this->value;
    }
}
