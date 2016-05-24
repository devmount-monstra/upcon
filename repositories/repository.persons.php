<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Persons repository class
 *
 * Handles all persons table database requests
 *
 */
class PersonRepository
{
    /**
     * Get persons table object
     *
     * @return object
     *
     */
    public static function getTable()
    {
        return new Table('upcon_persons');
    }


    /**
     * Get person by ID
     *
     * @param  int  $id  Event ID to return
     *
     * @return object
     *
     */
    public static function getById($id)
    {
        $objects = self::getTable();
        return reset($objects->select('[id=' . $id . ']'));
    }


    /**
     * Insert new person
     *
     * @param  array  $data  Data of person to insert
     *
     * @return bool
     *
     */
    public static function insert($data)
    {
        $objects = self::getTable();
        return $objects->insert($data);
    }


    /**
     * Update existing person
     *
     * @param  int    $id    Event ID to update
     * @param  array  $data  Data of person to insert
     *
     * @return bool
     *
     */
    public static function update($id, $data)
    {
        $objects = self::getTable();
        return $objects->update($id, $data);
    }


    /**
     * Delete person
     *
     * @param  int  $id  Event ID to delete
     *
     * @return bool
     *
     */
    public static function delete($id)
    {
        $objects = self::getTable();
        return $objects->delete($id);
    }


    /**
     * Get all person objects
     *
     * @return array
     *
     */
    public static function getAll()
    {
        $objects = self::getTable();
        $objects_all = $objects->select(Null, 'all');
        $objects_objects = array();
        foreach ($objects_all as $o) {
            $objects_objects[$o['id']] = $o;
        }
        return $objects_objects;
    }


    /**
     * Get all active (not deleted) person objects with confirmed mail address
     *
     * @return array
     *
     */
    public static function getConfirmed()
    {
        $objects = self::getTable();
        return $objects->select('[deleted=0 and email_confirmed=1]', 'all', null, null, 'timestamp', 'DESC');
    }


    /**
     * Get all active (not deleted) person objects with pending mail address confirmation
     *
     * @return array
     *
     */
    public static function getPending()
    {
        $objects = self::getTable();
        return $objects->select('[deleted=0 and not(email_confirmed=1)]', 'all', null, null, 'timestamp', 'DESC');
    }


    /**
     * Get all deleted person objects
     *
     * @return array
     *
     */
    public static function getDeleted()
    {
        $objects = self::getTable();
        return $objects->select('[deleted=1]', 'all', null, null, 'timestamp', 'DESC');
    }


    /**
     * Returns last record id
     *
     * @return int id
     *
     */
    public static function getLastId()
    {
        $objects = self::getTable();
        return $objects->lastId();
    }

}