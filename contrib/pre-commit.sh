#!/bin/sh

PROJECT_ROOT="`git rev-parse --show-toplevel`"
PHP_CS_FIXER="${PROJECT_ROOT}/vendor/bin/php-cs-fixer"

# Make sure temp directory exists
mkdir -p "${PROJECT_ROOT}/temp"

# Run PHP-CS-Fixer
"${PHP_CS_FIXER}" fix --verbose --show-progress=estimating --config "${PROJECT_ROOT}/.php_cs" --allow-risky yes

# Handle PHP-CS-Fixer result
if [ $? = 0 ]; then
    if ! git diff --quiet; then
        echo "PHP-CS-Fixer fixed some files. Please review changes, add them in git and commit again."
        exit 1
    fi
else 
    echo "PHP-CS-Fixer faulted for some reason. Please fix the error and try committing again."
    exit 1
fi

# Regenerate documentation and add to commit
php "${PROJECT_ROOT}/contrib/DocGen.php"
git add -- "${PROJECT_ROOT}/README.md" "${PROJECT_ROOT}/DOCS.md"
