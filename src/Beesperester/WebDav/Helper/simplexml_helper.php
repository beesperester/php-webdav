<?php

function simplexml_append(SimpleXMLElement $to, SimpleXMLElement $from) {
    $to_dom = dom_import_simplexml($to);
    $from_dom = dom_import_simplexml($from);
    $to_dom->appendChild($to_dom->ownerDocument->importNode($from_dom, true));
}

function simplexml_format(SimpleXMLElement $xml)
{
    $dom = dom_import_simplexml($xml)
        ->ownerDocument;
    
    $dom->formatOutput = true;

    return $dom->saveXML();
}