<?php

use PHPUnit\Framework\TestCase;
use WOM\Client;
use WOM\Models\Group\Group;

final class PaginationTest extends TestCase
{
    public function testPaginateGroupSearchFetchesMoreThan50Results(): void
    {
        $client = new Client();

        $results = $client->groups->paginate('search', ['name' => 'the'], maxPages: 2);

        $this->assertGreaterThan(50, count($results));
        $this->assertContainsOnlyInstancesOf(Group::class, $results);
    }

    public function testPaginateGroupSearchLazyFetchesMoreThan50Results(): void
    {
        $client = new Client();

        $results = iterator_to_array(
            $client->groups->paginate('search', ['name' => 'the'], maxPages: 2),
            false
        );

        $this->assertGreaterThan(50, count($results));
        $this->assertContainsOnlyInstancesOf(Group::class, $results);
    }
}
