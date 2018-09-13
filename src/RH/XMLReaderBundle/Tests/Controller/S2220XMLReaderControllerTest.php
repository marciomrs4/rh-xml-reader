<?php

namespace RH\XMLReaderBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class S2220XMLReaderControllerTest extends WebTestCase
{
    public function testReader()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 's2220reader');
    }

}
