<?php

namespace Izie\Kinvey;

class Query
{
    protected $_query = array();

    /**
     * @return array
     */
    public function getQuery()
    {
        $url = array();

        if (isset($this->_query['filters'])) {
            $query = [];
            foreach ($this->_query['filters'] as $value)  {
                $query[] = "\"".key($value).'":'.$value[key($value)];
            }
            $url['query'] = '{' . implode(',', $query) . '}';
        } else {
            $url['query'] = '{}';
        }

        if (isset($this->_query['modifiers'])) {
            $url += $this->_query['modifiers'];
        }

        return http_build_query($url);
    }

    /**
     * @param array $query
     */
    public function setQuery($query)
    {
        $this->_query = $query;
    }

    public function createQueryElement($key)
    {
        $this->_query[$key] = array();
    }

    public function addQueryFilter($filter)
    {
        if (empty($this->_query['filters'])) {
            $this->_query['filters'] = array();
        }
        $this->_query['filters'][] = $filter;
    }

    public function addQueryModifier($modifier)
    {
        if (empty($this->_query['modifiers'])) {
            $this->_query['modifiers'] = array();
        }
        $this->_query['modifiers'] += $modifier;
    }

    public function hasQueryKey($key)
    {
        return isset($this->_query[$key]);
    }

    public function equalTo($field, $value)
    {
        if (is_string($value)) {
            $value = "\"".$value."\"";
        } elseif (is_bool($value)) {
            $value = $value?'true':'false';
        }
        $this->addQueryFilter(array($field => $value));
        return $this;
    }

    public function greaterThan($field, $value)
    {
        $data = array('$gt' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function greaterThanOrEqualTo($field, $value)
    {
        $data = array('$gte' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function lessThan($field, $value)
    {
        $data = array('$lt' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function lessThanOrEqualTo($field, $value)
    {
        $data = array('$lte' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function notEqualTo($field, $value)
    {
        $data = array('$ne' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function exists($field, $value)
    {
        $data = array('$exists' => $value?true:false);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function notIn($field, $value)
    {
        $data = array('$nin' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function in($field, $value)
    {
        $data = array('$in' => $value);
        $this->addQueryFilter(array($field => json_encode($data)));
        return $this;
    }

    public function mod($attribute, $value)
    {
        $this->_setOperatorValueQuery('mod', $attribute, $value);
        return $this;
    }

    public function matches($attribute, $value)
    {
        $this->_setOperatorValueQuery('matches', $attribute, $value);
        return $this;
    }

    public function contains($attribute, $value)
    {
        $this->_setOperatorValueQuery('contains', $attribute, $value);
        return $this;
    }

    public function containsAll($attribute, $value)
    {
        $this->_setOperatorValueQuery('containsAll', $attribute, $value);
        return $this;
    }

    public function notContainedIn($attribute, $value)
    {
        $this->_setOperatorValueQuery('notContainedIn', $attribute, $value);
        return $this;
    }

    public function size($attribute, $value)
    {
        $this->_setOperatorValueQuery('size', $attribute, $value);
        return $this;
    }

    public function fields(array $value)
    {
        $data = implode(',', $value);
        $this->addQueryModifier(array('fields' => $data));
        return $this;
    }

    public function limit($value)
    {
        $this->addQueryModifier(array('limit' => "$value"));
        return $this;
    }

    public function skip($value)
    {
        $this->addQueryModifier(array('skip' => "$value"));
        return $this;
    }

    public function ascending($field)
    {
        $this->addQueryModifier(array('sort' => "$field"));
        return $this;
    }

    public function descending($field)
    {
        $data = array($field => -1);
        $this->addQueryModifier(array('sort' => json_encode($data)));
        return $this;
    }

    protected function _setOperatorValueQuery($operator)
    {
    }
}