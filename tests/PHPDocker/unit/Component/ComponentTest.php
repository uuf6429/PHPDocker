<?php

namespace PHPDocker\Tests\Component;

use PHPDocker\Component\Component;
use PHPDocker\ProcessBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ComponentTest extends \PHPUnit_Framework_TestCase
{
    public function testBadProcessVersionDetection()
    {
        /** @var Component $component */
        $component = $this->getMockBuilder(Component::class)
            ->setConstructorArgs(['some-non-existent-exe'])
            ->setMethodsExcept(['isInstalled', 'getVersion'])
            ->getMock();

        $this->assertFalse($component->isInstalled());

        $this->expectException(ProcessFailedException::class);
        $component->getVersion();
    }

    /**
     * @param string $processOutput
     * @param null|string $expectedVersion
     * @param null|\Exception $expectedException
     * @dataProvider versionParsingDataProvider
     */
    public function testVersionParsing($processOutput, $expectedVersion, $expectedException)
    {
        $component = $this->getComponentMock($this->getProcessMock(
            function () use ($processOutput) {
                return $processOutput;
            }
        ));

        if ($expectedException) {
            $this->expectException(get_class($expectedException));
            $this->expectExceptionMessage($expectedException->getMessage());
        }
        $this->assertSame($expectedVersion, $component->getVersion());
    }

    /**
     * @return array
     */
    public function versionParsingDataProvider()
    {
        return [
            'empty procss output' => [
                '$processOutput' => '',
                '$expectedVersion' => null,
                '$expectedException' => new \RuntimeException('Could not determine version.'),
            ],
            'bad process output' => [
                '$processOutput' => 'fdsg dgsg sdgsdg dsgsdg',
                '$expectedVersion' => null,
                '$expectedException' => new \RuntimeException('Could not determine version.'),
            ],
            'numeric version output' => [
                '$processOutput' => 'Something version 17.06.1234, build 02CDC33',
                '$expectedVersion' => '17.06.1234',
                '$expectedException' => null,
            ],
            'suffixed version output' => [
                '$processOutput' => 'Something version 17.06.12-beta2, build 02CDC33',
                '$expectedVersion' => '17.06.12-beta2',
                '$expectedException' => null,
            ],
        ];
    }

    public function testCommandCacheWorks()
    {
        $returnStack = [
            "Commands:\n  c1  Command\n",
            '',
            "Commands:\n  c2  Command\n",
            '',
        ];

        $process = $this->getProcessMock(
            function () use (&$returnStack) {
                return $returnStack ? array_shift($returnStack) : '';
            }
        );
        $component = $this->getComponentMock($process);

        // verify we get commands from output
        $this->assertEquals(['c1' => 'Command'], $component->getCommands());

        // verify we get cached commands
        $this->assertEquals(['c1' => 'Command'], $component->getCommands());

        // verify we get commands from output after cache is cleared
        $component->clearCommandsCache();
        $this->assertEquals(['c2' => 'Command'], $component->getCommands());
    }

    /**
     * @param null|Process $processMock
     *
     * @return \PHPDocker\Component\Component|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getComponentMock($processMock = null)
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Component $component */
        $component = $this->getMockBuilder(Component::class)
            ->setConstructorArgs(['some-non-existent-exe'])
            ->setMethods(['getProcessBuilder'])
            ->getMock();
        $processBuilder = $this->getMockBuilder(ProcessBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods($processMock ? ['getProcess'] : [])
            ->getMock();

        $component->method('getProcessBuilder')->willReturn($processBuilder);

        if ($processMock) {
            $processBuilder->method('getProcess')->willReturn($processMock);
        }

        return $component;
    }

    /**
     * @param callable $outputGenerator
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Process
     */
    private function getProcessMock($outputGenerator)
    {
        $process = $this->getMockBuilder(Process::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOutput', 'getErrorOutput', 'mustRun'])
            ->getMock();

        $process->method('getOutput')->willReturnCallback($outputGenerator);

        return $process;
    }
}
