<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Upgrade script
 *
 * @package    local_linkchecker_robot
 * @copyright  Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade script
 *
 * @param integer $oldversion a version no
 */
function xmldb_local_linkchecker_robot_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2015040801) {

        // Define field httpmsg to be added to linkchecker_url.
        $table = new xmldb_table('linkchecker_url');
        $field = new xmldb_field('httpmsg', XMLDB_TYPE_TEXT, null, null, null, null, null, 'ignoredtime');

        // Conditionally launch add field httpmsg.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Linkchecker_robot savepoint reached.
        upgrade_plugin_savepoint(true, 2015040801, 'local', 'linkchecker_robot');
    }

    if ($oldversion < 2015041502) {

        // Define table linkchecker_url to be created.
        $table = new xmldb_table('linkchecker_url');

        // Adding indexes to table linkchecker_url.
        $index = new xmldb_index('needscrawl', XMLDB_INDEX_NOTUNIQUE, array('needscrawl'));
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Linkchecker_robot savepoint reached.
        upgrade_plugin_savepoint(true, 2015041502, 'local', 'linkchecker_robot');
    }

    if ($oldversion < 2015041503) {

        // Define index needscrawl_id (not unique) to be added to linkchecker_url.
        $table = new xmldb_table('linkchecker_url');
        $index = new xmldb_index('needscrawl_id', XMLDB_INDEX_NOTUNIQUE, array('needscrawl', 'id'));

        // Conditionally launch add index needscrawl_id.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Linkchecker_robot savepoint reached.
        upgrade_plugin_savepoint(true, 2015041503, 'local', 'linkchecker_robot');
    }

    if ($oldversion < 2015041504) {

        $table = new xmldb_table('linkchecker_url');

        $index = new xmldb_index('httpcode', XMLDB_INDEX_NOTUNIQUE, array('httpcode'));
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        upgrade_plugin_savepoint(true, 2015041504, 'local', 'linkchecker_robot');
    }

    if ($oldversion < 2015053002) {

        // Define table linkchecker_history to be created.
        $table = new xmldb_table('linkchecker_history');

        // Adding fields to table linkchecker_history.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('startcrawl', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('endcrawl', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('cronticks', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('urls', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('links', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('broken', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('oversize', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table linkchecker_history.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for linkchecker_history.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Linkchecker_robot savepoint reached.
        upgrade_plugin_savepoint(true, 2015053002, 'local', 'linkchecker_robot');
    }

    return true;
}
