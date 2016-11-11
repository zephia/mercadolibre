#!/usr/bin/php
<?php

include __DIR__ . DIRECTORY_SEPARATOR .
    '..' . DIRECTORY_SEPARATOR .
    'vendor' . DIRECTORY_SEPARATOR .
    'autoload.php';

$file_data = <<<EOT
<?php
/*
 * This file is part of the Mercado Libre API client package.
 *
 * (c) Zephia <info@zephia.com.ar>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace %s;

/**
 * Class %s
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class %s
{
%s
}

EOT;

$property_data = <<<EOT
    /**
     * @var %s
     */
    public $%s;
EOT;



foreach (glob(__DIR__ . '/../resources/config/serializer/*.yml') as $file) {
    $parsed_yaml =
        \Symfony\Component\Yaml\Yaml::parse(file_get_contents($file));

    $class_name = array_keys($parsed_yaml)[0];
    $namespaces = explode('\\', $class_name);
    $properties = [];

    foreach($parsed_yaml[$class_name]['properties'] as $key => $property) {
        if (strpos($property["type"], DateTime::class) !== false) {
            $property["type"] = "\\DateTime";
        }
        if (strpos($property["type"], "array<") !== false) {
            $property["type"] = "array";
        }
        if (strpos($property["type"], "Zephia\\MercadoLibre\\Entity") !== false) {
            $namespaces_property = explode('\\', $property["type"]);
            $property["type"] = $namespaces_property[3];
        }
        $properties[] .= sprintf(
            $property_data,
            $property["type"],
            $key
        );
    }

    file_put_contents(__DIR__ . '/../src/Entity/' . $namespaces[3] . '.php', sprintf(
        $file_data,
        $namespaces[0] . '\\' . $namespaces[1] . '\\' . $namespaces[2],
        $namespaces[3],
        $namespaces[3],
        implode("\n\n", $properties)
    ));
}

print("Don't forget to extend CategoryPrediction from Category.\n");
