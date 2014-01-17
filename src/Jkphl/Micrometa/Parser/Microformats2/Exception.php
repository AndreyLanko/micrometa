<?php

/**
 * micrometa – Micro information meta parser
 *
 * @category	Jkphl
 * @package		Jkphl_Micrometa
 * @author		Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright	Copyright © 2014 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license		http://opensource.org/licenses/MIT	The MIT License (MIT)
 */

namespace Jkphl\Micrometa\Parser\Microformats2;

/***********************************************************************************
 *  The MIT License (MIT)
 *  
 *  Copyright © 2014 Joschi Kuphal <joschi@kuphal.net> / @jkphl
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

/**
 * Extended Microformats2 exception
 * 
 * @category	Jkphl
 * @package		Jkphl_Micrometa
 * @author		Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright	Copyright © 2014 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license		http://opensource.org/licenses/MIT	The MIT License (MIT)
 * @link		https://github.com/indieweb/php-mf2
 */
class Exception extends \Exception {
	/**
	 * Invalid microformat vocable
	 * 
	 * @var \int
	 */
	const INVALID_MICROFORMAT_VOCABLE = 1;
	/**
	 * Invalid microformat vocable
	 * 
	 * @var \string
	 */
	const INVALID_MICROFORMAT_VOCABLE_STR = 'Invalid microformat vocable "%s"';
	/**
	 * Item index out of range
	 * 
	 * @var \int
	 */
	const INDEX_OUT_OF_RANGE = 2;
	/**
	 * Item index out of range
	 * 
	 * @var \string
	 */
	const INDEX_OUT_OF_RANGE_STR = 'Item index %s out of range';
}