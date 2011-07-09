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
        assertEquals('string', sprintf('%s', $this->string));
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
        assertEquals(s('sting'), $this->string->delete(2));

        assertEquals(s('ring'), $this->string->delete(0)->delete(0));
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

        assertFalse(isset($this->string[10]));
        assertFalse(isset($this->string[-10]));
        assertTrue(isset($this->string[3]));
        assertTrue(isset($this->string[-3]));
    }

    function testUnset() {
        unset($this->string[2]);

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

    function testTrim() {
        $s1 = s("\t   string   \n");
        assertEquals(s('string'), $s1->trim());

        $s2 = s('--- string ---');
        assertEquals(s('string'), $s2->trim('- '));
        assertEquals(s('string'), $s2->trim(s('- ')));
    }

    function testLtrim() {
        $s1 = s("\t   string   \n");
        assertEquals(s("string   \n"), $s1->ltrim());

        $s2 = s('--- string ---');
        assertEquals(s('string ---'), $s2->ltrim('- '));
        assertEquals(s('string ---'), $s2->ltrim(s('- ')));
    }

    function testRtrimChop() {
        $s1 = s("\t   string   \n");
        assertEquals(s("\t   string"), $s1->rtrim());
        assertEquals(s("\t   string"), $s1->chop());

        $s2 = s('--- string ---');
        assertEquals(s('--- string'), $s2->rtrim('- '));
        assertEquals(s('--- string'), $s2->chop('- '));
        assertEquals(s('--- string'), $s2->rtrim(s('- ')));
        assertEquals(s('--- string'), $s2->chop(s('- ')));
    }

    function testInsert() {
        $this->string->insert(2, 'ee');
        assertEquals(s('steering'), $this->string->insert(2, 'ee'));
    }
}
