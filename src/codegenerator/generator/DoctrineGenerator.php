<?php
namespace codegenerator\generator;


use codegenerator\model\ClassEntity;
use codegenerator\model\ClassMember;

class DoctrineGenerator extends AbstractGenerator
{
    public function generateCode(ClassEntity $entity=null)
    {
        if (!$entity) {
            return "Submit your class definition first.";
        }

        $html = '<pre>';
        $html .= '$ php app/console doctrine:generate:entity --entity="YourBundle:Category" --fields="';

        foreach($entity->getMembers() as $member) {
            if ($member->getType() == ClassMember::MEMBER_TYPE_PROPERTY) {
                $html .= $member->getName() . ':' . $member->getMemberType(). " ";
            }
        }

        $html .= '"</pre>';
        $html .= "<br>Or:<br><br><pre>";

        $html .= '$html .= $ php app/console doctrine:generate:entity --entity="YourBundle:Category" --fields="' . "\n\t";

        foreach($entity->getMembers() as $member) {
            if ($member->getType() == ClassMember::MEMBER_TYPE_PROPERTY) {
                $html .= $member->getName() . ':' . $member->getMemberType(). " \\ \n\t";
            }
        }

        $html .= '"';
        return $html;
    }

    public function getName()
    {
        return 'Doctrine';
    }
}
