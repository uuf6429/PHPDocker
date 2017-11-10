<?php

namespace PHPDocker\Tests\Component;

use PHPDocker\Component\Component;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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
        /** @var \PHPUnit_Framework_MockObject_MockObject|Component $component */
        $component = $this->getMockBuilder(Component::class)
            ->setConstructorArgs(['some-non-existent-exe'])
            ->setMethods(['getProcessBuilder'])
            ->getMock();
        $processBuilder = $this->getMockBuilder(ProcessBuilder::class)
            ->setMethods(['getProcess'])
            ->getMock();
        $process = $this->getMockBuilder(Process::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOutput', 'mustRun'])
            ->getMock();

        $component->method('getProcessBuilder')->willReturn($processBuilder);
        $processBuilder->method('getProcess')->willReturn($process);
        $process->method('getOutput')->willReturn($processOutput);

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
}
