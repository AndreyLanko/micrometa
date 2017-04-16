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

namespace Jkphl\Micrometa\Ports\Item;

use Jkphl\Micrometa\Application\Item\ItemInterface as ApplicationItemInterface;
use Jkphl\Micrometa\Domain\Exceptions\OutOfBoundsException as DomainOutOfBoundsException;
use Jkphl\Micrometa\Infrastructure\Factory\ItemFactory;
use Jkphl\Micrometa\Infrastructure\Factory\ProfiledNamesFactory;
use Jkphl\Micrometa\Infrastructure\Parser\ProfiledNamesList;
use Jkphl\Micrometa\Ports\Exceptions\InvalidArgumentException;
use Jkphl\Micrometa\Ports\Exceptions\OutOfBoundsException;

/**
 * Micro information item
 *
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Ports
 */
class Item extends AbstractItemList implements ItemInterface
{
    /**
     * Application item
     *
     * @var ApplicationItemInterface
     */
    protected $item;

    /**
     * Item constructor
     *
     * @param ApplicationItemInterface $item Application item
     */
    public function __construct(ApplicationItemInterface $item)
    {
        $this->item = $item;
        parent::__construct(ItemFactory::createFromParserResult($this->item->getChildren()));
    }

    /**
     * Get the first value of an item property
     *
     * @param string $name Item property name
     * @return string First value of an item property
     * @api
     */
    public function __get($name)
    {
        return $this->getProperty($name, null, 0);
    }

    /**
     * Get a single property (value)
     *
     * @param string $name Property name
     * @param string $profile Property profile
     * @param int $index Property value index
     * @return array|string|ItemInterface Property value(s)
     * @throws OutOfBoundsException If the property name is unknown
     * @throws OutOfBoundsException If the property value index is out of bounds
     * @api
     */
    public function getProperty($name, $profile = null, $index = null)
    {
        try {
            $propertyValues = $this->item->getProperty($name, $profile);
        } catch (DomainOutOfBoundsException $e) {
            throw new OutOfBoundsException($e->getMessage(), $e->getCode());
        }

        // If all property values should be returned
        if ($index === null) {
            return $propertyValues;
        }

        // If the property value index is out of bounds
        if (!isset($propertyValues[$index])) {
            throw new OutOfBoundsException(
                sprintf(OutOfBoundsException::INVALID_PROPERTY_VALUE_INDEX_STR, $index),
                OutOfBoundsException::INVALID_PROPERTY_VALUE_INDEX
            );
        }

        return $propertyValues[$index];
    }

    /**
     * Return whether the item is of a particular type (or contained in a list of types)
     *
     * The item type(s) can be specified in a variety of ways, @see ProfiledNamesFactory::createFromArguments()
     *
     * @param string $name Name
     * @param string|null $profile Profile
     * @return boolean Item type is contained in the list of types
     * @api
     */
    public function isOfType($name, $profile = null)
    {
        /** @var ProfiledNamesList $types */
        $types = ProfiledNamesFactory::createFromArguments(func_get_args());

        // Run through all item types
        /** @var \stdClass $itemType */
        foreach ($this->item->getType() as $itemType) {
            // Run through all query types
            /** @var \stdClass $queryType */
            foreach ($types as $queryType) {
                if (($queryType->name == $itemType->name) &&
                    (($queryType->profile === null) ? true : ($queryType->profile == $itemType->profile))
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get all values of the first available property in a stack
     *
     * The property stack can be specified in a variety of ways, @see ProfiledNamesFactory::createFromArguments()
     *
     * @param string $name Name
     * @param string $profile Profile
     * @return array Property values
     * @throws InvalidArgumentException If no property name was given
     * @throws OutOfBoundsException If none of the requested properties is known
     * @api
     */
    public function getFirstProperty($name, $profile = null)
    {
        /** @var ProfiledNamesList $properties */
        $properties = ProfiledNamesFactory::createFromArguments(func_get_args());

        // Prepare a default exception
        $e = new OutOfBoundsException(
            OutOfBoundsException::NO_MATCHING_PROPERTIES_STR,
            OutOfBoundsException::NO_MATCHING_PROPERTIES
        );

        // Run through all properties
        foreach ($properties as $property) {
            try {
                return $this->getProperty($property->name, $property->profile);
            } catch (OutOfBoundsException $e) {
                continue;
            }
        }

        throw $e;
    }

    /**
     * Return all properties
     *
     * @return array[] Properties
     * @api
     */
    public function getProperties()
    {
        return $this->item->getProperties()->export();
    }

    /**
     * Return an object representation of the item
     *
     * @return \stdClass Micro information item
     * @api
     */
    public function toObject()
    {
        return $this->item->export();
    }
}
