<?php

require_once(__DIR__ . '/../vendor/autoload.php');

class DocGen
{
    /**
     * @var string[]
     */
    private static $SYMBOLS_TO_DOCUMENT = [
        \PHPDocker\Manager::class,
        \PHPDocker\Component\Machine::class,
        \PHPDocker\Component\Docker::class,
        \PHPDocker\Component\Compose::class,
    ];

    /**
     * @see \PHPDocker\Manager::$components
     *
     * @var string[]
     */
    private static $SUPPORTED_COMPONENTS = [
        'docker', 'compose', 'machine',
    ];

    /**
     * @var array
     */
    private static $SUPPORTED_COMMANDS_RENAMED = [
        'docker unpause' => 'resume',
        'docker rm' => 'remove',
        'docker cp' => 'copy',
        'docker version' => 'getVersion',
        'docker-compose rm' => 'remove',
        'docker-compose exec' => 'execute',
        'docker-compose version' => 'getVersion',
        'docker-machine active' => 'getActive',
        'docker-machine ip' => 'getIPs',
        'docker-machine url' => 'getURL',
        'docker-machine status' => 'getStatus',
        'docker-machine rm' => 'remove',
        'docker-machine env' => 'getEnvVars',
        'docker-machine version' => 'getVersion',
    ];

    /**
     * @var string[]
     */
    private static $SUPPORTED_COMMANDS_IGNORED = [
        'docker help',
        'docker-compose help',
        'docker-machine help',
    ];

    /**
     * @var \ReflectionClass[]
     */
    private $classes;

    /**
     * @var \phpDocumentor\Reflection\DocBlockFactory
     */
    private $docBlockFactory;

    private static $COMMAND_COMPLETE = 1;
    private static $COMMAND_HASTODOS = 2;
    private static $COMMAND_NOTFOUND = 3;

    public function __construct()
    {
        $this->docBlockFactory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->classes = array_map(
            function ($symbol) {
                return new \ReflectionClass($symbol);
            },
            self::$SYMBOLS_TO_DOCUMENT
        );
    }

    /**
     * @return string
     */
    public function getOverwriteWarning()
    {
        return '<!-- This file is generated automatically and any changes will be overwritten! -->';
    }

    /**
     * @return ClassDoc[]
     */
    public function getClasses()
    {
        static $result;

        return $result ? $result : ($result = $this->buildClasses());
    }

