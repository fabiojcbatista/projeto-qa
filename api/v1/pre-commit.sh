#!/bin/sh

# Verificar melhores práticas com PHP CodeSniffer
./vendor/bin/phpcs --standard=PSR12 api/v1/routes/routes.php

# Rodar testes com PHPUnit
./vendor/bin/phpunit

# Capturar o status de saída dos comandos
STATUS=$?

# Se qualquer comando falhar, abortar o commit
if [ $STATUS -ne 0 ]; then
    echo "Commit abortado devido a falhas nas verificações."
    exit 1
fi

exit 0