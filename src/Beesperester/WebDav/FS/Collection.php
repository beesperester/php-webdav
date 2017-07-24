<?php

namespace Beesperester\WebDav\FS;

class Collection
{   
    public $children,
        $displayname, 
        $root;

    public function __construct(array $data)
    {
        $this->children = $data['children'];
        $this->displayname = $data['displayname'];
        $this->root = $data['root'];
    }

    public static function fromData(array $data)
    {
        $defaults = [
            'root' => '/',
            'children' => []
        ];

        $data = array_merge($defaults, $data);

        return new static($data);
    }

    public function getHref()
    {
        return $this->root . $this->displayname;
    }
}