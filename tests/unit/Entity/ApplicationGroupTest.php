<?php

namespace Test\Fei\Service\Connect\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Service\Connect\Common\Entity\Application;
use Fei\Service\Connect\Common\Entity\ApplicationGroup;
use Fei\Service\Connect\Common\Entity\Attribution;
use Fei\Service\Connect\Common\Entity\Role;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationGroupTest
 *
 * @package Test\Fei\Service\Connect\Entity
 */
class ApplicationGroupTest extends TestCase
{
    public function testNameAccessors()
    {
        $application = new ApplicationGroup();

        $application->setName('test');

        $this->assertEquals('test', $application->getName());
        $this->assertAttributeEquals($application->getName(), 'name', $application);
    }

    public function testApplicationGroups()
    {
        $applicationGroup = (new ApplicationGroup());
        $application      = (new Application())->setId(23);

        $applicationGroup->addApplications($application);

        $this->assertEquals(23, $applicationGroup->getApplications()->toArray()[0]->getId());

        $applicationGroup->removeApplications($application);

        $this->assertEmpty($applicationGroup->getApplications()->toArray());
    }


    public function testAttributionsAccessors()
    {
        $group = new ApplicationGroup();
        $attribution = (new Attribution())
            ->setTarget($group)
            ->setTarget(new Application())
            ->setRole(new Role())
        ;

        $coll = new ArrayCollection();
        $coll->add($attribution);

        $group->setAttributions($coll);

        $this->assertEquals($coll, $group->getAttributions());

        $group->addAttributions(new Attribution());

        $this->assertEquals(2, $group->getAttributions()->count());
    }
}
