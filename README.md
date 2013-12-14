micrometa
=========

is a simple **meta parser** for extracting micro information out of HTML documents, currently supporting Microformats (1 + 2) and W3C Microdata. It's written in PHP.

Embedding micro information into HTML documents is a pretty darn cool way of enriching your content with machine readable metadata. Unfortunately there are several different (at least de facto) standards for doing so, e.g.

1.	The "original" [Microformats (μF)](http://microformats.org/wiki),
2.	the updated [Microformats 2](http://microformats.org/wiki/microformats2) syntax,
3.	the [W3C Microdata](http://www.w3.org/TR/microdata/) specification,
4.	[RDFa](http://en.wikipedia.org/wiki/RDFa) and others ...

As a meta parser *micrometa* recognizes multiple formats and combines them to one common [PHP object](#object-data) respectively [JSON](#json-data) result set.

Installation
------------

You can install *micrometa* by cloning it's GitHub repository (or manually downloading and extracting the package from GitHub):

```bash
cd /path/to/project/basedir
git clone https://github.com/jkphl/micrometa.git
```

This will create a subdirectory called `micrometa` containing all the package files.

Dependencies
------------

*micrometa* relies on the following external parser packages:

1.	The [IndieWeb](https://github.com/indieweb) [microformats-2 parser for PHP](https://github.com/indieweb/php-mf2) (which also supports the original set of microformats),
2.	and the ~~[MicrodataPHP parser](https://github.com/linclark/MicrodataPHP) by [Lin Clark](https://github.com/linclark)~~ [Microdata parser](https://github.com/euskadi31/Microdata) by [Axel Etcheverry](https://github.com/euskadi31).

*micrometa* comes with **Composer** support, so go and [get Composer](http://getcomposer.org/doc/00-intro.md#installation-nix) and install the two libraries like this:

```bash
cd /path/to/project/basedir/micrometa
php /path/to/composer.phar install

# or (depending on your setup ...):

composer install
``` 

Usage
-----

*micrometa* essentially consists of one [main parser class](src/Jkphl/Micrometa.php) and several auxiliary classes. You can incorporate *micrometa* into your project simply by including and instanciating the main parser class. Fetching and parsing a remote HTML document is a easy as this:

```php
require_once '/path/to/micrometa/src/Jkphl/Micrometa.php'
	
$url					= 'https://github.com/jkphl/micrometa';
$micrometaParser		= new \Jkphl\Micrometa($url);
$micrometaObjectData	= $micrometaParser->toObject();
```

or simply

```php
$micrometaObjectData	= \Jkphl\Micrometa::instance($url)->toObject();
```

*micrometa* tries to fetch remote documents via `cURL` and falls back to a stream wrapper approach (`file_get_contents`) in case `cURL` is not available.

Instead of fetching a remote URL you can also directly pipe some HTML source code into the parser. However, you will still have to provide a base URL used for resolving relative URLs:

```php
$micrometaObjectData	= \Jkphl\Micrometa::instance($url, $htmlSourceCode)->toObject();
```

### Parsing results

*micrometa* provides several methods for accessing the micro information extracted out of an HTML document. You may retrieve the embedded metadata as a whole (in [PHP object](#object-data) or [JSON format](#json-data)) or access single facets through dedicated methods. Only the most important methods are described here – for full details please have a look at the source code or the included, automatically generated [PHPDocumentor API documentation](doc/index.html).

#### Object data

The parser object's `toObject()` method returns a copy of the complete set of micro information as a vanilla PHP object (`\stdClass`) with three properties and a couple of subproperties:

<table>
	<tr>
		<td>Property</td>
		<td>Key</td>
		<td>Property</td>
		<td>Description</td>
		<td>Data type</td>
	</tr>
	<tr>
		<td><i>items</i></td>
		<td> </td>
		<td> </td>
		<td>A list of all top level <a href="#top-level-micro-information-items">micro information items</a>.</td>
		<td><code>\array</code></td>
	</tr>
	<tr>
		<td> </td>
		<td><code>0, 1, 2 ...</code></td>
		<td> </td>
		<td>Top level <a href="#top-level-micro-information-items">micro information item</a> (see below).</td>
		<td><code>\Jkphl\Micrometa\Item</code></td>
	</tr>
	<tr>
		<td><i>rels</i></td>
		<td> </td>
		<td> </td>
		<td>A collection representing all related resources (i.e. <code>rel</code> attribute nodes; except the ones with an "alternate" value, see below).</td>
		<td><code>\stdClass</code></td>
	</tr>
	<tr>
		<td> </td>
		<td><code>rel</code> value</td>
		<td> </td>
		<td>Aggregated list of all <code>href</code> values of the elements with this <code>rel</code> value.</td>
		<td><code>\array</code></td>
	</tr>
	<tr>
		<td><i>alternates</i></td>
		<td> </td>
		<td> </td>
		<td>A list of all alternative resources (i.e. <code>rel</code> attribute nodes having the value "alternate").</td>
		<td><code>\array</code></td>
	</tr>
	<tr>
		<td> </td>
		<td><code>0, 1, 2 ...</code></td>
		<td> </td>
		<td>Object representing a single <code>rel="<i>alternate</i>"</code> attribute node.</td>
		<td><code>\stdClass</code></td>
	</tr>
	<tr>
		<td> </td>
		<td> </td>
		<td><i>url</i></td>
		<td>Value of the corresponding <code>href</code> attribute.</td>
		<td><code>\string</code></td>
	</tr>
	<tr>
		<td> </td>
		<td> </td>
		<td><i>rel</i></td>
		<td>Additional <code>rel</code> value components (if any, with "alternate" stripped out). .</td>
		<td><code>\string</code></td>
	</tr>
</table>

#### JSON Data

The parser object's `toJSON()` method returns a JSON encoded version of the [PHP object](#object-data) result. The contained [micro information items](#micro-information-items) are simplified to vanilla JavaScript objects (see below for an [output example](#json-representation)).

```php
$micrometaJSONData		= \Jkphl\Micrometa::instance($url)->toJSON();
```

#### Top level micro information items

You may use the parser object's `items()` method to access a list of top level [micro information items](#micro-information-items) (see the *items* property of the [object data](#object-data) result):

```php
$micrometaParser		= new \Jkphl\Micrometa($url);
$topLevelItems			= $micrometaParser->items();
```

You may restrict the list of returned items by passing an arbitrary number of item types as arguments to the `items()` method. The matching items will be ordered according to the order or the arguments:

```php
$micrometaParser		= new \Jkphl\Micrometa($url);
$personItems			= $micrometaParser->items('http://schema.org/Person', 'h-card');
```

Finally, the parser object's `item()` method provides a shortcut for returning **only the first item** of an item list. The return value (if any) is a [micro information item](#micro-information-items) (`NULL` otherwise):

```php
$micrometaParser		= new \Jkphl\Micrometa($url);
$firstItem				= $micrometaParser->item();
$firstPersonItem		= $micrometaParser->item('http://schema.org/Person', 'h-card');
```

#### Related resources

You may directly access the list of related resources using the parser object's `rels()` method (see the *rels* property of the [object data result](#object-data)):

```php
$micrometaParser		= new \Jkphl\Micrometa($url);
$relatedResources		= $micrometaParser->rels();
```

#### Alternative resources

You may directly access the list of alternative resources using the parser object's `alternates()` method (see the *alternates* property of the [object data result](#object-data)):

```php
$micrometaParser		= new \Jkphl\Micrometa($url);
$alternateResources		= $micrometaParser->alternates();
```

#### Loading external author metadata

The parser object's `externalAuthor()` method is a convenient way to load external author metadata. The method scans all resources linked with a <code>rel="<i>author</i>"</code> attribute until it encounters a top level [micro information item](#micro-information-items) of type "[http://schema.org/Person](http://schema.org/Person)", "[http://data-vocabulary.org/Person]()" or "[h-card](http://microformats.org/wiki/microformats2#h-card)" (in the given order). The first matching item (if any) is returned as external author.

```php
$micrometaParser		= new \Jkphl\Micrometa($url);
$author					= $micrometaParser->item('h-card');
if (!($author instanceof \Jkphl\Micrometa\Item)) {
	$author				= $micrometaParser->externalAuthor();
}
if ($author instanceof \Jkphl\Micrometa\Item) {
	...
}
```

### Micro information items

These are the objects carrying the metadata. Internally they consist of three main object properties:

<table>
	<tr>
		<td>Property</td>
		<td>Description</td>
		<td>Data type</td>
	</tr>
	<tr>
		<td><i>id</i></td>
		<td>Some items carry an explicit item ID (but most don't).</td>
		<td><code>\string</code></td>
	</tr>
	<tr>
		<td><i>types</i></td>
		<td>List of the item's types (e.g. <a href="http://microformats.org/wiki/microformats2#h-card">h-card</a>, <a href="http://schema.org/Person">http://schema.org/Person</a> etc.; may be multiple).</td>
		<td><code>\array</code></td>
	</tr>
	<tr>
		<td><i>value</i></td>
		<td>Some micro information types might populate this property with an explicit value representing the whole item (but most don't).</td>
		<td><code>\string</code></td>
	</tr>
	<tr>
		<td><i>properties</i></td>
		<td>
			<p>Collection of nested item properties. Each property may be multi-valued and thus is always a list of values. The values are consistently either strings or nested micro information items.</p>
			<p>The property names are normalized, so e.g. the <a href="http://microformats.org/wiki/microformats2#Summary">microformats-2 class name prefixes</a> are stripped out (resulting e.g. in th property name "<i>author</i>" instead of "<i>p-author</i>"). Certain property names (e.g. "<i>image</i>", "<i>photo</i>", "<i>logo</i>" or "<i>url</i>") are expected to carry URL values and are automatically sanitized and expanded to absolute URLs.</p>
		</td>
		<td><code>\stdClass</code></td>
	</tr>
</table>

Especially the collection of nested properties is access restricted. Use the following methods for working with an item object.

#### Item type check

You can use the `isOfType()` method to check if an item is of a specific type. The method accepts an arbitrary number of item types and returns `TRUE` if any of these matches:

```php
if ($item->isOfType('http://schema.org/Person', 'h-card')) {
	...
}
```

#### Accessing item properties

You can access nested item properties by simply using their names as object properties:

```php
$photo				= $item->photo;
$givenName			= $item->givenName;
```

Notice that all property names have been converted to [lowerCamelCase](http://en.wikipedia.org/wiki/CamelCase) writing (e.g. `givenName` for the "<i>given-name</i>" property in the original `h-card` markup).

Also, remember that all nested item properties are value lists themselves. When you use the bare property name with any of these nested item properties, **only the first element of the property's value list** will be returned. If you want to retrieve the **complete property list, simply append an "s" to the property name**:

```php
$allPhotos			= $item->photos;
```

If a requested property doesn't exist at all, `NULL` is returned. 

#### Finding the first defined property

You can use the `firstOf()` method to find and return the first property in a list of properties that is defined for that very item. The method accepts an arbitrary number of property names (also with appended "s" for retrieving the whole property value lists) and returns the first non-`NULL` match for the item:

```php
$avatar				= $item->firstOf('photo', 'logo', 'image');
```

#### Object data

The method `toObject()` returns a simplified PHP object representation (i.e. `\stdClass` object) of the item and all it's nested subitems.

Example
-------

#### HTML source with embedded micro information

The included [example page](demo/example.html) features a mixture of [Microformats 2](http://microformats.org/wiki/microformats2) and [W3C Microdata](http://www.w3.org/TR/microdata/) information:

```html
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Mixed microformats-2 / microdata example document</title>
    </head>
    <body>
        <figure class="h-card" itemscope="itemscope" itemtype="http://schema.org/Person">
            <img class="u-photo" itemprop="photo" src="http://www.gravatar.com/avatar/60a1d50aa04c5742644fb9f1a21d74ba.jpg?s=100" alt="Joschi Kuphal" />
            <figcaption>
                <address>
                	<span class="p-name" itemprop="name"><span class="p-given-name" itemprop="givenName">Joschi</span> <span class="p-family-name" itemprop="familyName">Kuphal</span></span>
                	<span class="p-role" itemprop="role">Web architect</span>
                	<span class="p-adr h-adr" itemprop="address" itemscope="itemscope" itemtype="http://schema.org/Address">from <span class="p-locality" itemprop="locality">Nuremberg</span>, <span class="p-country-name" itemprop="country">Germany</span></span>
                </address>
            </figcaption>
        </figure>
    </body>
</html>
```

#### JSON representation

This is the JSON output extracted by *micrometa* looks like this:

```JSON
{
	"items": [
		{
			"id": null,
			"types": [
				"h-card"
			],
			"value": null,
			"properties": {
				"adr": [
					{
						"id": null,
						"types": [
							"h-adr"
						],
						"value": "from Nuremberg, Germany",
						"properties": {
							"locality": [
								"Nuremberg"
							],
							"countryName": [
								"Germany"
							],
							"name": [
								"from Nuremberg, Germany"
							]
						}
					}
				],
				"name": [
					"Joschi Kuphal"
				],
				"givenName": [
					"Joschi"
				],
				"familyName": [
					"Kuphal"
				],
				"role": [
					"Web architect"
				],
				"photo": [
					"http:\/\/www.gravatar.com\/avatar\/60a1d50aa04c5742644fb9f1a21d74ba.jpg?s=100"
				]
			}
		},
		{
			"id": null,
			"types": [
				"http:\/\/schema.org\/Person"
			],
			"value": null,
			"properties": {
				"photo": [
					"http:\/\/www.gravatar.com\/avatar\/60a1d50aa04c5742644fb9f1a21d74ba.jpg?s=100"
				],
				"name": [
					"Joschi Kuphal"
				],
				"givenName": [
					"Joschi"
				],
				"familyName": [
					"Kuphal"
				],
				"role": [
					"Web architect"
				],
				"address": [
					{
						"id": null,
						"types": [
							"http:\/\/schema.org\/Address"
						],
						"value": null,
						"properties": {
							"locality": [
								"Nuremberg"
							],
							"country": [
								"Germany"
							]
						}
					}
				]
			}
		}
	],
	"rels": {

	},
	"alternates": [

	]
}
```

Demo
----
There's a [demo page](demo/micrometa.php) included in this package, which you can use for checking arbitrary URLs for embedded micro information. Please be aware that the demo page has to be hosted on a PHP enabled server (preferably PHP 5.4+ for getting a pretty-printed JSON result). A live version of the demo page can be found [here](http://micrometa.jkphl.is).

Legal
-----
Copyright © 2013 Joschi Kuphal <joschi@kuphal.net> / [@jkphl](https://twitter.com/jkphl)

*micrometa* is licensed under the terms of the [MIT license](LICENSE.txt).