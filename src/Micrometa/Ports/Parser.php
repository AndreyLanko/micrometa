<?php

/**
 * micrometa
 *
 * @category Jkphl
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Ports
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

namespace Jkphl\Micrometa\Ports;

use Jkphl\Micrometa\Ports\Item\Item;
use Jkphl\Micrometa\Ports\Item\ItemInterface;
use Jkphl\Micrometa\Ports\Rel\Alternate;
use Jkphl\Micrometa\Ports\Rel\AlternateInterface;
use Jkphl\Micrometa\Ports\Rel\Rel;
use Jkphl\Micrometa\Ports\Rel\RelInterface;

/**
 * Parser
 *
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Ports
 */
class Parser
{
    /**
     * Document URL
     *
     * @var string
     */
    protected $url;
    /**
     * Source code
     *
     * @var string
     */
    protected $source;
    /**
     * Micro information formats
     *
     * @var int
     */
    protected $formats;

    /**
     * Parser constructor
     *
     * @param string $url Document URL
     * @param string $source Document source
     * @param int $formats Micro information formats to extract
     * @api
     */
    public function __construct($url, $source = null, $formats = null)
    {
        $this->url = $url;
        $this->source = $source;
        $this->formats = $formats;
    }

    /**
     * Return an object representation of the micro information items
     *
     * @return \stdClass Micro information items
     * @api
     */
    public function toObject()
    {
        return new \stdClass();
    }

    /**
     * Return a JSON representation of the micro information items
     *
     * @return string Micro information items
     * @api
     */
    public function toJson()
    {
        return json_encode(new \stdClass());
    }

    /**
     * Return all items, optionally of particular types
     *
     * @param array ...$types Item types
     * @return array Items matching the requested types
     * @api
     */
    public function items(...$types)
    {
        return [];
    }

    /**
     * Return the first item, optionally of particular types
     *
     * @param array ...$types Item types
     * @return ItemInterface Item
     * @api
     */
    public function item(...$types)
    {
        return new Item();
    }

    /**
     * Return all rel=* declaration groups
     *
     * @return RelInterface[] Rel=* declaration groups
     * @api
     */
    public function rels()
    {
        return [];
    }

    /**
     * Return all rel declarations of a particular type
     *
     * @param string $rel Rel type
     * @param int|null $index Optional: particular index
     * @return RelInterface|RelInterface[] Single rel=* declaration or list of particular rel declarations
     * @api
     */
    public function rel($rel, $index = null)
    {
        return new Rel();
    }

    /**
     * Return all alternate resources
     *
     * @return AlternateInterface[] Alternate resources
     * @api
     */
    public function alternates()
    {
        return [];
    }

    /**
     * Return the alternate resource of a particular type
     *
     * @param string $type Alternate representation type
     * @return AlternateInterface|null Alternate resource
     * @api
     */
    public function alternate($type)
    {
        return new Alternate();
    }
}
