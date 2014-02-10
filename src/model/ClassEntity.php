<?php
namespace model;

use Request;


class ClassEntity
{
    /**
     * DATASTRING: ClassEntity
     *
     * members:protected:ClassMember[]
     * name:protected:string
     */

    /**
     * GENERATED PROPERTIES
     */

    /**
     * @var ClassMember[]
     */
    protected $members;

    /**
     * @var string
     */
    protected $name;


    /**
     * GENERATED GETTERS/SETTERS
     */

    /**
     * Set the members
     *
     * @param ClassMember[] $members The members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }


    /**
     * Get the members
     *
     * @return ClassMember[] The members
     */
    public function getMembers()
    {
        return $this->members;
    }


    /**
     * Set the name
     *
     * @param string $name The name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * Get the name
     *
     * @return string The name
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * END GENERATED GETTERS/SETTERS
     */





    public static function fromRequest(Request $request)
    {
        if ($request->hasPost() && $request->getPostItem('submit') == 'From DataString') {
            $expression = '([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*(\[\])?)';  // php's expression syntax: http://www.php.net/manual/en/language.oop5.basic.php, modified with optional []
            if (preg_match_all('~[*\s]+' . $expression . ':' . $expression . '(:' . $expression . ')?+~', $request->getPostItem('datastring'), $matches)) {
                $vars = $matches[1];
                $types = $matches[3];
                $scopes = $matches[6];

                $entity = new ClassEntity();
                $members = self::getMembersFor($vars, $scopes, $types);
                $entity->setMembers($members);

                if (preg_match("/DATASTRING: ([a-zA-Z]+)/", $request->getPostItem('datastring'), $nameMatch)) {
                    $entity->setName($nameMatch[1]);
                }

                return $entity;
            }
        }
    }

    protected static function getMembersFor($vars, $scopes, $types) {
        if (count($vars) != count($scopes)) {
            echo "DE tekst areas hebben niet evenveel rijen..";
            return;
        }

        $entities = array();
        for($i = 0; $i < count($vars); $i++) {
            if (empty($scopes[$i])) {
                $scopes[$i] = "private";
            }

            if (trim($vars[$i]) != "") {
                switch($types[$i]) {
                    case 'function':
                        $member = new ClassMember();
                        $member->setAccess($scopes[$i]);
                        $member->setName($vars[$i]);
                        $member->setType('function');
                        $member->setMemberType($types[$i]);
                        $entities[] = $member;
                        break;

                    default:
                        $member = new ClassMember();
                        $member->setAccess($scopes[$i]);
                        $member->setName($vars[$i]);
                        $member->setType('property');
                        $member->setMemberType($types[$i]);
                        $entities[] = $member;

                        $member = new ClassMember();
                        $member->setAccess('public');
                        $member->setName($vars[$i]);
                        $member->setType('getter');
                        $member->setMemberType($types[$i]);
                        $entities[] = $member;

                        $member = new ClassMember();
                        $member->setAccess('public');
                        $member->setName($vars[$i]);
                        $member->setType('setter');
                        $member->setMemberType($types[$i]);
                        $entities[] = $member;

                        break;
                }
            }
        }
        //usort($entities, array('\model\ClassEntity', 'order'));

        return $entities;
    }

    protected static function order(ClassMember $a, ClassMember $b)
    {
        $keyA = ($a->getType() == 'property' ? 1 : 2) . $a->getName();
        $keyB = ($b->getType() == 'property' ? 1 : 2) . $b->getName();

        return $keyA > $keyB;
    }
}
