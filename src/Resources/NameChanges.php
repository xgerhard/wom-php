<?php

namespace WOM\Resources;

use WOM\Models\NameChange\NameChange;

class NameChanges extends BaseResource
{
    /**
     * Searches for name changes that match a name and/or status filter.
     *
     * @param array $params
     * @return NameChange[] Array of NameChange models
     * @see https://docs.wiseoldman.net/names-api/name-endpoints#search-name-changes
     */
    public function search(array $params = []): array
    {
        $response = $this->request('GET', 'names', [
            'query' => $params
        ]);

        return $this->mapToModels($response, NameChange::class);
    }

    /**
     * Submits a name change request between two usernames (old and new).
     *
     * @param string $oldName
     * @param string $newName
     * @return NameChange
     * @see https://docs.wiseoldman.net/names-api/name-endpoints#submit-name-change
     */
    public function submit(string $oldName, string $newName): NameChange
    {
        if (empty($oldName) || empty($newName)) {
            throw new \InvalidArgumentException('Both "oldName" and "newName"are required.');
        }

        $response = $this->request('POST', 'names', [
            'json' => [
                'oldName' => $oldName,
                'newName' => $newName
            ]
        ]);

        return new NameChange($response);
    }
}
