<?php

use PHPUnit\Framework\TestCase;
use WOM\Client;

final class PlayerTest extends TestCase
{
    public function testCanFetchPlayerDetails(): void
    {
        $client = new Client();
        $player = $client->players->get('gerhardoh');

        $this->assertNotNull($player);
        $this->assertSame('gerhardoh', $player->displayName);
    }
}