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

    function get($index) {
        return new self($this->_value[$this->_offset($index)]);
    }

    function set($index, $value) {
        $this->_value[$index] = strval($value);
    }

    function delete($index) {
        $this->_value = substr($this->_value, 0, $index) .
                        substr($this->_value, $index + 1);
    }

    function getByte($index) {
        return ord($this->_value[$this->_offset($index)]);
    }

    function setByte($index, $value) {
        $this->_value[$this->_offset($index)] = chr($value);
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
        $this->delete($offset);
    }

    // Countable

    function count() {
        return $this->length();
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

    // Trimming

    function trim($chars = '') {
        return new self(empty($chars) ? trim($this->_value)
                                      : trim($this->_value, $chars));
    }

    function ltrim($chars = '') {
        return new self(empty($chars) ? ltrim($this->_value)
                                      : ltrim($this->_value, $chars));
    }

    function rtrim($chars = '') {
        return new self(empty($chars) ? rtrim($this->_value)
                                      : rtrim($this->_value, $chars));
    }

    function chop($chars = '') {
        return $this->rtrim($chars);
    }

    // Other String manipulation functions

    function reverse() {
        return new self(strrev($this->_value));
    }

    function repeat($times) {
        return new self(str_repeat($this->_value, $times));
    }
}

function s($string) { return new Phuture_String($string); }
