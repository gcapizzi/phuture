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

        $this->string->setValue(s('new_string'));
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
        $this->string->set(-1, s('t'));
        assertEquals(s('sprint'), $this->string);
        $this->string->set(3, 1);
        assertEquals(s('spr1nt'), $this->string);
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
        $this->string[-1] = s('t');
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
        assertEquals(s('stringybark'), $this->string->append('ybark'));
        assertEquals(s('stringybark'), $this->string->append(s('ybark')));
    }

    function testPrepend() {
        $this->string->setValue('ybark');
        assertEquals(s('stringybark'), $this->string->prepend('string'));
        assertEquals(s('stringybark'), $this->string->prepend(s('string')));
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
        assertTrue(s('STR1NG')->isUppercase());
        assertTrue(s('ST ING')->isUppercase());
        assertFalse(s('sTrinG')->isUppercase());
        assertFalse(s('123456')->isUppercase());
    }

    function testIsLowercase() {
        assertTrue(s('string')->isLowercase());
        assertTrue(s('str1ng')->isLowercase());
        assertTrue(s('st ing')->isLowercase());
        assertFalse(s('sTrinG')->isLowercase());
        assertFalse(s('123456')->isLowercase());
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
        $this->string->setValue("\t   string   \n");
        assertEquals(s('string'), $this->string->trim());
        assertEquals(s("\t   string   \n"), $this->string->trim(''));

        $this->string->setValue('--- string ---');
        assertEquals(s('string'), $this->string->trim('- '));
        assertEquals(s('string'), $this->string->trim(s('- ')));
    }

    function testTrimLeft() {
        $this->string->setValue("\t   string   \n");
        assertEquals(s("string   \n"), $this->string->trimLeft());
        assertEquals(s("\t   string   \n"), $this->string->trimLeft(''));

        $this->string->setValue('--- string ---');
        assertEquals(s('string ---'), $this->string->trimLeft('- '));
        assertEquals(s('string ---'), $this->string->trimLeft(s('- ')));
    }

    function testTrimRightChop() {
        $this->string->setValue("\t   string   \n");
        assertEquals(s("\t   string"), $this->string->trimRight());
        assertEquals(s("\t   string   \n"), $this->string->trimRight(''));
        assertEquals(s("\t   string"), $this->string->chop());
        assertEquals(s("\t   string   \n"), $this->string->chop(''));

        $this->string->setValue('--- string ---');
        assertEquals(s('--- string'), $this->string->trimRight('- '));
        assertEquals(s('--- string'), $this->string->chop('- '));
        assertEquals(s('--- string'), $this->string->trimRight(s('- ')));
        assertEquals(s('--- string'), $this->string->chop(s('- ')));
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

    function testFind() {
        $this->string->setValue("string with a ring");
        assertEquals(2, $this->string->find('ring'));
        assertEquals(2, $this->string->find(s('ring')));
        assertEquals(false, $this->string->find('no'));
        assertEquals(false, $this->string->find(s('no')));
    }

    function testCaseFind() {
        $this->string->setValue("string with a ring");
        assertEquals(2, $this->string->caseFind('ring'));
        assertEquals(2, $this->string->caseFind(s('ring')));
        assertEquals(2, $this->string->caseFind('rInG'));
        assertEquals(2, $this->string->caseFind(s('rInG')));
        assertEquals(false, $this->string->caseFind('no'));
        assertEquals(false, $this->string->caseFind(s('no')));
    }

    function testFindRight() {
        $this->string->setValue("string with a ring");
        assertEquals(14, $this->string->findRight('ring'));
        assertEquals(14, $this->string->findRight(s('ring')));
        assertEquals(false, $this->string->findRight('no'));
        assertEquals(false, $this->string->findRight(s('no')));
    }

    function testCaseFindRight() {
        $this->string->setValue("string with a ring");
        assertEquals(14, $this->string->caseFindRight('ring'));
        assertEquals(14, $this->string->caseFindRight(s('ring')));
        assertEquals(14, $this->string->caseFindRight('rInG'));
        assertEquals(14, $this->string->caseFindRight(s('rInG')));
        assertEquals(false, $this->string->caseFindRight('no'));
        assertEquals(false, $this->string->caseFindRight(s('no')));
    }

    // Replacement

    function testReplace() {
        assertEquals(s('playing'), $this->string->replace('str', 'play'));
        assertEquals(s('playing'), $this->string->replace(s('str'), 'play'));
        assertEquals(s('playing'), $this->string->replace(s('str'), s('play')));
        assertEquals(s('ring'), $this->string->replace(array('s', 't'), ''));
    }

    function testCaseReplace() {
        $this->string->setValue('sTrinG');
        assertEquals(s('playinG'), $this->string->caseReplace('str', 'play'));
        assertEquals(s('rinG'), $this->string->casereplace(array('s', 't'),
                                                           ''));
    }

    // Padding

    function testPadLeft() {
        assertEquals(s('    string'), $this->string->padLeft(10));
        assertEquals(s('-=-=string'), $this->string->padLeft(10, '-='));
        assertEquals(s('-=-=string'), $this->string->padLeft(10, s('-=')));
        assertEquals(s('-=-=-string'), $this->string->padLeft(11, '-='));
        assertEquals(s('-=-=-string'), $this->string->padLeft(11, s('-=')));
    }

    function testPadRight() {
        assertEquals(s('string    '), $this->string->padRight(10));
        assertEquals(s('string-=-='), $this->string->padRight(10, '-='));
        assertEquals(s('string-=-='), $this->string->padRight(10, s('-=')));
        assertEquals(s('string-=-=-'), $this->string->padRight(11, '-='));
        assertEquals(s('string-=-=-'), $this->string->padRight(11, s('-=')));
    }

    function testPadBothCenter() {
        assertEquals(s('  string  '), $this->string->padBoth(10));
        assertEquals(s('-=string-='), $this->string->padBoth(10, '-='));
        assertEquals(s('-=string-='), $this->string->padBoth(10, s('-=')));
        assertEquals(s('-=string-=-'), $this->string->padBoth(11, '-='));
        assertEquals(s('-=string-=-'), $this->string->padBoth(11, s('-=')));

        assertEquals(s('  string  '), $this->string->center(10));
        assertEquals(s('-=string-='), $this->string->center(10, '-='));
        assertEquals(s('-=string-='), $this->string->center(10, s('-=')));
        assertEquals(s('-=string-=-'), $this->string->center(11, '-='));
        assertEquals(s('-=string-=-'), $this->string->center(11, s('-=')));
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
        assertEquals(s('steering'), $this->string->insert(2, s('ee')));
        assertEquals(s('steering'), $this->string->insert(-4, 'ee'));
        assertEquals(s('steering'), $this->string->insert(-4, s('ee')));
    }

    function testJoin() {
        assertEquals($this->string, s('r')->join(array('st', 'ing')));
        assertEquals($this->string, s('r')->join(array(s('st'), 'ing')));
        assertEquals($this->string, s('r')->join(array(s('st'), s('ing'))));
    }

    // String comparison

    function testCompareTo() {
        $alice1 = s('Alice');
        $alice2 = 'Alice';
        $bob1 = s('Bob');
        $bob2 = s('bob');

        assertEquals(0, $alice1->compareTo($alice2));
        assertEquals(-1, $alice1->compareTo($bob1));
        assertEquals(-1, $bob1->compareTo($bob2));
        assertEquals(1, $bob1->compareTo($alice1));
        assertEquals(1, $bob2->compareTo($bob1));
    }

    function testCaseCompareTo() {
        $alice1 = s('Alice');
        $alice2 = s('alice');
        $bob1 = s('Bob');
        $bob2 = s('bob');
        $bob3 = 'bob';

        assertEquals(0, $alice1->caseCompareTo($alice2));
        assertEquals(-1, $alice2->caseCompareTo($bob1));
        assertEquals(-1, $alice2->caseCompareTo($bob2));
        assertEquals(-1, $alice2->caseCompareTo($bob3));
        assertEquals(1, $bob1->caseCompareTo($alice1));
        assertEquals(1, $bob2->caseCompareTo($alice1));
    }
}
