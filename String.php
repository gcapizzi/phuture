<?php

class Phuture_String implements ArrayAccess, Countable
{
    private $_value = '';

    function __construct($value = '') {
        $this->_value = $value;
    }

    function getValue() {
        return $this->_value;
    }

    function setValue($value) {
        $this->_value = strval($value);
    }

    function __toString() {
        return $this->_value;
    }

    function isEmpty() {
        return empty($this->_value);
    }

    function length() {
        return strlen($this->_value);
    }

    function clear() {
        $this->_value = '';
    }

    // Access

    private function _offset($index) {
        return $index >= 0 ? $index : $this->length() + $index;
    }

    function get($index, $to = null) {
        if ($to === null) {
            // using substr() we can avoid using _offset (slower)
            return new self(substr($this->_value, $index, 1));
        } else {
            $from = $this->_offset($index);
            $to   = $this->_offset($to);

            if ($to > $from) {
                return new self(substr($this->_value, $from,
                                       $to - $from + 1));
            } else {
                return new self('');
            }
        }
    }

    function set($index, $value) {
        $this->_value[$this->_offset($index)] = $value;
    }

    function delete($index) {
        $i = $this->_offset($index);
        return new self(substr($this->_value, 0, $i) .
                        substr($this->_value, $i + 1));
    }

    function getByte($index) {
        return ord($this->_value[$this->_offset($index)]);
    }

    function setByte($index, $value) {
        $this->_value[$this->_offset($index)] = chr($value);
    }

    function substring($from, $length = null) {
        if ($length === null) {
            return new self(substr($this->_value, $from));
        } else {
            return new self(substr($this->_value, $from, $length));
        }
    }

    // ArrayAccess

    function offsetExists($offset) {
        return $offset >= -$this->length() && $offset < $this->length();
    }

    function offsetGet($offset) {
        return $this->get($offset);
    }

    function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }

    function offsetUnset($offset) {
        $this->_value = $this->delete($offset)->getValue();
    }

    // Countable interface

    function count() {
        return $this->length();
    }

    // Concatenation

    function append($suffix) {
        return new self($this->_value . $suffix);
    }

    function prepend($prefix) {
        return new self($prefix . $this->_value);
    }

    // Case manipulation

    function uppercase() {
        return new self(strtoupper($this->_value));
    }

    function lowercase() {
        return new self(strtolower($this->_value));
    }

    function capitalize() {
        return new self(ucfirst($this->_value));
    }

    function capitalizeWords() {
        return new self(ucwords($this->_value));
    }

    function swapCase() {
        $result = '';

        for ($i = 0; $i < strlen($this->_value); $i++) {
            $char = $this->_value[$i];
            $result .= ctype_upper($char) ? strtolower($char)
                                          : strtoupper($char);
        }

        return new self($result);
    }

    // String type

    function isUppercase() {
        // Shortcuts
        if ($this->length() == 0) { return false; }
        if ($this->length() == 1 || $this->isAlpha()) {
            return ctype_upper($this->_value);
        }

        $cased = false;
        for ($i = 0; $i < strlen($this->_value); $i++) {
            $char = $this->_value[$i];

            if (ctype_lower($char)) {
                return false;
            } else if (!$cased && ctype_upper($char)) {
                $cased = true;
            }
        }
        return $cased;
    }

    function isLowercase() {
        // Shortcuts
        if ($this->length() == 0) { return false; }
        if ($this->length() == 1 || $this->isAlpha()) {
            return ctype_lower($this->_value);
        }

        $cased = false;
        for ($i = 0; $i < strlen($this->_value); $i++) {
            $char = $this->_value[$i];

            if (ctype_upper($char)) {
                return false;
            } else if (!$cased && ctype_lower($char)) {
                $cased = true;
            }
        }
        return $cased;
    }

    function isAlphanumeric() { return ctype_alnum($this->_value); }
    function isAlpha()        { return ctype_alpha($this->_value); }
    function isNumeric()      { return ctype_digit($this->_value); }
    function isSpace()        { return ctype_space($this->_value); }

    // Trimming

    function trim($chars = null) {
        return new self($chars === null ? trim($this->_value)
                                        : trim($this->_value, $chars));
    }

    function trimLeft($chars = null) {
        return new self($chars === null ? ltrim($this->_value)
                                        : ltrim($this->_value, $chars));
    }

    function trimRight($chars = null) {
        return new self($chars === null ? rtrim($this->_value)
                                        : rtrim($this->_value, $chars));
    }

    function chop($chars = null) {
        return $this->trimRight($chars);
    }

    // String content

    function startsWith($start) {
        return strpos($this->_value, strval($start)) === 0;
    }

    function endsWith($end) {
        return substr($this->_value, $this->length() - strlen($end)) == $end;
    }

    function find($substring, $offset = 0) {
        return strpos($this->_value, strval($substring), $offset);
    }

    function caseFind($substring, $offset = 0) {
        return stripos($this->_value, strval($substring), $offset);
    }

    function findRight($substring, $offset = 0) {
        return strrpos($this->_value, strval($substring), $offset);
    }

    function caseFindRight($substring, $offset = 0) {
        return strripos($this->_value, strval($substring), $offset);
    }

    // Replacement

    function replace($old, $new) {
        return new self(str_replace($old, $new, $this->_value));
    }

    function caseReplace($old, $new) {
        return new self(str_ireplace($old, $new, $this->_value));
    }

    // Padding

    function padLeft($length, $string = ' ') {
        return new self(str_pad($this->_value, $length, $string,
                                STR_PAD_LEFT));
    }

    function padRight($length, $string = ' ') {
        return new self(str_pad($this->_value, $length, $string,
                                STR_PAD_RIGHT));
    }

    function padBoth($length, $string = ' ') {
        return new self(str_pad($this->_value, $length, $string,
                                STR_PAD_BOTH));
    }

    function center($length, $string = ' ') {
        return $this->padBoth($length, $string);
    }

    // Other manipulation functions

    function reverse() {
        return new self(strrev($this->_value));
    }

    function repeat($times) {
        return new self(str_repeat($this->_value, $times));
    }

    function insert($index, $string) {
        return new self(substr($this->_value, 0, $index) . $string .
                        substr($this->_value, $index));
    }

    function join($pieces) {
        return new self(implode($this->_value, $pieces));
    }
}

function s($string) { return new Phuture_String($string); }
