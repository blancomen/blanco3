<?php
namespace Orm;

use LogicException;
use Orm\Model\Counters;
use Orm\Model\FieldType;
use Orm\Model\Flags;

abstract class Entity {
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Return config data as array.
     * Example:
     * <code>
     * return [
     *   'a' => [
     *     'type' => FieldType::INT,
     *     'default' => 0,
     *   ],
     *   'b' => [
     *     'type' => FieldType::STRING,
     *     'default' => 'Hello',
     *   ],
     * ];
     * </code>
     * @see FieldType
     * @return array
     */
    abstract protected function getDataConfig();

    /**
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value) {
        $this->data[$field] = $value;
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    public function get($field) {
        if (array_key_exists($field, $this->data)) {
            return $this->data[$field];
        }

        return $this->getFieldDefault($field);
    }

    /**
     * @param string $field
     * @return Counters
     */
    public function getCounters($field) {
        if ($this->getFieldType($field) != FieldType::COUNTERS) {
            throw new LogicException("Field {$field} is not a {FieldType::COUNTERS} type");
        }

        return $this->get($field);
    }

    /**
     * @param string $field
     * @return Flags
     */
    public function getFlags($field) {
        if ($this->getFieldType($field) != FieldType::FLAGS) {
            throw new LogicException("Field {$field} is not a {FieldType::FLAGS} type");
        }

        return $this->get($field);
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    protected function getFieldDefault($field) {
        try {
            return $this->getFieldConfig($field, 'default');
        } catch (LogicException $Ex) {
            $type = $this->getFieldType($field);
            return FieldType::getDefaultValue($type);
        }
    }

    /**
     * @param string $field
     * @return array
     */
    protected function getFieldType($field) {
        return $this->getFieldConfig($field, 'type');
    }

    /**
     * @param string $field
     * @param string|null $configField
     * @return array
     */
    protected function getFieldConfig($field, $configField = null) {
        $config = $this->getDataConfig();

        if (array_key_exists($field, $config)) {
            if (!is_null($configField)) {
                if (array_key_exists($configField, $config[$field])) {
                    return $config[$field][$configField];
                }

                throw new LogicException("Not found config field {$configField} for data field {$field}");
            }

            return $config[$field];
        }

        return [];
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = [];
        foreach ($this->data as $field => $value) {
            $type = $this->getFieldType($field);

            $data[$field] = FieldType::serialize($type, $value);
        }

        return $data;
    }

    /**
     * @param array $serialized
     * @return void
     */
    public function unserialize($serialized) {
        $data = [];
        foreach ($serialized as $field => $value) {
            $type = $this->getFieldType($field);

            $data[$field] = FieldType::unserialize($type, $value);
        }

        $this->data = $data;
    }
}