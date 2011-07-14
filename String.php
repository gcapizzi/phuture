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
        $this->_value[$this->_offset($index)] = strval($value);
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

    function isUppercase()    { return ctype_upper($this->_value); }
    function isLowercase()    { return ctype_lower($this->_value); }
    function isAlphanumeric() { return ctype_alnum($this->_value); }
    function isAlpha()        { return ctype_alpha($this->_value); }
    function isNumeric()      { return ctype_digit($this->_value); }
    function isSpace()        { return ctype_space($this->_value); }

    // Trimming

    function trim($chars = null) {
        return new self($chars === null ? trim($this->_value)
                                        : trim($this->_value, $chars));
    }

    function ltrim($chars = null) {
        return new self($chars === null ? ltrim($this->_value)
                                        : ltrim($this->_value, $chars));
    }

    function rtrim($chars = null) {
        return new self($chars === null ? rtrim($this->_value)
                                        : rtrim($this->_value, $chars));
    }

    function chop($chars = null) {
        return $this->rtrim($chars);
    }

    // String content

    function startsWith($start) {
        return substr($this->_value, 0, strlen($start)) == $start;
    }

    function endsWith($end) {
        return substr($this->_value, $this->length() - strlen($end)) == $end;
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
}

function s($string) { return new Phuture_String($string); }
