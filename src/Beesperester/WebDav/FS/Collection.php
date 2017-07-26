<?php

namespace Beesperester\WebDav\FS;

// SimpleXML
use \SimpleXMLElement;

// WebDav
use Beesperester\WebDav\FS\Resource;

class Collection extends Resource
{   
    /**
     * Array of children of collection
     *
     * @var array $children
     */
    public $children;

    /**
     * Is collection the root?
     *
     * @var boolean $root
     */
    public $root;

    /**
     * Create new collection from array
     *
     * @param array $data
     *
     * @return Collection
     */
    public static function fromData(array $data)
    {
        $defaults = [
            'base_url' => '',
            'creationdate' => Null,
            'displayname' => '',
            'getlastmodified' => Null,
            'root' => False,
            'children' => []
        ];

        $data = array_merge($defaults, $data);

        $collection = new static($data['displayname'], $data['base_url'], $data['creationdate'], $data['getlastmodified']);

        $collection->children = $data['children'];
        $collection->root = $data['root'];

        return $collection;
    }

    /**
     * Get uri for resource
     *
     * @return string
     */
    public function getUri()
    {
        $parts = [$this->base_url];

        // add displayname if collection is not root
        if (!$this->root)
        {
            $parts[] = $this->displayname;
        }

        // return href with trailing slash
        return implode('/', array_filter($parts));
    }

    /**
     * Extend function to add resourcetype element
     * <response>
     *   [...]
     *   <propstat>
     *     <prop>
     *       [...]
     *       <resourcetype>
     *         <collection />
     *       </resourcetype>
     *     </prop>
     *   </propstat>
     * </response>
     *
     * @return SimpleXMLElement;
     */
    public function toXml()
    {
        $response = parent::toXml();

        // add resourcetype element
        $known_props = $response->xpath('/response/propstat/prop[@proptype="known"]');

        if ($known_props) {
            $resourcetype = new SimpleXMLElement('<resourcetype/>');

            $resourcetype->addChild('collection');

            simplexml_append($known_props[0], $resourcetype);
        }

        return $response;
    }
}