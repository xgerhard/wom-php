<?php

namespace WOM\Resources;

use WOM\Models\Competition\Competition;
use WOM\Models\Group\GainsEntry as GroupGainsEntry;
use WOM\Models\Group\Group;
use WOM\Models\Group\Activity;
use WOM\Models\Group\BulkGainsEntry;
use WOM\Models\Group\BulkHiscoreEntry;
use WOM\Models\Group\CreateGroupResult;
use WOM\Models\Group\Details;
use WOM\Models\Group\Membership;
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
     * @param string $name
     * @param array $params Optional parameters: limit (int), offset (int).
     * @return Group[] Array of Group models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#search-groups
     */
    public function search(string $name = '', array $params = []): array
    {
        $params['name'] = $name;
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
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-details
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
     * @param array $params Required: name (string), members (array of {username, role}). Optional: clanChat (string), description (string), homeworld (int).
     * @return CreateGroupResult
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#create-group
     */
    public function create(array $params = []): CreateGroupResult
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

        return new CreateGroupResult($response);
    }

    /**
     * Edit an existing group.
     *
     * @param integer $id
     * @param array $params Required: verificationCode (string). Optional: name (string), clanChat (string), description (string), homeworld (int), members (array of {username, role}), bannerImage (string, patron only), profileImage (string, patron only), socialLinks (array, patron only).
     * @return Details
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#edit-group
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
     * @return string
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#delete-group
     */
    public function delete(int $id, string $verificationCode): string
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

        return $response->message;
    }

    /**
     * Add members to an existing group.
     *
     * @param integer $id
     * @param array $params
     * @return string
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#add-members
     */
    public function addMembers(int $id, array $params = []): string
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

        $response = $this->request('POST', 'groups/' . $id . '/members', [
            'json' => $params
        ]);

        return $response->message;
    }

    /**
     * Remove members from an existing group.
     *
     * @param integer $id
     * @param array $params
     * @return string
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#remove-members
     */
    public function removeMembers(int $id, array $params = []): string
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

        $response = $this->request('DELETE', 'groups/' . $id . '/members', [
            'json' => $params
        ]);

        return $response->message;
    }

    /**
     * Changes the role of an existing group member.
     *
     * @param integer $id
     * @param array $params
     * @return Membership
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#change-member-role
     */
    public function changeRole(int $id, array $params = []): Membership
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

        $response = $this->request('PUT', 'groups/' . $id . '/role', [
            'json' => $params
        ]);

        return new Membership($response);
    }

    /**
     * Attempts to update any outdated group members.
     *
     * @param integer $id
     * @param string $verificationCode
     * @return string
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#update-all-outdated-members
     */
    public function updateAll(int $id, string $verificationCode): string
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        if (empty($verificationCode)) {
            throw new \InvalidArgumentException('VerificationCode is required.');
        }

        $response = $this->request('POST', 'groups/' . $id . '/update-all', [
            'json' => [
                'verificationCode' => $verificationCode
            ]
        ]);

        return $response->message;
    }

    /**
     * Fetches all of the group's competitions.
     *
     * @param integer $id
     * @param array $params Optional: limit (int), offset (int).
     * @return Competition[] Array of Competition models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-competitions
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
     * @param array $params Required: metric (Enums\Metric). Optional: period (Enums\Period) or startDate + endDate (date string).
     * @return GroupGainsEntry[] Array of GainsEntry models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-gains
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

        return $this->mapToModels($response, GroupGainsEntry::class);
    }

    /**
     * Fetches every metric's gains for a group's member list (filtered by period/date range).
     *
     * @param integer $id
     * @param array $params Optional: period (Enums\Period) or startDate + endDate (date string).
     * @return BulkGainsEntry[] Array of BulkGainsEntry models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-bulk-gains
     */
    public function getBulkGains(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $this->validateTimeParams($params);

        $response = $this->request('GET', 'groups/' . $id . '/bulk-gained', [
            'query' => $params
        ]);

        return $this->mapToModels($response, BulkGainsEntry::class);
    }

    /**
     * Fetches the group's latest achievements.
     *
     * @param integer $id
     * @param array $params Optional: limit (int), offset (int).
     * @return Achievement[] Array of Achievement models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-achievements
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
     * @param array $params Required: period (Enums\Period), metric (Enums\Metric). Optional: limit (int), offset (int).
     * @return RecordLeaderboardEntry[] Array of LeaderboardEntry models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-records
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
     * @param array $params Required: metric (Enums\Metric).
     * @return HiscoreEntry[] Array of HiscoreEntry models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-hiscores
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
     * Fetches every group member's stats in a single request.
     *
     * @param integer $id
     * @return BulkHiscoreEntry[] Array of BulkHiscoreEntry models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-bulk-hiscores
     */
    public function getBulkHiscores(int $id): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/bulk-hiscores');

        return $this->mapToModels($response, BulkHiscoreEntry::class);
    }

    /**
     * Fetches a group's latest name changes.
     *
     * @param integer $id
     * @param array $params Optional: limit (int), offset (int).
     * @return NameChange[] Array of NameChange models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-name-changes
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
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-statistics
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
     * @param array $params Optional: limit (int), offset (int).
     * @return Activity[] Array of Activity models
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-activity
     */
    public function getActivity(int $id, array $params = []): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Group ID is required.');
        }

        $response = $this->request('GET', 'groups/' . $id . '/activity', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Activity::class);
    }

    /**
     * Fetches the group's members in CSV format.
     *
     * @param integer $id
     * @return string
     * @see https://docs.wiseoldman.net/api/groups/group-endpoints#get-group-members-csv
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
