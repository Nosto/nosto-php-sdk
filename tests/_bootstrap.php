<?php
/**
 * Copyright (c) 2020, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2020 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

date_default_timezone_set('Europe/Helsinki');

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    throw new RuntimeException(
        'Composer autoload file not found. Run "composer install" before running tests.'
    );
}
require_once $autoloadFile;

try {
    $dotenvClass = 'Dotenv\Dotenv';
    $envFile = __DIR__ . '/.env';

    if (!class_exists($dotenvClass)) {
        throw new RuntimeException('Dotenv\Dotenv is not available. Run composer install before tests.');
    }

    if (!is_file($envFile)) {
        throw new RuntimeException('Missing required test env file: ' . $envFile);
    }

    if (method_exists($dotenvClass, 'createMutable')) {
        $dotenv = $dotenvClass::createMutable(__DIR__); // @phan-suppress-current-line PhanUndeclaredStaticMethod
        $dotenv->load();
    } elseif (method_exists($dotenvClass, 'create')) {
        $dotenv = $dotenvClass::create(__DIR__); // @phan-suppress-current-line PhanUndeclaredStaticMethod
        if (method_exists($dotenv, 'overload')) {
            $dotenv->overload(); // @phan-suppress-current-line PhanUndeclaredMethod
        } else {
            $dotenv->load();
        }
    } else {
        $reflectDotEnv = new ReflectionMethod($dotenvClass, '__construct');
        $params = $reflectDotEnv->getParameters();

        if (isset($params[0]) && $params[0]->getName() === 'path') {
            $dotenv = (new ReflectionClass($dotenvClass))->newInstanceArgs([__DIR__]);
            if (method_exists($dotenv, 'overload')) {
                $dotenv->overload(); // @phan-suppress-current-line PhanUndeclaredMethod
            } else {
                $dotenv->load();
            }
        } else {
            throw new RuntimeException('Unsupported Dotenv constructor signature.');
        }
    }
} catch (Exception $e) {
    // Could not load ENV using defaults
    /** @noinspection PhpUnhandledExceptionInspection */
    throw $e;
}

Nosto\Request\Http\HttpRequest::buildUserAgent('PHPUnit', '1.0.0', '1.0.0');
