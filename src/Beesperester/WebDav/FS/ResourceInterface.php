<?php

namespace Beesperester\WebDav\FS;

interface ResourceInterface
{
    /**
     * Compile resource data to valid xml
     *
     * @return \SimpleXMLElement
     */
    public function toXml();

    /**
     * Get uri for resource
     *
     * @return string
     */
    public function getUri();
}
