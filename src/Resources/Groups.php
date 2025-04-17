<?php

namespace WOM\Resources;

use WOM\Models\Competition\Competition;
use WOM\Models\Delta\LeaderboardEntry as DeltaLeaderboardEntry;
use WOM\Models\Group\Group;
use WOM\Models\Group\Activity;
use WOM\Models\Group\Details;
use WOM\Models\Group\HiscoreEntry;
use WOM\Models\Group\Statistics;
use WOM\Models\NameChange\NameChange;
use WOM\Models\Player\Achievement;
use WOM\Models\Record\LeaderboardEntry as RecordLeaderboardEntry;
use WOM\Enums\Group\Role;

class Groups extends BaseResource
{
    /**
     * Searches for groups that match a partial name.
     *
     * @param array $params
     * @return Group[] Array of Group models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#search-groups
     */
    public function search(array $params = []): array
    {
        $response = $this->request('GET', 'groups', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Group::class);
    }

    /**
     * Fetches a group's details.
     *
     * @param integer $id
     * @return Details
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-details
     */
    public function get(int $id): Details
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id);

        return new Details($response);
    }

    /**
     * Creates a new group.
     *
     * @param array $params
     * @return Details
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#create-group
     */
    public function create(array $params = []): Details
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
    
        return new Details($response);
    }

    /**
     * Edit an existing group.
     *
     * @param integer $id
     * @param array $params
     * @return Details
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#edit-group
     */
    public function edit(int $id, array $params = []): Details
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
    
        return new Details($response);
    }

    /**
     * Delete an existing group.
     *
     * @param integer $id
     * @param string $verificationCode
     * @return mixed
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#delete-group
     */
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

    /**
     * Add members to an existing group.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#add-members
     */
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

    /**
     * Remove members from an existing group.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#remove-members
     */
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

    /**
     * Changes the role of an existing group member.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#change-member-role
     */
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

    /**
     * Attempts to update any outdated group members.
     *
     * @param integer $id
     * @param string $verificationCode
     * @return mixed
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#update-all-outdated-members
     */
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

    /**
     * Fetches all of the group's competitions.
     *
     * @param integer $id
     * @param array $params
     * @return Competition[] Array of Competition models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-competitions
     */
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

    /**
     * Fetches the top gains for a group's member list (filtered by metric and period/date range).
     *
     * @param integer $id
     * @param array $params
     * @return DeltaLeaderboardEntry[] Array of LeaderboardEntry models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-gains
     */
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

    /**
     * Fetches the group's latest achievements.
     *
     * @param integer $id
     * @param array $params
     * @return Achievement[] Array of Achievement models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-achievements
     */
    public function getAchievements(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/achievements', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Achievement::class);
    }

    /**
     * Fetches a group's record leaderboard for a specific metric and period.
     *
     * @param integer $id
     * @param array $params
     * @return RecordLeaderboardEntry[] Array of LeaderboardEntry models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-records
     */
    public function getRecords(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['period'])) {
            throw new \InvalidArgumentException('The "period" parameter is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('The "metric" parameter is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/records', [
            'query' => $params
        ]);

        return $this->mapToModels($response, RecordLeaderboardEntry::class);
    }

    /**
     * Fetches a group's hiscores for a specific metric.
     *
     * @param integer $id
     * @param array $params
     * @return HiscoreEntry[] Array of HiscoreEntry models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-hiscores
     */
    public function getHiscores(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('The "metric" parameter is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/hiscores', [
            'query' => $params
        ]);

        return $this->mapToModels($response, HiscoreEntry::class);
    }

    /**
     * Fetches a group's latest name changes.
     *
     * @param integer $id
     * @param array $params
     * @return NameChange[] Array of NameChange models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-name-changes
     */
    public function getNameChanges(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/name-changes', [
            'query' => $params
        ]);

        return $this->mapToModels($response, NameChange::class);
    }

    /**
     * Fetches a group's general statistics.
     *
     * @param integer $id
     * @return Statistics
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-statistics
     */
    public function getStatistics(int $id): Statistics
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/statistics');

        return new Statistics($response);
    }

    /**
     * Fetches a group's activity.
     *
     * @param integer $id
     * @return Activity[] Array of Activity models
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-activity
     */
    public function getActivity(int $id): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/activity');

        return $this->mapToModels($response, Activity::class);
    }

    /**
     * Fetches the group's members in CSV format.
     *
     * @param integer $id
     * @return string
     * @see https://docs.wiseoldman.net/groups-api/group-endpoints#get-group-members-csv
     */
    public function getMembersCSV(int $id): string
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/csv');

        return $response;
    }
}
