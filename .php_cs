<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        //'yoda_style' => false,
        'phpdoc_align' => false,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()->in(__DIR__)
            ->exclude(['temp', 'vendor']
        )
    )
    ->setCacheFile(__DIR__ . '/temp/.php_cs.cache')
;
