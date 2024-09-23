<?php

namespace App\Services;

class Platforms
{
    protected $keys = [];
    protected $mapKeys = [];
    
    public function getPlatforms()
    {
        return [
            'NewsOrg',
            'Guardian',
            'NyTimes',
        ];
    }

    /**
     * Transform array or object keys based on given mappings.
     *
     * @param mixed $data The array or object to transform.
     * @param array $keyMappings The key mappings to apply.
     * @return mixed The transformed array or object.
     */
    public function transformKeys($data, array $keyMappings = [])
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $newKey = array_key_exists($key, $keyMappings) ? $keyMappings[$key] : $key;
                $result[$newKey] = is_array($value) || is_object($value) ? $this->transformKeys($value, $keyMappings) : $value;
            }
            return $result;
        } elseif (is_object($data)) {
            $result = new \stdClass();
            foreach ($data as $key => $value) {
                $newKey = array_key_exists($key, $keyMappings) ? $keyMappings[$key] : $key;
                $result->$newKey = is_array($value) || is_object($value) ? $this->transformKeys($value, $keyMappings) : $value;
            }
            return $result;
        } else {
            return $data;
        }
    }

    /**
     * Filter array or object based on given keys.
     *
     * @param mixed $data The array or object to filter.
     * @param array $keys The keys to keep.
     * @return mixed The filtered array or object.
     */
    public function filterKeys($data, array $keys = [])
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $keys)) {
                    $result[$key] = is_array($value) || is_object($value) ? $this->filterKeys($value, $keys) : $value;
                }
                if(is_numeric($key)) {
                    $result[] = is_array($value) || is_object($value) ? $this->filterKeys($value, $keys) : $value;
                }
            }
            return $result;
        } elseif (is_object($data)) {
            $result = new \stdClass();
            foreach ($data as $key => $value) {
                if (in_array($key, $keys)) {
                    $result->$key = is_array($value) || is_object($value) ? $this->filterKeys($value, $keys) : $value;
                }
            }
            return $result;
        } else {
            return $data;
        }
    }

    /**
     * Create a response by transforming and filtering keys.
     *
     * @param array $data The data to process.
     * @return array The processed data.
     */
    protected function createResponse($data)
    {
        $transformedData = $this->transformKeys($data, $this->mapKeys);
        $filteredData = array_map(function ($item) {
            return $this->filterKeys($item, $this->keys);
        }, $transformedData);
        return $filteredData;
    }
}