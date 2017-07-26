<?php

namespace Beesperester\WebDav\FS;

// SimpleXML
use \SimpleXMLElement;

// WebDav
use Beesperester\WebDav\FS\Resource;

class File extends Resource
{
    /**
     * @var int
     */
    public $getcontentlength;

    /**
     * @var string
     */
    public $getcontenttype;

    /**
     * Extra attributes to look for when converting to xml
     * 
     * @var array $include_attributes
     */
    public $include_attributes = [
        'getcontentlength',
        'getcontenttype'
    ];

    /**
     * Create new file from array.
     *
     * @param array $data
     *
     * @return File
     */
    public static function fromData(array $data)
    {
        $defaults = [
            'base_url' => '',
            'creationdate' => null,
            'displayname' => '',
            'getcontentlength' => 0,
            'getcontenttype' => Null,
            'getlastmodified' => null,
        ];

        $data = array_merge($defaults, $data);

        $file = new static($data['displayname'], $data['base_url'], $data['creationdate'], $data['getlastmodified']);

        $file->getcontenttype = $data['getcontenttype'];
        $file->getcontentlength = $data['getcontentlength'];

        return $file;
    }
}