<?php

use PHPUnit\Framework\TestCase;
use WOM\Client;

final class PlayerTest extends TestCase
{
    public function testCanFetchPlayerDetails(): void
    {
        $client = new Client();
        $player = $client->players->get('zezima');

        $this->assertNotNull($player);
        $this->assertSame('Zezima', $player->displayName);
    }
}