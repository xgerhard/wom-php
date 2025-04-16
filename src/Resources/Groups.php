<?php

namespace WOM\Resources;

use WOM\Models\Competition\Competition;
use WOM\Models\Delta\DeltaLeaderboardEntry;
use WOM\Models\Group\Group;
use WOM\Models\Group\GroupDetails;
use WOM\Enums\Group\Role;

class Groups extends BaseResource
{
    public function search(array $params = []): array
    {
        $response = $this->request('GET', 'groups', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Group::class);
    }

    public function get(int $id): GroupDetails
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id);

        return new GroupDetails($response);
    }

    public function create(array $params = []): GroupDetails
    {
        if (!isset($params['name'])) {
            throw new \InvalidArgumentException('The "name" parameter is required.');
        }
    
        if (!isset($params['members']) || !is_array($params['members'])) {
            throw new \InvalidArgumentException('The "members" parameter is required and must be an array of members (each with "username" and "role").');
        }

        $response = $this->request('POST', 'groups', [
            'json' => $params
        ]);
    
        return new GroupDetails($response);
    }

    public function edit(int $id, array $params = []): GroupDetails
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('PUT', 'groups/' . $id, [
            'json' => $params
        ]);
    
        return new GroupDetails($response);
    }

    public function delete(int $id, string $verificationCode)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (empty($verificationCode)) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('DELETE', 'groups/' . $id, [
            'json' => ['verificationCode' => $verificationCode]
        ]);
    
        return $response;
    }

    public function addMembers(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['members']) || !is_array($params['members'])) {
            throw new \InvalidArgumentException('The "members" parameter is required and must be an array of members (each with "username" and "role").');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('POST', 'groups/' . $id . '/members' , [
            'json' => $params
        ]);
    
        return $response;
    }

    public function removeMembers(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['members']) || !is_array($params['members'])) {
            throw new \InvalidArgumentException('The "members" parameter is required and must be an array of usernames.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('DELETE', 'groups/' . $id . '/members' , [
            'json' => $params
        ]);
    
        return $response;
    }

    public function changeRole(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['username'])) {
            throw new \InvalidArgumentException('The "username" parameter is required.');
        }

        if (!isset($params['role'])) {
            throw new \InvalidArgumentException('The "role" parameter is required.');
        }

        if (!in_array($params['role'], Role::all())) {
            throw new \InvalidArgumentException('Invalid role provided.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('PUT', 'groups/' . $id . '/role' , [
            'json' => $params
        ]);
    
        return $response;
    }

    public function updateAll(int $id, string $verificationCode)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (empty($verificationCode)) {
            throw new \InvalidArgumentException('VerificationCode is required.');
        }

        $response = $this->request('POST', 'groups/' . $id . '/update-all' , [
            'json' => [
                'verificationCode' => $verificationCode
            ]
        ]);

        return $response;
    }

    public function getCompetitions(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/competitions', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Competition::class);
    }

    public function getGains(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('The "metric" parameter is required.');
        }

        $this->validateTimeParams($params);

        $response = $this->request('GET', 'groups/' . $id . '/gained', [
            'query' => $params
        ]);

        return $this->mapToModels($response, DeltaLeaderboardEntry::class);
    }

    private function validateTimeParams(array $params): void
    {
        $hasPeriod = isset($params['period']);
        $hasStart = isset($params['startDate']);
        $hasEnd = isset($params['endDate']);
    
        if (!$hasPeriod && !($hasStart && $hasEnd)) {
            throw new \InvalidArgumentException('You must provide either "period" or both "startDate" and "endDate".');
        }
    
        if ($hasPeriod && ($hasStart || $hasEnd)) {
            throw new \InvalidArgumentException('Use either "period" or "startDate" and "endDate", not both.');
        }
    
        if ($hasStart xor $hasEnd) {
            throw new \InvalidArgumentException('You must provide both "startDate" and "endDate" together.');
        }
    }
}
