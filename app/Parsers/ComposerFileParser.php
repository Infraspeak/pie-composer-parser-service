<?php

namespace App\Parsers;

use App\Repositories\PackagistRepository;

class ComposerFileParser
{
    public static function parse(array $composerFile): array
    {
            $requirements = array_merge($composerFile['require'] ?? [], $composerFile['require-dev'] ?? []);

            $result = [];
            foreach ($requirements as $name => $version) {
                $result[] = [
                    'name' => $name,
                    'version' => $version,
                    'url' => PackagistRepository::getUrl($name),
                ];
            }
            return $result;
    }
}
