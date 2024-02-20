<?php

class Person{
    private $id;
    function __construct($id){
        $this->id = $id;
    }

}
$person = new Person(1);

?>