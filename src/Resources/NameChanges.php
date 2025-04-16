<?php

namespace WOM\Resources;

use WOM\Models\NameChange\NameChange;

class NameChanges extends BaseResource
{
    public function search(array $params = []): array
    {
        $response = $this->request('GET', 'names', [
            'query' => $params
        ]);

        return $this->mapToModels($response, NameChange::class);
    }

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
