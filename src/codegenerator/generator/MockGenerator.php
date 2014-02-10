<?php
namespace codegenerator\generator;


use codegenerator\model\ClassEntity;
use codegenerator\model\ClassMember;

class MockGenerator extends AbstractGenerator
{
    public function generateCode(ClassEntity $entity=null)
    {
        if (!$entity) {
            return "Submit your class definition first.";
        }

        $code  = "<h2>Instance creation:</h2>\n\n";
        $code .= '<pre class="brush: php">' . $this->generateInstanceCreation($entity) . '</pre><br>';

        $code .= "<h2>Array creation:</h2>\n\n";
        $code .= '<pre class="brush: php">' . $this->generateArrayCreation($entity) . '</pre><br>';

        $code .= "<h2>JSON creation:</h2>\n\n";
        $code .= '<pre>' . $this->generateJsonCreation($entity) . '</pre>';

        return $code;
    }

    public function getName()
    {
        return 'Mockers';
    }

    public function generateInstanceCreation(ClassEntity $entity)
    {
        $code = array();
        $code[] = sprintf('$%s = new %s();', lcFirst($entity->getName()), $entity->getName());

        $members = $entity->getMembers();
        foreach($members as $member) {
            if ($member->getType() != 'property') {
                continue;
            }

            $code[] = sprintf('$%s->set%s();', lcFirst($entity->getName()), ucfirst($member->getName()));
        }

        return implode("\n", $code);
    }

    public function generateArrayCreation(ClassEntity $entity)
    {
        $code = array();
        $code[] = sprintf('$%s = array(', lcFirst($entity->getName()));

        $members = $entity->getMembers();
        foreach($members as $member) {
            if ($member->getType() != 'property') {
                continue;
            }

            $code[] = sprintf("%s'%s' => %s,",
                $this->getIndentation(),
                $member->getName(),
                preg_match('|' . preg_quote('[]') . '|', $member->getMemberType()) ? 'array()' : "''"
            );
        }

        $code[] = ');';

        return implode("\n", $code);

    }

    public function generateJsonCreation(ClassEntity $class)
    {
        $array = array();
        foreach($class->getMembers() as $member) {
            if ($member->getType() != ClassMember::MEMBER_TYPE_PROPERTY) {
                continue;
            }

            switch($member->getMemberType()) {
                case 'int':
                case 'integer':
                case 'numeric':
                    $value = 0;
                    break;

                case 'DateTime':
                    $value = date("Y-m-d H:i:s");
                    break;

                case 'double':
                case 'float':
                    $value = 0.0;
                    break;

                case 'string':
                    $value = '';
                    break;

                case 'boolean':
                    $value = true;
                    break;

                default:
                    $value = null;
            }

            if (preg_match('|\[\]|', $member->getMemberType())) {
                $value = array();
            }

            $array[$member->getName()] = $value;
        }

        $html = json_encode($array, JSON_PRETTY_PRINT);
        return $html;
    }
}
