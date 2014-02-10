<?php
namespace html;


use model\ClassEntity;

class DoctrineGenerator extends AbstractGenerator
{
    public function generateCode(ClassEntity $entity=null)
    {
        $html = '<pre>';

        $html .= '$ php app/console doctrine:generate:entity --entity="YourBundle:Category" --fields="';

        foreach($entity->getMembers() as $member) {
            if ($member->getType() == \model\ClassMember::MEMBER_TYPE_PROPERTY) {
                $html .= $member->getName() . ':' . $member->getMemberType(). " ";
            }
        }

        $html .= '"</pre>';
        $html .= "<br>Or:<br><br><pre>";

        $html .= '$html .= $ php app/console doctrine:generate:entity --entity="YourBundle:Category" --fields="' . "\n\t";

        foreach($entity->getMembers() as $member) {
            if ($member->getType() == \model\ClassMember::MEMBER_TYPE_PROPERTY) {
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