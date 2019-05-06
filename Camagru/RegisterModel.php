<?php

class Models
{
    public function __construct($classArray)
    {
        $this->createObjects($classArray);
    }

    private function createObjects($classArray)
    {
        foreach ($classArray as $key => $value) {
            if (!property_exists($this, $key))
            {
                $propertyName = str_replace('models', '', strtolower($key));
                $this->{$propertyName} = $value;
            }
        }
    }
}

/*
    Usage :

    class A extends RegisterModel
    {
        public function __construct()
        {
            parent::__construct(createClassArray(__DIR__.'/model/'));
        }

        // acces a $this->className->method();
    }

 */

?>
