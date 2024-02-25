<?php

namespace Bagene\PhPayments\Requests;

abstract class AbstractModel
{
    /**
     * @param Object|null $object
     * @return array<string, mixed>
     */
    public function toArray(?Object $object = null): array
    {
        if ($object === null) {
            $object = $this;
        }
        $reflection = new \ReflectionClass(get_class($object));
        $result = [];
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            if (
                $method->isConstructor()
                || $method->isAbstract()
                || $method->isStatic()
                || 'toArray' === $methodName
                || 'getBody' === $methodName
                || 'getHeaders' === $methodName
            ) {
                continue;
            }

            $key = lcfirst(ltrim($methodName, 'get'));
            $value = $object->$methodName();

            if (is_object($value)) {
                $value = $this->toArray($value);
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
