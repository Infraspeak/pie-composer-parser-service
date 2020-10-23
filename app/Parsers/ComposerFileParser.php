<?php

namespace App\Parsers;

class ComposerFileParser
{
    public static function parse(string $composerFile)
    {
        $fileToJson = json_decode($composerFile, true);
        $requirements = array_merge($fileToJson['payload']['require'], $fileToJson['payload']['require-dev']);

        $result = [];
        foreach ($requirements as $name => $version) {
            $result[] = [
                'name' => $name,
                'version' => $version,
                'url' => '',
            ];
        }
        dump($result);
    }
}
