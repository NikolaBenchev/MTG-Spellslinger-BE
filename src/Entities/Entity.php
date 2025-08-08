<?php

namespace App\Entities;

use JsonSerializable;
use ReturnTypeWillChange;

abstract class Entity implements JsonSerializable{
    
    abstract function getSerializableFields();
    abstract function getDatabaseFields();

    public function getDatabaseParams($allowedNullProperties = []) {
        $data = [];
        foreach($this->getDatabaseFields() as $field) {
            $property = ""; 
            if (($this->{$property}) !== null || in_array($property, $allowedNullProperties)) {
                $data[$field] = $this->{$property};
            }
        }
        
        return $data;
    }

    public function jsonSerialize()
    {
        foreach($this->getSerializableFields() as $property)
        {
            $getter = 'get' . ucfirst($property);
            $data[$property] = $this->$getter();
        }
        return $data;
    }
}