    /**
     * @return ComponentSupport[]|\Exception
     */
    public function getComponentSupport()
    {
        try {
            $manager = new \PHPDocker\Manager();

            return array_map(function ($name) use ($manager) {
                $component = $manager->$name;
                $commands = $this->buildCommandSupport($component, $name);
                $notIgnored = $supported = 0;
                array_walk($commands, function ($command) use (&$notIgnored, &$supported) {
                    /** @var \ComponentCommandSupport $command */
                    $notIgnored += $command->isIgnored ? 0 : 1;
                    $supported += ($command->isSupported && !$command->isIgnored)
                        ? ($command->isIncomplete ? 0.5 : 1) : 0;
                });

                return (object) [
                    'name' => ($name == 'docker' ? '' : 'Docker ') . ucfirst($name),
                    'shortName' => $name,
                    'fqClassName' => get_class($component),
                    'classLink' => $this->buildSafeAnchor(get_class($component)),
                    'commands' => $commands,
                    'supportPercent' => $supported / max($notIgnored, 1) * 100,
                ];
            }, self::$SUPPORTED_COMPONENTS);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * @return string
     */
    public function getDocsPath()
    {
        return '/DOCS.md';
    }

    /**
     * @return ClassDoc[]
     */
    private function buildClasses()
    {
        return array_map(function (\ReflectionClass $class) {
            $parent = $class->getParentClass();
            $interfaceNames = $class->getInterfaceNames();
            $interfaceLinks = array_map(
                function ($interface) {
                    return in_array($interface, self::$SYMBOLS_TO_DOCUMENT)
                        ? $this->buildSafeAnchor($interface) : '';
                },
                $interfaceNames
            );
            $phpdoc = $this->buildDocBlock($class);

            return (object) [
                'name' => $class->getShortName(),
                'fullName' => $class->getName(),
                'titleText' => $class->getName(),
                'titleLink' => $this->buildSafeAnchor($class->getName()),
                'hasParent' => (bool) $parent,
                'parentTitleText' => $parent ? $parent->getName() : null,
                'parentTitleLink' => $parent && in_array($parent->getName(), self::$SYMBOLS_TO_DOCUMENT)
                    ? $this->buildSafeAnchor($parent->getName()) : null,
                'interfaceTextLinks' => array_combine($interfaceNames, $interfaceLinks),
                'parentFullName' => $parent ? $parent->getName() : null,
                'methods' => $this->buildClassMethods($class, $phpdoc),
                'description' => trim($phpdoc->getSummary() . "\n\n" . $phpdoc->getDescription()->render()),
            ];
        }, $this->classes);
    }

    /**
     * @param \ReflectionClass $class
     * @param \phpDocumentor\Reflection\DocBlock $phpdoc
     *
     * @return \MethodDoc[]
     */
    private function buildClassMethods(\ReflectionClass $class, \phpDocumentor\Reflection\DocBlock $phpdoc)
    {
        $shortClassName = $class->getShortName();

        $methods = array_merge(
            // handle methods from reflection
            array_map(
                function (\ReflectionMethod $method) use ($shortClassName) {
                    $phpdoc = $this->buildDocBlock($method);
                    /** @var \phpDocumentor\Reflection\DocBlock\Tags\Return_ $return */
                    $return = $phpdoc->hasTag('return') ? $phpdoc->getTagsByName('return')[0] : null;
                    $params = [];
                    foreach ($method->getParameters() as $param) {
                        $params[$param->getName()] = (object) [
                            'name' => $param->getName(),
                            'type' => $param->getType(),
                            'text' => '',
                        ];
                    }
                    foreach ($phpdoc->getTagsByName('param') as $param) {
                        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Param $param */
                        if (isset($params[$param->getVariableName()])) {
                            if (!$params[$param->getVariableName()]->type) {
                                $params[$param->getVariableName()]->type = (string) $param->getType();
                            }
                            $params[$param->getVariableName()]->text = $param->getDescription()->render();
                        }
                    }

                    return (object) [
                        'name' => $method->name,
                        'isMagicMethod' => substr($method->name, 0, 2) === '__',
                        'titleText' => "`{$shortClassName}::{$method->name}()`",
                        'titleLink' => $this->buildSafeAnchor("`{$shortClassName}::{$method->name}()`"),
                        'description' => trim($phpdoc->getSummary() . "\n\n" . $phpdoc->getDescription()->render()),
                        'signature' => $this->buildMethodSignature(
                            sprintf(
                                $method->isStatic() ? '%s::%s' : '$%s->%s',
                                $method->isStatic() ? $shortClassName : strtolower($shortClassName),
                                $method->getName()
                            ),
                            $params,
                            $return ? (string) $return->getType() : '',
                            $return ? $return->getDescription()->render() : ''
                        ),
                    ];
                },
                $class->getMethods(ReflectionMethod::IS_PUBLIC)
            ),
            // handle (virtual) methods from PHPDoc
            array_map(
                function (\phpDocumentor\Reflection\DocBlock\Tags\Method $method) use ($shortClassName) {
                    return (object) [
                        'name' => $method->getMethodName(),
                        'isMagicMethod' => substr($method->getMethodName(), 0, 2) === '__',
                        'titleText' => "`{$shortClassName}::{$method->getMethodName()}()`",
                        'titleLink' => $this->buildSafeAnchor("`{$shortClassName}::{$method->getMethodName()}()`"),
                        'description' => $method->getDescription()->render(),
                        'signature' => $this->buildMethodSignature(
                            sprintf(
                                $method->isStatic() ? '%s::%s' : '$%s->%s',
                                $method->isStatic() ? $shortClassName : strtolower($shortClassName),
                                $method->getMethodName()
                            ),
                            array_map(
                                function ($argument) {
                                    return (object) [
                                        'name' => $argument['name'],
                                        'type' => $argument['type'],
                                        'text' => '', // cannot be defined from virtual methods
                                    ];
                                },
                                $method->getArguments()
                            ),
                            (string) $method->getReturnType(),
                            '' // returned value cannot be descried from virtual methods
                        ),
                    ];
                },
                $phpdoc->getTagsByName('method')
            )
        );

        // sort methods by name
        usort($methods, function ($a, $b) {
            return strcmp($a->name, $b->name);
        });

        return $methods;
    }

    /**
     * @param string $title
     *
     * @return string
     *
     * @see https://gist.github.com/asabaylus/3071099#gistcomment-1593627
     */
    private function buildSafeAnchor($title)
    {
        return preg_replace(
            ['/[^\\w\\- ]/', '/ /'],
            ['', '-'],
            strtolower($title)
        );
    }

    /**
     * @param \Reflector $reflector
     *
     * @return \phpDocumentor\Reflection\DocBlock
     */
    private function buildDocBlock(\Reflector $reflector)
    {
        return method_exists($reflector, 'getDocComment')
               && !empty($phpdoc = $reflector->getDocComment())
            ? $this->docBlockFactory->create($phpdoc)
            : new \phpDocumentor\Reflection\DocBlock();
    }

    /**
     * @param string $methodCall
     * @param array $arguments
     * @param string $returnType
     * @param string $returnText
     *
     * @return string
     */
    private function buildMethodSignature($methodCall, $arguments, $returnType, $returnText)
    {
        $result = $methodCall . '(';

        if ($arguments) {
            $result .= "\n";
        }

        $typeWidth = 0;
        $nameWidth = 0;
        foreach ($arguments as $argument) {
            $typeWidth = max($typeWidth, strlen($argument->type) + 1);
            $nameWidth = max($nameWidth, strlen($argument->name) + 5);
        }

        foreach ($arguments as $argument) {
            $line = '    ';
            $line .= str_pad($argument->type, $typeWidth);
            $line .= str_pad("\${$argument->name}", $nameWidth);
            if ($argument->text) {
                $pad = str_repeat(' ', strlen($line));
                $line .= '// ' . str_replace("\n", "\n{$pad}// ", $argument->text);
            } else {
                $line = rtrim($line);
            }

            $result .= "$line\n";
        }

        $line = ')';

        if ($returnType) {
            $line .= ": $returnType";
        }

        if ($returnText) {
            $line .= '    ';
            $pad = str_repeat(' ', strlen($line));
            $line .= '// ' . str_replace("\n", "\n{$pad}// ", $returnText);
        }

        $result .= $line;

        return $result;
    }

    /**
     * @param \PHPDocker\Component\Component $component
     * @param string $shortName
     *
     * @return ComponentCommandSupport[]
     */
    private function buildCommandSupport(PHPDocker\Component\Component $component, $shortName)
    {
        $reflector = new ReflectionProperty(PHPDocker\Component\Component::class, 'bin');
        $reflector->setAccessible(true);
        $componentBin = $reflector->getValue($component);
        $componentClass = get_class($component);
        $componentMethods = get_class_methods($component);

        if (!$component->isInstalled()) {
            throw new \RuntimeException(sprintf('Component %s is not installed.', basename($componentClass)));
        }

        return array_map(
            function ($command) use ($componentBin, $shortName, $componentClass, $componentMethods) {
                $fullCommand = $componentBin . ' ' . $command;
                $actualName = isset(self::$SUPPORTED_COMMANDS_RENAMED[$fullCommand])
                    ? self::$SUPPORTED_COMMANDS_RENAMED[$fullCommand] : $command;
                $methodStatus = $this->detectMethodStatus($componentClass, $actualName);

                return (object) [
                    'fqCommandName' => $fullCommand,
                    'methodText' => ucfirst($shortName) . '::' . $actualName,
                    'methodLink' => $this->getDocsPath() . '#' . $this->buildSafeAnchor(ucfirst($shortName) . '::' . $actualName),
                    'isSupported' => ($methodStatus !== self::$COMMAND_NOTFOUND) && in_array($actualName, $componentMethods),
                    'isIgnored' => in_array($fullCommand, self::$SUPPORTED_COMMANDS_IGNORED),
                    'isIncomplete' => $methodStatus === self::$COMMAND_HASTODOS,
                ];
            },
            array_keys($component->getCommands())
        );
    }

    /**
     * @param string $class
     * @param string $method
     *
     * @return bool|null True if complete, false if incomplete and null on error (method is actually missing or something)
     */
    private function detectMethodStatus($class, $method)
    {
        try {
            $reflector = new \ReflectionMethod($class, $method);

            return preg_match('/\\*\\s+\\@(todo|fixme)/i', $reflector->getDocComment())
                ? self::$COMMAND_HASTODOS
                : self::$COMMAND_COMPLETE;
        } catch (\Exception $ex) {
            return self::$COMMAND_NOTFOUND;
        }
    }
}

/**
 * Stub class for describing anonymous object.
 *
 * @property string $name
 * @property string $fullName
 * @property string $titleText
 * @property string $titleLink
 * @property bool $hasParent
 * @property string $parentTitleText
 * @property string $parentTitleLink
 * @property string[] $interfaceTextLinks
 * @property string $parentFullName
 * @property \MethodDoc[] $methods
 * @property string $description
 */
interface ClassDoc
{
}

/**
 * Stub class for describing anonymous object.
 *
 * @property string $name
 * @property bool $isMagicMethod
 * @property string $titleText
 * @property string $titleLink
 * @property string $description
 * @property string $signature
 */
interface MethodDoc
{
}

/**
 * Stub class for describing anonymous object.
 *
 * @property string $name
 * @property string $shortName
 * @property string $fqClassName
 * @property string $classLink
 * @property ComponentCommandSupport[] $commands
 * @property float $supportPercent
 */
interface ComponentSupport
{
}

/**
 * Stub class for describing anonymous object.
 *
 * @property string $fqCommandName
 * @property string $methodText
 * @property string $methodLink
 * @property bool $isSupported
 * @property bool $isIgnored
 * @property bool $isIncomplete
 */
interface ComponentCommandSupport
{
}

$generator = new DocGen();

ob_start();
require_once('readme.md.php');
file_put_contents(__DIR__ . '/../README.md', ob_get_clean());

ob_start();
require_once('docs.md.php');
file_put_contents(__DIR__ . '/../DOCS.md', ob_get_clean());
