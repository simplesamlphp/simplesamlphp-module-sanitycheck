<?php

declare(strict_types=1);

namespace SimpleSAML\Test\Module\sanitycheck\Controller;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Auth;
use SimpleSAML\Configuration;
use SimpleSAML\Error;
use SimpleSAML\Module\sanitycheck\Controller;
use SimpleSAML\Session;
use SimpleSAML\XHTML\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Set of tests for the controllers in the "sanitycheck" module.
 *
 * @package SimpleSAML\Test
 */
class SanityCheckTest extends TestCase
{
    /** @var \SimpleSAML\Configuration */
    protected Configuration $config;

    /**
     * Set up for each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->config = Configuration::loadFromArray(
            [
                'baseurlpath' => 'https://example.org/simplesaml',
                'module.enable' => ['sanitycheck' => true],
                'technicalcontact_email' => 'info@example.org',
                'auth.adminpassword' => '$2y$10$7Zw5yXm5LmnOlG8UY53/CO0mrCroGVNFrapNL0xHaD29zTkLR0Gl6',
            ],
            '[ARRAY]',
            'simplesaml'
        );

        Configuration::setPreLoadedConfig($this->config, 'config.php');
    }


    /**
     * Test that a valid requests results in a Twig template
     */
    public function testValidRequestWithoutParams(): void
    {
        $request = Request::create(
            '/',
            'GET'
        );
        $session = Session::getSessionFromRequest();

        $c = new Controller\SanityCheck($this->config, $session);

        /** @var \SimpleSAML\XHTML\Template $response */
        $response = $c->main($request, null);

        $this->assertTrue($response->isSuccessful());
    }


    /**
     * Test that a valid requests with output=text results in a Response
     */
    public function testValidRequestWithOutputText(): void
    {
        $request = Request::create(
            '/',
            'GET',
            ['output' => 'text']
        );
        $session = Session::getSessionFromRequest();

        $c = new Controller\SanityCheck($this->config, $session);

        $response = $c->main($request, 'text');

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('OK', $response->getContent());
        $this->assertEquals('text/html', $response->headers->get('content-type'));
    }


    /**
     * Test that a valid requests with output=text and missing configuration results in a Response
     */
    public function testValidRequestWithOutputTextAndMissingConfig(): void
    {
        $this->config = Configuration::loadFromArray(
            [
                'baseurlpath' => 'https://example.org/simplesaml',
                'module.enable' => ['sanitycheck' => true],
            ],
            '[ARRAY]',
            'simplesaml'
        );

        Configuration::setPreLoadedConfig($this->config, 'config.php');

        $request = Request::create(
            '/',
            'GET',
            ['output' => 'text']
        );
        $session = Session::getSessionFromRequest();

        $c = new Controller\SanityCheck($this->config, $session);

        $response = $c->main($request, 'text');

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('FAIL', $response->getContent());
        $this->assertEquals('text/html', $response->headers->get('content-type'));
    }
}
