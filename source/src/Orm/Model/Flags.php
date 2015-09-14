<?php
namespace Orm\Model;

class Flags {
    const INT_LENGTH = 32;

    /**
     * @var array
     */
    protected $mask = [];

    /**
     * @param int $bit
     * @return self
     */
    public function setBit($bit) {
        list($indexBit, $indexKey) = $this->getBitAndKey($bit);

        if (!isset($this->mask[$indexKey])) {
            $this->mask[$indexKey] = 0;
        }

        $key = $this->mask[$indexKey];
        $this->setValueBit($key, $indexBit);
        $this->mask[$indexKey] = $key;

        return $this;
    }

    /**
     * @param int $bit
     * @return bool
     */
    public function isBitSet($bit) {
        list($indexBit, $indexKey) = $this->getBitAndKey($bit);

        if (!isset($this->mask[$indexKey])) {
            return false;
        }

        return $this->isSetValueBit($this->mask[$indexKey], $indexBit);
    }

    /**
     * @param int $bit
     * @return self
     */
    public function unsetBit($bit) {
        list($indexBit, $indexKey) = $this->getBitAndKey($bit);

        if (isset($this->mask[$indexKey])) {
            $key = $this->mask[$indexKey];
            $this->unsetValueBit($key, $indexBit);
            $this->mask[$indexKey] = $key;
        }

        return $this;
    }

    /**
     * Возвращает массив для сериализации
     * @return array
     */
    public function serialize() {
        return $this->mask;
    }

    /**
     * @param array $mask
     */
    public function unserialize(array $mask) {
        $this->mask = $mask;
    }

    /**
     * @param int $bit
     * @return array
     */
    protected function getBitAndKey($bit) {
        return array($bit % self::INT_LENGTH, (int) ($bit / self::INT_LENGTH));
    }

    /**
     * @param int $value
     * @param int $bit
     * @return bool
     */
    private function isSetValueBit($value, $bit) {
        return (bool) ($value & (1 << $bit));
    }

    /**
     * @param int $value
     * @param int $bit
     * @return void
     */
    private function setValueBit(&$value, $bit) {
        $value |= 1 << $bit;
    }

    /**
     * @param int $value
     * @param int $bit
     * @return void
     */
    private function unsetValueBit(&$value, $bit) {
        $value &= ~(1 << $bit);
    }
}