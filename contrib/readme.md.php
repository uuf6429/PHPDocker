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
		echo "\n### {$class->titleText}\n";

		if ($class->hasParent || count($class->interfaceTextLinks)) {
			echo "\n_";

			if ($class->hasParent) {
				printf(
					"**extends** %s",
					$class->parentTitleLink
						? "[`{$class->parentTitleText}`](#{$class->parentTitleLink})"
						: "`{$class->parentTitleText}`"
				);
			}

			if ($class->hasParent && count($class->interfaceTextLinks)) {
				echo '; ';
			}

			if (count($class->interfaceTextLinks)) {
				printf(
					"**implements** %s",
					implode(
						', ',
						array_map(
							function ($text, $link) {
								return $link ? "[{$text}](#{$link})" : $text;
							},
							array_keys($class->interfaceTextLinks),
							array_values($class->interfaceTextLinks)
						)
					)
				);
			}

			echo "_\n";
		}

		if ($class->description) {
			echo "\n{$class->description}\n\n";
		}

		foreach ($class->methods as $method) {
			if ($method->isMagicMethod) {
				continue;
			}

			echo "\n----\n";
			echo "\n#### {$method->titleText}\n";
			echo "\n```php\n$method->signature\n```\n";

			if ($method->description) {
				echo "\n{$method->description}\n";
			}
		}
	}
?>
