<?php
/**
 * DTArrayObject.php
 * @package   myMVC
 * @copyright ueffing.net
 * @author    Guido K.B.W. Üffing <info@ueffing.net>
 * @license   GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $MVCDataType
 */

namespace MVC\DataType;

use MVC\Helper;

class DTArrayObject
{
    const DTHASH = '75575fbb25ada598d5a34e03168fbfa7';

    /**
     * @var \MVC\DataType\DTKeyValue[]
     */
    protected $aKeyValue;

    /**
     * ArrayObject constructor.
     * @param array $aData
     */
    public function __construct(array $aData = array())
    {
        $this->aKeyValue = array();

        foreach ($aData as $sKey => $mValue)
        {
            $sMethod = 'set_' . $sKey;

            if (method_exists($this, $sMethod))
            {
                $this->$sMethod($mValue);
            }
            else
            {
                $this->add_aKeyValue(DTKeyValue::create()
                    ->set_sKey($sKey)
                    ->set_sValue($mValue));
            }
        }
    }

    /**
     * @param array $aData
     * @return DTArrayObject
     */
    public static function create(array $aData = array())
    {
        $oObject = new self($aData);

        return $oObject;
    }

    /**
     * @param array $aValue
     * @return $this
     */
    public function set_aKeyValue($aValue)
    {
        foreach ($aValue as $mKey => $aData)
        {
            if (false === ($aData instanceof \MVC\DataType\DTKeyValue))
            {
                $aValue[$mKey] = new \MVC\DataType\DTKeyValue($aData);
            }
        }

        $this->aKeyValue = $aValue;

        return $this;
    }

    /**
     * @param \MVC\DataType\DTKeyValue $mValue
     * @return $this
     */
    public function add_aKeyValue(\MVC\DataType\DTKeyValue $mValue)
    {
        $this->aKeyValue[] = $mValue;

        return $this;
    }

    /**
     * @return \MVC\DataType\DTKeyValue[]
     */
    public function get_aKeyValue()
    {
        return $this->aKeyValue;
    }

    /**
     * @return string
     */
    public static function getPropertyName_aKeyValue()
    {
        return 'aKeyValue';
    }

    /**
     * overrides an existing DTKeyValue Object or adds for new if it does not exist.
     * if parameter $bUnset = true, the DTKeyValue match entry will be deleted
     * @param \MVC\DataType\DTKeyValue|null $oDTKeyValueNew
     * @param bool                          $bUnset
     * @return $this
     */
    function setDTKeyValueByKey(DTKeyValue $oDTKeyValueNew = null, $bUnset = false)
    {
        if (null === $oDTKeyValueNew)
        {
            return $this;
        }

        $oDTKeyValueOld = $this->getDTKeyValueByKey($oDTKeyValueNew->get_sKey());

        // override
        if (true === isset($this->aKeyValue[$oDTKeyValueOld->get_iIndex()]))
        {
            if (false === $bUnset)
            {
                $oDTKeyValueNew->set_iIndex($oDTKeyValueOld->get_iIndex());
                $this->aKeyValue[$oDTKeyValueOld->get_iIndex()] = $oDTKeyValueNew;
            }
            else
            {
                $this->aKeyValue[$oDTKeyValueOld->get_iIndex()] = null;
                unset($this->aKeyValue[$oDTKeyValueOld->get_iIndex()]);
            }
        }
        // add
        else
        {
            if (false === $bUnset)
            {
                $this->add_aKeyValue($oDTKeyValueNew);
            }
        }

        return $this;
    }

    /**
     * @param string             $sKey
     * @param DTArrayObject|null $oDTArrayObject optional another $oDTArrayObject
     * @return DTKeyValue
     */
    function getDTKeyValueByKey($sKey = '', DTArrayObject $oDTArrayObject = null)
    {
        if (null === $oDTArrayObject)
        {
            $oDTArrayObject = $this;
        }

        foreach ($oDTArrayObject->get_aKeyValue() as $iKey => $oDTKeyValue)
        {
            if ($sKey === $oDTKeyValue->get_sKey())
            {
                $oDTKeyValue->set_iIndex($iKey);
                return $oDTKeyValue;
            }
        }

        return DTKeyValue::create();
    }

    /**
     * @return false|string JSON
     */
    public function __toString()
    {
        return $this->getPropertyJson();
    }

    /**
     * @return false|string
     */
    public function getPropertyJson()
    {
        return json_encode($this->getPropertyArray());
    }

    /**
     * @return array
     */
    public function getPropertyArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getConstantArray()
    {
        $oReflectionClass = new \ReflectionClass($this);
        $aConstant = $oReflectionClass->getConstants();

        return $aConstant;
    }

    /**
     * @return $this
     */
    public function flushProperties()
    {
        foreach ($this->getPropertyArray() as $sKey => $aValue)
        {
            $sMethod = 'set_' . $sKey;

            if (method_exists($this, $sMethod))
            {
                $this->$sMethod('');
            }
        }

        return $this;
    }

    /**
     * @return string JSON
     */
    public function getDataTypeConfigJSON()
    {
        return '{"name":"ArrayObject","file":"ArrayObject.php","extends":"","namespace":"MVC\\\\DataType","constant":[],"property":[{"key":"aKeyValue","var":"\\\\MVC\\\\DataType\\\\DTKeyValue[]","value":"array()","visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true}],"createHelperMethods":true}';
    }

}
