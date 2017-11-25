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
     * @var \ReflectionClass[]
     */
    private $classes;

    /**
     * @var \phpDocumentor\Reflection\DocBlockFactory
     */
    private $docBlockFactory;

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
     * @param array $items
     * @param string $key
     * @param int $min
     * @param int $off
     *
     * @return int
     */
    public function calcMaxLen($items, $key, $min, $off = 0)
    {
        $max = $min;

        foreach ($items as $item) {
            $max = max($max, strlen($item->$key) + $off);
        }

        return $max;
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
        $methods = array_merge(
            // handle methods from reflection
            array_map(
                function(\ReflectionMethod $method){
                    $phpdoc = $this->buildDocBlock($method);
                    /** @var \phpDocumentor\Reflection\DocBlock\Tags\Return_ $return */
                    $return = $phpdoc->hasTag('return') ? $phpdoc->getTagsByName('return')[0] : null;
                    $params = [];
                    foreach ($method->getParameters() as $param) {
                        $params[$param->getName()] = (object)[
                            'name' => $param->getName(),
                            'type' => $param->getType() ? $param->getType()->getName() : '',
                            'text' => '',
                        ];
                    }
                    foreach ($phpdoc->getTagsByName('param') as $param) {
                        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Param $param */
                        if (isset($params[$param->getVariableName()])) {
                            if (!$params[$param->getVariableName()]->type) {
                                $params[$param->getVariableName()]->type = (string)$param->getType();
                            }
                            $params[$param->getVariableName()]->text = $param->getDescription()->render();
                        }
                    }

                    return (object) [
                        'name' => $method->name,
                        'isMagicMethod' => substr($method->name, 0, 2) === '__',
                        'isStatic' => $method->isStatic(),
                        'titleText' => $method->name . '()',
                        'description' => trim($phpdoc->getSummary() . "\n\n" . $phpdoc->getDescription()->render()),
                        'hasReturn' => (bool)$return,
                        'returnType' => $return ? (string)$return->getType() : '',
                        'returnText' => $return ? $return->getDescription()->render() : '',
                        'arguments' => $params,
                    ];
                },
                $class->getMethods(ReflectionMethod::IS_PUBLIC)
            ),
            // handle (virtual) methods from PHPDoc
            array_map(
                function(\phpDocumentor\Reflection\DocBlock\Tags\Method $method){
                    return (object) [
                        'name' => $method->getMethodName(),
                        'isMagicMethod' => substr($method->getMethodName(), 0, 2) === '__',
                        'isStatic' => $method->isStatic(),
                        'titleText' => $method->getMethodName() . '()',
                        'description' => $method->getDescription()->render(),
                        'hasReturn' => !($method->getReturnType() instanceof \phpDocumentor\Reflection\Types\Void_),
                        'returnType' => (string)$method->getReturnType(),
                        'returnText' => '', // cannot be defined from virtual methods
                        'arguments' => array_map(
                            function ($name) {
                                return (object) [
                                    'name' => $name,
                                    'type' => '',
                                    'text' => '',
                                ];
                            },
                            $method->getArguments()
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
            ['/[^\\w\\- ]/', '/ /' ],
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
}

/**
 * Stub class for describing anonymous object.
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
interface ClassDoc {}

/**
 * Stub class for describing anonymous object.
 * @property string $name
 * @property bool $isMagicMethod
 * @property bool $isStatic
 * @property string $titleText
 * @property string $description
 * @property bool $hasReturn
 * @property string $returnType
 * @property string $returnText
 * @property \ArgumentDoc[] $arguments
 */
interface MethodDoc {}

/**
 * Stub class for describing anonymous object.
 * @property string $name
 * @property string $type
 * @property string $text
 */
interface ArgumentDoc {}

ob_start();
$generator = new DocGen();
require_once('readme.md.php');
file_put_contents(__DIR__ . '/../README.md', ob_get_clean());
