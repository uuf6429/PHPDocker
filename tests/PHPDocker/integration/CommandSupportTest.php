<?php

namespace PHPDocker\Tests;

use PHPDocker\Component\Component;
use PHPDocker\Manager;

class CommandSupportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param \PHPDocker\Component\Component $component
     * @param array $alternativeCommands
     * @param string[] $uselessCommands
     *
     * @dataProvider commandSupportDataProvider
     */
    public function testCommandSupport(Component $component, $alternativeCommands, $uselessCommands)
    {
        if (!$component->isInstalled()) {
            $this->markTestSkipped(sprintf('Component %s is not installed.', basename(get_class($component))));
        }

        $binCommands = array_diff(array_keys($component->getCommands()), $uselessCommands);
        $objMethods = get_class_methods($component);

        // some cli commands have a different method name, therefore we switch them
        foreach ($alternativeCommands as $command => $method) {
            if (($pos = array_search($method, $objMethods)) != false) {
                $objMethods[$pos] = $command;
            }
        }

        $objCommands = array_intersect($objMethods, $binCommands);

        sort($binCommands);
        sort($objCommands);

        $this->assertEquals(
            $binCommands,
            $objCommands,
            sprintf(
                'Component "%s" supports only %d%% of commands.',
                basename(get_class($component)),
                count($objCommands) / count($binCommands) * 100
            )
        );
    }

    public function commandSupportDataProvider()
    {
        $manager = new Manager();

        return [
            'Docker Commands' => [
                '$component' => $manager->docker,
                '$alternativeCommands' => [
                    'unpause' => 'resume',
                    'rm' => 'remove',
                ],
                '$uselessCommands' => ['help'],
            ],
            'Docker-Compose Commands' => [
                '$component' => $manager->compose,
                '$alternativeCommands' => [
                    'rm' => 'remove',
                    'exec' => 'execute',
                ],
                '$uselessCommands' => ['help', 'version'],
            ],
            'Docker-Machine Commands' => [
                '$component' => $manager->machine,
                '$alternativeCommands' => [
                    'active' => 'getActive',
                    'ip' => 'getIPs',
                    'env' => 'getEnvVars',
                ],
                '$uselessCommands' => ['help'],
            ],
        ];
    }
}