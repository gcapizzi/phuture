<?php

require_once dirname(__FILE__) . '/../String.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class StringTest extends PHPUnit_Framework_TestCase
{
    protected $string;

    protected function setUp() {
        $this->string = new Phuture_String('string');
    }

    function testConstruct() {
        assertEquals(s('string'), $this->string);
    }

    function testGetSetValue() {
        $this->string->setValue('new_string');

        assertEquals('new_string', $this->string->getValue());
    }

    function testToString() {
        $this->markTestIncomplete();
    }

    function testIsEmpty() {
        assertFalse($this->string->isEmpty());

        $this->string->setValue('');
        assertTrue($this->string->isEmpty());
    }

    function testClear() {
        assertNotEquals(s(''), $this->string);

        $this->string->clear();
        assertEquals(s(''), $this->string);
    }

    function testLength() {
        assertEquals(6, $this->string->length());
    }

    function testCount() {
        assertEquals(6, $this->string->count());
    }

    function testGetSet() {
        assertEquals(s('t'), $this->string->get(1));

        $this->string->set(1, 'p');
        assertEquals(s('spring'), $this->string);
    }

    function testDelete() {
        $this->markTestIncomplete();

        $this->string->delete(1);

        assertEquals(s('sting'), $this->string);
    }

    function testGetSetByte() {
        assertEquals(116, $this->string->getByte(1));

        $this->string->setByte(1, 112);
        assertEquals(s('spring'), $this->string);
    }

    function testArrayAccess() {
        assertEquals(s('t'), $this->string[1]);

        $this->string[1] = 'p';
        assertEquals(s('spring'), $this->string);
    }

    function testUnset() {
        $this->markTestIncomplete();

        unset($this->string[1]);

        assertEquals(s('sting'), $this->string);
    }

    function testUpperLowercase() {
        $this->string->setValue('sTrinG');

        assertEquals(s('STRING'), $this->string->uppercase());
        assertEquals(s('string'), $this->string->lowercase());
    }

    function testCapitalize() {
        assertEquals(s('String'), $this->string->capitalize());
    }

    function testReverse() {
        assertEquals(s('gnirts'), $this->string->reverse());
    }

    function testRepeat() {
        assertEquals(s('stringstringstring'), $this->string->repeat(3));
        assertEquals(s(''), $this->string->repeat(0));
    }
}
