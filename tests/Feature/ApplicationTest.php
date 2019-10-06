<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testOneValidParameter()
    {
        $result = shell_exec('php index.php Germany');
        
        $this->assertEquals(sprintf('Country language code: de%sGermany speaks same language with these countries: Austria, Belgium, Holy See, Liechtenstein, Luxembourg, Switzerland%s', PHP_EOL, PHP_EOL), $result);
    }

    public function testOneValidParameterAndNoSameLanguage()
    {
        $result = shell_exec('php index.php Bangladesh');
        
        $this->assertEquals(sprintf('Country language code: bn%sBangladesh speaks same language with these countries: %s', PHP_EOL, PHP_EOL), $result);
    }

    public function testOneInValidParameter()
    {
        $result = shell_exec('php index.php Inavlid');
        
        $this->assertEquals(sprintf('Not Found%s', PHP_EOL), $result);
    }

    public function testTwoValidParameterAndSpeakSame()
    {
        $result = shell_exec('php index.php Spain Argentina');
        
        $this->assertEquals(sprintf('Spain and Argentina speak the same language.%s', PHP_EOL), $result);
    }

    public function testTwoValidParameterAndSpeakNotSame()
    {
        $result = shell_exec('php index.php Spain Germany');
        
        $this->assertEquals(sprintf('Spain and Germany do not speak the same language.%s', PHP_EOL), $result);
    }

    public function testTwoInValidParameter()
    {
        $result = shell_exec('php index.php Spain Inavlid');
        
        $this->assertEquals(sprintf('Not Found%s', PHP_EOL), $result);
    }

    public function testNoParameter()
    {
        $result = shell_exec('php index.php');
        
        $this->assertEquals(sprintf('Your command syntax must follow this schema "php index.php [string country_name] [OPTIONAL string second_country_name]"%s', PHP_EOL), $result);
    }

    public function testMoreThanTwoParameter()
    {
        $result = shell_exec('php index.php Spain Germany Bangladesh');
        
        $this->assertEquals(sprintf('Your command syntax must follow this schema "php index.php [string country_name] [OPTIONAL string second_country_name]"%s', PHP_EOL), $result);
    }
}