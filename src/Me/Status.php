<?php

namespace TeamWorkPm\Me;

use TeamWorkPm\Rest\Model;

class Status extends Model
{
    protected function init()
    {
        $this->parent = 'userstatus';
        $this->action = 'status';
        $this->fields = [
          'status'=>true,
          'notify'=>false
        ];
    }

    /**
     * Retrieve a Persons Status
     *
     * GET /me/status
     *
     * Returns the latest status post for a user
     *
     * @return \TeamWorkPm\Response\Model
     * @throws \TeamWorkPm\Exception
     */
    public function get()
    {
        return $this->rest->get("me/$this->action");
    }

    /**
     * Create Status
     *
     * POST /me/status
     *
     * This call will create a status entry. The Id of the new status is returned in header "id".
     *
     * @param array $data
     * @return int
     */
    public function insert(array $data)
    {
        return $this->rest->post("me/$this->action", $data);
    }

    /**
     * Update Status
     *
     * PUT /me/status/#{status_id}
     *
     * Modifies a status post.
     *
     * @param array $data
     *
     * @return bool
     * @throws \TeamWorkPm\Exception
     */
    public function update(array $data)
    {
        $id = empty($data['id']) ? 0  : (int) $data['id'];
        if ($id <= 0) {
            throw new \TeamWorkPm\Exception('Required field id');
        }
        return $this->rest->put("me/$this->action/$id", $data);
    }

    /**
     * Delete Status
     *
     * DELETE /me/status/#{status_id}
     *
     * This call will delete a particular status message.
     * Returns HTTP status code 200 on success.
     *
     * @param int $id
     *
     * @return bool
     * @throws \TeamWorkPm\Exception
     */
    public function delete($id)
    {
        $id = (int) $id;
        if ($id <= 0) {
            throw new \TeamWorkPm\Exception('Invalid param id');
        }
        return $this->rest->delete("me/$this->action/$id");
    }

    /**
     * @param array $data
     *
     * @return bool
     * @throws \TeamWorkPm\Exception
     */
    final public function save(array $data)
    {
        return array_key_exists('id', $data) ?
            $this->update($data):
            $this->insert($data);
    }
}
