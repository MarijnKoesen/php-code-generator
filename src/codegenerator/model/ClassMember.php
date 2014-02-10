<?php
namespace codegenerator\model;

/**
 * A class representing a class member, like 'private User $user'
 */

class ClassMember
{
    const MEMBER_TYPE_PROPERTY = 'property';
    const MEMBER_TYPE_FUNCTION = 'function';
    const MEMBER_TYPE_GETTER = 'setter';
    const MEMBER_TYPE_SETTER = 'getter';
    /**
     * DATASTRING
     *
     * name:protected:string
     * type:protected:string
     * access:protected:string
     * memberType:protected:string
     */

    /**
     * GENERATED PROPERTIES
     */


    /**
     * @var string
     */
    protected $access;

    /**
     * @var string
     */
    protected $memberType;

    /**
     * @var string
     */
    protected $name;

    /**
     * Get the type: function, property, getter, setter
     * @var string
     */
    protected $type;


    /**
     * GENERATED GETTERS/SETTERS
     */

    /**
     * Get access.
     *
     * @return string The access
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Get memberType. E.g. string, int, Lap, Laps[]
     *
     * @return string The memberType
     */
    public function getMemberType()
    {
        return $this->memberType;
    }

    /**
     * Get name.
     *
     * @return string The name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get type.
     *
     * @return string The type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set access.
     *
     * @param string $access The access
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * Set memberType.
     *
     * @param string $memberType The memberType
     */
    public function setMemberType($memberType)
    {
        $this->memberType = $memberType;
    }

    /**
     * Set name.
     *
     * @param string $name The name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set type.
     *
     * @param string $type The type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}