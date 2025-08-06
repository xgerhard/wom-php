<?php

namespace WOM\Resources;

use WOM\Models\Competition\Competition;
use WOM\Models\Competition\Top5ProgressResult;
use WOM\Models\Competition\Details;
use WOM\Models\Delta\LeaderboardEntry;

class Competitions extends BaseResource
{
    /**
     * Searches for competitions that match a title, type, metric and status filter.
     *
     * @param array $params
     * @return Competition[] Array of Competition models
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#search-competitions
     */
    public function search(array $params = []): array
    {
        $response = $this->request('GET', 'competitions', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Competition::class);
    }

    /**
     * Fetches the competition's full details, including all the participants and their progress.
     *
     * @param integer $id
     * @return Details
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#get-competition-details
     */
    public function get(int $id): Details
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        $response = $this->request('GET', 'competitions/' . $id);

        return new Details($response);
    }

    /**
     * Fetches the competition's details in CSV format.
     *
     * @param integer $id
     * @return string
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#get-competition-details-csv
     */
    public function getDetailsCSV(int $id): string
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        $response = $this->request('GET', 'competitions/' . $id .'/csv');

        return $response;
    }

    /**
     * Fetches all the values (exp, kc, etc) in chronological order within the bounds of the competition, for the top 5 participants.
     *
     * @param array $params
     * @return Top5ProgressResult[] Array of Top5ProgressResult models
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#get-top-participants-history
     */
    public function getTopParticipantsHistory(int $id, string $metric = ''): array
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        $params = [];

        if (!empty($metric)) {
           $params['metric'] = $metric;
        }

        $response = $this->request('GET', 'competitions/'. $id .'/top-history', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Top5ProgressResult::class);
    }

    /**
     * Creates a new competition
     *
     * @param array $params
     * @return Competition
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#create-competition
     */
    public function create(array $params = []): Competition
    {
        $hasGroupId = isset($params['groupId']);
        $hasParticipants = isset($params['participants']);
        $hasTeams = isset($params['teams']);

        if (
            ($hasGroupId && $hasParticipants) ||
            ($hasParticipants && $hasTeams)
        ) {
            throw new \InvalidArgumentException('You may only provide one of: "groupId", "participants", or "teams". Only "teams" may optionally be combined with "groupId".');
        }

        if (!$hasGroupId && !$hasParticipants && !$hasTeams) {
            throw new \InvalidArgumentException('You must provide one of: "groupId", "participants", or "teams".');
        }

        foreach (['title', 'metric', 'startsAt', 'endsAt'] as $field) {
            if (!isset($params[$field])) {
                throw new \InvalidArgumentException('The "'. $field .'" parameter is required.');
            }
        }

        $response = $this->request('POST', 'competitions', [
            'json' => $params
        ]);
    
        return new Competition($response);
    }

    /**
     * Edits an existing competition.
     *
     * @param integer $id
     * @param array $params
     * @return Competition
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#edit-competition
     */
    public function edit(int $id, array $params = []): Competition
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('PUT', 'competitions/' . $id, [
            'json' => $params
        ]);
    
        return new Competition($response);
    }

    /**
     * Delete an existing competition.
     *
     * @param integer $id
     * @param string $verificationCode
     * @return mixed
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#delete-competition
     */
    public function delete(int $id, string $verificationCode)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (empty($verificationCode)) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('DELETE', 'competitions/' . $id, [
            'json' => ['verificationCode' => $verificationCode]
        ]);
    
        return $response;
    }

    /**
     * Adds all (valid) given participants to a competition, ignoring duplicates.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#add-participants
     */
    public function addParticipants(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (!isset($params['participants']) || !is_array($params['participants'])) {
            throw new \InvalidArgumentException('The "participants" parameter is required and must be an array of usernames.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('POST', 'competitions/' . $id . '/members' , [
            'json' => $params
        ]);
    
        return $response;
    }

    /**
     * Remove all given usernames from a competition, ignoring usernames that aren't competing.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#remove-participants
     */
    public function removeParticipants(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (!isset($params['participants']) || !is_array($params['participants'])) {
            throw new \InvalidArgumentException('The "participants" parameter is required and must be an array of usernames.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('DELETE', 'competitions/' . $id . '/participants' , [
            'json' => $params
        ]);
    
        return $response;
    }

    /**
     * Adds all (valid) given teams to a team competition, ignoring duplicates.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#add-teams
     */
    public function addTeams(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (!isset($params['teams']) || !is_array($params['teams'])) {
            throw new \InvalidArgumentException('The "teams" parameter is required and must be an array of teams. Each team must include a name and an array of participants.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('POST', 'competitions/' . $id . '/teams' , [
            'json' => $params
        ]);
    
        return $response;
    }

    /**
     * Remove all given usernames from a competition, ignoring usernames that aren't competing.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#remove-teams
     */
    public function removeTeams(int $id, array $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (!isset($params['teamNames']) || !is_array($params['teamNames'])) {
            throw new \InvalidArgumentException('The "teamNames" parameter is required and must be an array of team names.');
        }

        if (!isset($params['verificationCode'])) {
            throw new \InvalidArgumentException('The "verificationCode" parameter is required.');
        }

        $response = $this->request('DELETE', 'competitions/' . $id . '/teams' , [
            'json' => $params
        ]);
    
        return $response;
    }

    /**
     * Attempts to update any outdated competition participants.
     *
     * @param integer $id
     * @param array $params
     * @return mixed
     * @see https://docs.wiseoldman.net/api/competitions/competition-endpoints#update-all-outdated-participants
     */
    public function updateAllParticipants(int $id, string $verificationCode)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Competition ID is required.');
        }

        if (empty($verificationCode)) {
            throw new \InvalidArgumentException('VerificationCode is required.');
        }

        $response = $this->request('POST', 'competitions/' . $id . '/update-all' , [
            'json' => [
                'verificationCode' => $verificationCode
            ]
        ]);
    
        return $response;
    }
}
