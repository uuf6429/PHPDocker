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
		foreach ($class->methods as $method) {
			if (!$method->isMagicMethod) {
				echo "      - [`{$method->name}()`](#{$method->titleLink})\n";
			}
		}
	}
?>

## Installation

## Usage

## API
<?php
	foreach ($generator->getClasses() as $class) {
		echo "\n### {$class->titleText}\n\n";

		echo "- Full name: {$class->fullName}\n";

		if ($class->hasParent) {
			printf(
				"- Extends: %s\n",
				$class->parentTitleLink
					? "[{$class->parentTitleText}](#{$class->parentTitleLink})"
					: $class->parentTitleText
			);
		}

		if (count($class->interfaceTextLinks)) {
			$interfaces = [];
			foreach ($class->interfaceTextLinks as $text => $link) {
				$interfaces = $link ? "[{$text}](#{$link})" : $text;
			}
			echo "- Implements: " . implode(', ', $interfaces) . "\n";
		}

		if ($class->description) {
			echo "\n{$class->description}\n\n";
		}

		foreach ($class->methods as $method) {
			if ($method->isMagicMethod) {
				continue;
			}

			echo "\n----\n";

			echo "\n#### {$method->titleText}\n\n";

			echo "```php\n";
			echo sprintf(
				"%s%s%s(%s)%s\n",
				$method->isStatic ? $class->name : strtolower("\${$class->name}"),
				$method->isStatic ? '::' : '->',
				$method->name,
				implode(', ', array_map(
					function ($argument) {
						return trim("{$argument->type} \${$argument->name}");
					},
					$method->arguments
				)),
				$method->hasReturn ? ": {$method->returnType}" : ''
			);
			echo "```\n";

			if ($method->description) {
				echo "\n{$method->description}\n";
			}

			if (count($method->arguments)) {
				echo "\n**Arguments:**\n\n";
				$col1 = $generator->calcMaxLen($method->arguments, 'name', 9, 14);
				$col2 = $generator->calcMaxLen($method->arguments, 'type', 4, 13);
				$col3 = $generator->calcMaxLen($method->arguments, 'text', 11);
				printf("| %s | %s | %s |\n", str_pad('Parameter', $col1), str_pad('Type', $col2), str_pad('Description', $col3));
				printf("|-%s-|-%s-|-%s-|\n", str_repeat('-', $col1), str_repeat('-', $col2), str_repeat('-', $col3));
				foreach ($method->arguments as $argument) {
					printf(
						"| %s | %s | %s |\n",
						str_replace('|', '&#124;', str_pad("<code>\${$argument->name}</code>", $col1)),
						str_replace('|', '&#124;', str_pad($argument->type ? "<code>{$argument->type}</code>" : '', $col2)),
						str_replace('|', '&#124;', str_pad($argument->text, $col3))
					);
				}
			}

			if ($method->hasReturn) {
				echo "\n**Return Value:**\n\n";
				echo "`{$method->returnType}`" . ($method->returnText ? " - {$method->returnText}" : '') . "\n";
			}
		}
	}
?>
