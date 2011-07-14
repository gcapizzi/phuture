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

    function testLength() {
        assertEquals(6, $this->string->length());
    }

    function testClear() {
        assertNotEquals(s(''), $this->string);

        $this->string->clear();
        assertEquals(s(''), $this->string);
    }

    // Access

    function testGet() {
        assertEquals(s('r'), $this->string->get(2));
        assertEquals(s('r'), $this->string->get(-4));

        assertEquals(s('rin'), $this->string->get(2, 4));
        assertEquals(s('rin'), $this->string->get(2, -2));

        assertEquals(s(''), $this->string->get(2, 1));
        assertEquals(s(''), $this->string->get(2, -5));

        assertEquals(s('rin'), $this->string->get(-4, 4));
        assertEquals(s('rin'), $this->string->get(-4, -2));

        assertEquals(s(''), $this->string->get(-4, 1));
        assertEquals(s(''), $this->string->get(-4, -5));
    }

    function testSet() {
        $this->string->set(1, 'p');
        $this->string->set(-1, 't');
        assertEquals(s('sprint'), $this->string);
    }

    function testDelete() {
        assertEquals(s('sting'), $this->string->delete(2));
        assertEquals(s('sting'), $this->string->delete(-4));
    }

    function testGetSetByte() {
        assertEquals(116, $this->string->getByte(1));
        assertEquals(116, $this->string->getByte(-5));

        $this->string->setByte(1, 112);
        $this->string->setByte(-1, 116);
        assertEquals(s('sprint'), $this->string);
    }

    function testSubstring() {
        assertEquals(s('ring'), $this->string->substring(2));
        assertEquals(s('ring'), $this->string->substring(-4));

        assertEquals(s('rin'), $this->string->substring(2, 3));
        assertEquals(s('rin'), $this->string->substring(2, -1));
        assertEquals(s('rin'), $this->string->substring(-4, 3));
        assertEquals(s('rin'), $this->string->substring(-4, -1));
    }

    // ArrayAccess interface

    function testArrayAccess() {
        assertEquals(s('t'), $this->string[1]);
        assertEquals(s('t'), $this->string[-5]);

        $this->string[1] = 'p';
        $this->string[-1] = 't';
        assertEquals(s('sprint'), $this->string);

        assertFalse(isset($this->string[10]));
        assertFalse(isset($this->string[-10]));
        assertTrue(isset($this->string[3]));
        assertTrue(isset($this->string[-3]));
    }

    function testUnset() {
        unset($this->string[2]);
        assertEquals(s('sting'), $this->string);

        unset($this->string[-4]);
        assertEquals(s('sing'), $this->string);
    }

    // Countable interface

    function testCount() {
        assertEquals(6, $this->string->count());
    }

    // Concatenation

    function testAppend() {
        assertEquals(s('stringalicious'), $this->string->append('alicious'));
    }

    function testPrepend() {
        $this->string->setValue('alicious');
        assertEquals(s('stringalicious'), $this->string->prepend('string'));
    }

    // Case manipulation

    function testUpperLowercase() {
        $this->string->setValue('sTrinG');

        assertEquals(s('STRING'), $this->string->uppercase());
        assertEquals(s('string'), $this->string->lowercase());
    }

    function testCapitalize() {
        assertEquals(s('String'), $this->string->capitalize());
    }

    function testCapitalizeWords() {
        $this->string->setValue('The super-cat is on the table.');

        assertEquals(s('The Super-cat Is On The Table.'),
                     $this->string->capitalizeWords());
    }

    function testSwapCase() {
        $this->string->setValue('sTr1nG');

        assertEquals(s('StR1Ng'), $this->string->swapCase());
    }

    // String type

    function testIsUppercase() {
        assertTrue(s('STRING')->isUppercase());
        // assertTrue(s('STR1NG')->isUppercase());
        assertFalse(s('sTrinG')->isUppercase());
        // assertTrue(s('ST ING')->isUppercase());
    }

    function testIsLowercase() {
        assertTrue(s('string')->isLowercase());
        // assertTrue(s('str1ng')->isLowercase());
        assertFalse(s('sTrinG')->isLowercase());
        // assertTrue(s('st ing')->isLowercase());
    }

    function testIsAlphanumeric() {
        assertTrue(s('string')->isAlphanumeric());
        assertTrue(s('123456')->isAlphanumeric());
        assertTrue(s('sTr1nG')->isAlphanumeric());
        assertFalse(s('st ing')->isAlphanumeric());
        assertFalse(s('sT-1nG')->isAlphanumeric());
    }

    function testIsAlpha() {
        assertTrue(s('string')->isAlpha());
        assertFalse(s('sTr1nG')->isAlpha());
        assertFalse(s('st ing')->isAlpha());
    }

    function testIsNumeric() {
        assertTrue(s('123456')->isNumeric());
        assertFalse(s('string')->isNumeric());
        assertFalse(s('sTr1nG')->isNumeric());
    }

    function testIsSpace() {
        assertTrue(s('   ')->isSpace());
        assertFalse(s('string')->isSpace());
        assertFalse(s('st ing')->isSpace());
    }

    // Trimming

    function testTrim() {
        $s1 = s("\t   string   \n");
        assertEquals(s('string'), $s1->trim());
        assertEquals(s("\t   string   \n"), $s1->trim(''));

        $s2 = s('--- string ---');
        assertEquals(s('string'), $s2->trim('- '));
        assertEquals(s('string'), $s2->trim(s('- ')));
    }

    function testLtrim() {
        $s1 = s("\t   string   \n");
        assertEquals(s("string   \n"), $s1->ltrim());
        assertEquals(s("\t   string   \n"), $s1->ltrim(''));

        $s2 = s('--- string ---');
        assertEquals(s('string ---'), $s2->ltrim('- '));
        assertEquals(s('string ---'), $s2->ltrim(s('- ')));
    }

    function testRtrimChop() {
        $s1 = s("\t   string   \n");
        assertEquals(s("\t   string"), $s1->rtrim());
        assertEquals(s("\t   string   \n"), $s1->rtrim(''));
        assertEquals(s("\t   string"), $s1->chop());
        assertEquals(s("\t   string   \n"), $s1->chop(''));

        $s2 = s('--- string ---');
        assertEquals(s('--- string'), $s2->rtrim('- '));
        assertEquals(s('--- string'), $s2->chop('- '));
        assertEquals(s('--- string'), $s2->rtrim(s('- ')));
        assertEquals(s('--- string'), $s2->chop(s('- ')));
    }

    // String content

    function testStartsWith() {
        assertTrue($this->string->startsWith('str'));
        assertTrue($this->string->startsWith(s('str')));
        assertFalse($this->string->startsWith('tri'));
        assertFalse($this->string->startsWith(s('tri')));
    }

    function testEndsWith() {
        assertTrue($this->string->endsWith('ing'));
        assertTrue($this->string->endsWith(s('ing')));
        assertFalse($this->string->endsWith('rin'));
        assertFalse($this->string->endsWith(s('rin')));
    }

    // Replacement

    function testReplace() {
        assertEquals(s('playing'), $this->string->replace('str', 'play'));
    }

    function testCaseReplace() {
        assertEquals(s('playing'), $this->string->caseReplace('str', 'play'));
        $this->string = s('sTrinG');
        assertEquals(s('playinG'), $this->string->caseReplace('str', 'play'));
    }

    // Other manipulation functions

    function testReverse() {
        assertEquals(s('gnirts'), $this->string->reverse());
    }

    function testRepeat() {
        assertEquals(s('stringstringstring'), $this->string->repeat(3));
        assertEquals(s(''), $this->string->repeat(0));
    }

    function testInsert() {
        assertEquals(s('steering'), $this->string->insert(2, 'ee'));
        assertEquals(s('steering'), $this->string->insert(-4, 'ee'));
    }
}
