<?php

namespace PHPDocker\Tests;

use PHPDocker\Component;
use PHPDocker\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultComponentsAreAvailable()
    {
        $manager = new Manager();
        $this->assertInstanceOf(Component\Docker::class, $manager->docker);
        $this->assertInstanceOf(Component\Machine::class, $manager->machine);
        $this->assertInstanceOf(Component\Compose::class, $manager->compose);
    }

    public function testIsInstalledWithAllComponentsInstalled()
    {
        $manager = $this->getManagerMock(['buildComponent']);
        $component = $this->getComponentMock(['isInstalled']);

        $component->method('isInstalled')->willReturn(true);
        $manager->method('buildComponent')->willReturn($component);

        $this->assertTrue($manager->isInstalled());
    }

    public function testIsInstalledWithMissingDockerCompose()
    {
        $manager = $this->getManagerMock(['buildComponent']);
        $installedComponent = $this->getComponentMock(['isInstalled']);
        $missingComponent = $this->getComponentMock(['isInstalled']);

        $installedComponent->method('isInstalled')->willReturn(true);
        $missingComponent->method('isInstalled')->willReturn(false);
        $manager->method('buildComponent')
            ->willReturnCallback(
                function ($key) use ($installedComponent, $missingComponent) {
                    return $key == 'compose' ? $missingComponent : $installedComponent;
                }
            );

        $this->assertFalse($manager->isInstalled());
    }

    /**
     * @param string[] $mockMethods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Manager
     */
    private function getManagerMock($mockMethods)
    {
        return $this->getMockBuilder(Manager::class)
            ->setMethods($mockMethods)
            ->getMock();
    }

    /**
     * @param string[] $mockMethods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Component\Component
     */
    private function getComponentMock($mockMethods)
    {
        return $this->getMockBuilder(Component\Component::class)
            ->setConstructorArgs(['some-bin', null])
            ->setMethods($mockMethods)
            ->getMock();
    }
}
