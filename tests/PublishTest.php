<?php


use App\Parsers\ComposerFileParser;


class PublishTest extends TestCase
{
    /** @test */
    public function it_stills_parse_if_missing_required_dev(): void
    {
        $composerFile = [
            "require" => [
                "php" => "^7.3|^8",
            ]];


        $result = ComposerFileParser::parse($composerFile);

        $this->assertArrayHasKey('name', $result[0], '');
        $this->assertArrayHasKey('version', $result[0], '');
        $this->assertArrayHasKey('url', $result[0], '');

    }
}
