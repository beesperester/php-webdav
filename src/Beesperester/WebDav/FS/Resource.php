<?php

namespace Beesperester\WebDav\FS;

// Carbon
use Carbon\Carbon;

// SimpleXML
use \SimpleXMLElement;

// WebDav
use Beesperester\WebDav\FS\ResourceInterface;

abstract class Resource implements ResourceInterface
{
    /**
     * @var string $base_url
     */
    public $base_url;

    /**
     * @var Carbon\Carbon $creationdate
     */
    public $creationdate;

    /**
     * @var string $displayname
     */
    public $displayname;

    /**
     * @var Carbon\Carbon $getlastmodified
     */
    public $getlastmodified;

    /**
     * Attributes to look for when converting to xml
     * 
     * @var array $base_attributes
     */
    protected $base_attributes = [
        'creationdate',
        'displayname',
        'getlastmodified'
    ];

    /**
     * Extra attributes to look for when converting to xml
     * 
     * @var array $include_attributes
     */
    public $include_attributes = [];

    public function __construct($displayname, $base_url, Carbon $creationdate = Null, Carbon $getlastmodified = Null)
    {
        $this->base_url = $base_url;
        $this->creationdate = $creationdate;
        $this->displayname = $displayname;
        $this->getlastmodified = $getlastmodified;
    }

    /**
     * Get uri for resource
     *
     * @return string
     */
    public function getUri()
    {
        $parts = [$this->base_url, $this->displayname];

        return implode('/', array_filter($parts));
    }

    /**
     * Get resource attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return array_unique(array_merge($this->base_attributes, $this->include_attributes));
    }

    /**
     * Create valid WebDAV xml response
     * for known and unknown props
     *
     * <response>
     *   <href>http://example.com/resource</href>
     *   <propstat>
     *     <prop>
     *       <displayname>resource name</displayname>
     *       <creationdate>Date - Time</creationdate>
     *     </prop>
     *   </propstat>
     *   <propstat>
     *     <prop>
     *       <getlastmodified/>
     *     </prop>
     *   </propstat>
     * </response>
     *
     * @return SimpleXMLElement;
     */
    public function toXml()
    {
        $response = new SimpleXMLElement('<response/>');

        // add href
        $response->addChild('href', $this->getUri());
    
        // known attributes
        $known = array_filter($this->getAttributes(), function($attribute) {
            return !empty($this->$attribute);
        });

        if ($known) {
            // add propstat element
            $propstat = $response->addChild('propstat');

            // add prop element
            $prop = $propstat->addChild('prop');
            $prop->addAttribute('proptype', 'known');

            foreach($known as $attribute) {
                // add attribute
                if ($this->$attribute instanceof Carbon) {
                    // add creationdate in Iso 8601 format
                    if ($attribute === 'creationdate') {
                        $prop->addChild($attribute, $this->$attribute->toIso8601String());

                    }

                    // add getlastmodified in Rfc 1036 format
                    if ($attribute === 'getlastmodified') {
                        $prop->addChild($attribute, $this->$attribute->toRfc1036String());
                    }
                } else {
                    $prop->addChild($attribute, $this->$attribute);
                }                
            }
        }

        // unknown attributes
        $unknown = array_diff($this->getAttributes(), $known);

        if ($unknown) {
            // add propstat element
            $propstat = $response->addChild('propstat');

            // add prop element
            $prop = $propstat->addChild('prop');
            $prop->addAttribute('proptype', 'unknown');

            foreach($unknown as $attribute) {
                $prop->addChild($attribute);
            }
        }

        return $response;
    }
}
