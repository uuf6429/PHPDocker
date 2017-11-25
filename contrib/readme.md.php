<?php /** @var \DocGen $generator */ ?>
<?php echo $generator->getOverwriteWarning(); ?>


# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents
- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [API](#api)
<?php
	foreach ($generator->getClasses() as $class) {
		echo "    - [{$class->name}](#{$class->titleLink})\n";
	}
?>

## Installation

## Usage

## API

<?php
	foreach ($generator->getClasses() as $class) {
		echo "### {$class->titleText}\n\n";

		echo "- Full name: {$class->fullName}\n";

		if ($class->hasParent) {
			echo "- Extends: [{$class->parentTitleText}](#{$class->parentTitleLink})\n";
		}

		if (count($class->interfaceTextLinks)) {
			$interfaces = [];
			foreach ($class->interfaceTextLinks as $text => $link) {
				$interfaces = $link ? "[{$text}](#{$link})" : $text;
			}
			echo "- Implements: " . implode(', ', $interfaces) . "\n";
		}

		echo "\n";

		if ($class->description) {
			echo "\n{$class->description}\n\n";
		}

		foreach ($class->methods as $method) {
			if ($method->isMagicMethod) {
				continue;
			}

			echo "#### {$method->titleText}\n\n";

			echo "```php\n";
			echo sprintf(
				"%s%s%s(%s)%s\n",
				$method->isStatic ? $class->name : strtolower("\${$class->name}"),
				$method->isStatic ? '::' : '->',
				$method->name,
				implode(', ', array_map(
					function ($argument) {
						return "{$argument->type} \${$argument->name}";
					},
					$method->arguments
				)),
				$method->hasReturn ? ": {$method->returnType}" : ''
			);
			echo "```\n\n";

			if ($method->description) {
				echo "{$method->description}\n\n";
			}

			if (count($method->arguments)) {
				echo "##### Arguments:\n";
				$col1 = $generator->calcMaxLen($method->arguments, 'name', 9, 3);
				$col2 = $generator->calcMaxLen($method->arguments, 'type', 4, 2);
				$col3 = $generator->calcMaxLen($method->arguments, 'text', 11);
				printf("| %s | %s | %s |\n", str_pad('Parameter', $col1), str_pad('Type', $col2), str_pad('Description', $col3));
				printf("|-%s-|-%s-|-%s-|\n", str_repeat('-', $col1), str_repeat('-', $col2), str_repeat('-', $col3));
				foreach ($method->arguments as $argument) {
					printf("| %s | %s | %s |\n", str_pad("`\$$argument->name`", $col1), str_pad("`$argument->type`", $col2), str_pad($argument->text, $col3));
				}
				echo "\n";
			}

			if ($method->hasReturn) {
				echo "##### Return Value:\n";
				printf("`%s` - %s\n\n", $method->returnType, $method->returnText ?: '_No Description_');
			}
		}
	}
?>
