<?php

copy(__DIR__ . '/pre-commit.sh', __DIR__ . '/../.git/hooks/pre-commit');
chmod(__DIR__ . '/../.git/hooks/pre-commit', 0755);
