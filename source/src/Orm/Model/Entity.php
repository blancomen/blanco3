<?php
namespace Orm;

use Exception;
use Kernel\Kernel;
use LogicException;
use Orm\Entity\Counters;
use Orm\Entity\FieldParam;
use Orm\Entity\FieldType;
use Orm\Entity\Flags;
use Orm\Repository\AbstractRepository;

abstract class Entity {
    /**
     * Entity data id
     */
    const FIELD_ID = 'id';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = []) {
        $this->unserialize($data);
    }

    /**
     * Return config data as array.
     * Example:
     * <code>
     * return [
     *   'a' => [
     *     FieldParam::TYPE => FieldType::INT,
     *     FieldParam::DEFAULT_VALUE => 0,
     *   ],
     *   'b' => [
     *     FieldParam::TYPE => FieldType::STRING,
     *     FieldParam::DEFAULT_VALUE => 'Hello',
     *   ],
     * ];
     * </code>
     * @see FieldType
     * @return array
     */
    abstract protected function getDataConfig();

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value) {
        $this->filterValue($field, $value);
        $this->data[$field] = $value;
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    public function get($field) {
        if (!array_key_exists($field, $this->data)) {
            $this->data[$field] = $this->getFieldDefault($field);
        }

        return $this->data[$field];
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
        $config = $this->getEntityFieldsConfig();

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
     * @return array
     */
    public function export() {
        $data = [];
        foreach ($this->data as $field => $value) {
            $type = $this->getFieldType($field);
            $data[$field] = FieldType::export($type, $value);
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

    /**
     * @return int
     */
    public function getId() {
        return $this->get(self::FIELD_ID);
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->set(self::FIELD_ID, $id);
    }

    /**
     * @return array
     */
    protected function getEntityFieldsConfig() {
        $config = $this->getDataConfig();

        $config[self::FIELD_ID] = [
            FieldParam::TYPE => FieldType::INT,
            FieldParam::DEFAULT_VALUE => 0,
        ];

        return $config;
    }

    /**
     * @return AbstractRepository
     */
    public function getRepository() {
        return Kernel::getInstance()->getOrmProvider()->getRepositoryByType($this->getType());
    }

    /**
     * @throws Exception
     */
    public function load() {
        if (!$this->getId()) {
            throw new Exception("Can not load entity without id");
        }

        $data = $this->getRepository()->loadDataById($this->getId());
        $this->unserialize($data);
    }

    /**
     * @return int
     */
    public function save() {
        // todo lock
        return $this->getRepository()->save($this);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @throws LogicException
     */
    protected function filterValue($field, $value) {
        $type = $this->getFieldType($field);

        if ($type == FieldType::ENTITY && $value) {
            if (!($value instanceof Entity)) {
                throw new LogicException("Value for field {$field} must extend " . Entity::class);
            }

            if (!$value->getId()) {
                throw new LogicException("Entity for field {$field} must be saved");
            }

            try {
                $entityType = $this->getFieldConfig($field, FieldParam::ENTITY_TYPE);
            } catch (LogicException $Ex) {
                $entityType = null;
            }

            if (!is_null($entityType)) {
                if ($value->getType() != $entityType) {
                    throw new LogicException("Value for field {$field} must be {$entityType}");
                }
            }
        }
    }
}