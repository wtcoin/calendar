<?php
/**
 * ownCloud - Calendar App
 *
 * @author Georg Ehrke
 * @copyright 2014 Georg Ehrke <oc.list@georgehrke.com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OCA\Calendar\Backend;

use OCP\AppFramework\IAppContainer;
use OCP\Share;

use OCP\Calendar\Backend;
use OCP\Calendar\BackendException;
use OCP\Calendar\ICalendar;
use OCP\Calendar\ICalendarCollection;
use OCP\Calendar\IObject;
use OCP\Calendar\IObjectCollection;
use OCP\Calendar\ObjectType;
use OCP\Calendar\Permissions;
use OCP\Calendar\DoesNotExistException;
use OCP\Calendar\CorruptDataException;

use OCA\Calendar\Share\Calendar as CalendarShare;
use OCA\Calendar\Db\Calendar;
use OCA\Calendar\Db\CalendarCollection;
use OCA\Calendar\Db\Object;
use OCA\Calendar\Db\ObjectCollection;

class Sharing extends Backend {

	/**
	 * @var \OCA\Calendar\BusinessLayer\ObjectBusinessLayer
	 */
	private $objects;

	/**
	 * constructor
	 * @param IAppContainer $app
	 * @param array $parameters
	 */
	public function __construct(IAppContainer $app, array $parameters){
		parent::__construct($app, 'org.ownCloud.sharing');

		$this->objects = $app->query('ObjectBusinessLayerWithoutSharing');
	}


	/**
	 * returns whether or not a backend can be enabled
	 * @returns boolean
	 */
	public function canBeEnabled() {
		return Share::isEnabled();
	}


	/**
	 * returns whether or not calendar objects should be cached
	 * @param string $calendarURI
	 * @param string $userId
	 * @returns boolean
	 */
	public function cacheObjects($calendarURI, $userId) {
		return false;
	}


	/**
	 * returns information about calendar $calendarURI of the user $userId
	 * @param string $calendarURI
	 * @param string $userId
	 * @returns ICalendar
	 * @throws DoesNotExistException if uri does not exist
	 */
	public function findCalendar($calendarURI, $userId) {
		//TODO improve, if necessary, send pr for sharing api in core
		/** @var ICalendarCollection $calendars */
		$calendars = Share::getItemsSharedWithUser('calendar', $userId, CalendarShare::CALENDAR);

		foreach ($calendars as $calendar) {
			/**	@var ICalendar $calendar */
			if ($calendar->getPrivateUri() === $calendarURI) {
				return $calendar;
			}
		}

		throw new DoesNotExistException();
	}


	/**
	 * returns all calendars of the user $userId
	 * @param string $userId
	 * @param integer $limit
	 * @param integer $offset
	 * @returns ICalendarCollection
	 * @throws DoesNotExistException if uri does not exist
	 */
	public function findCalendars($userId, $limit=null, $offset=null) {
		return Share::getItemsSharedWithUser('calendar', $userId, CalendarShare::CALENDAR);
	}


	/**
	 * returns information about the object (event/journal/todo) with the uid $objectURI in the calendar $calendarURI of the user $userId
	 * @param ICalendar $calendar
	 * @param string $objectURI
	 * @returns IObject
	 * @throws DoesNotExistException if calendar does not exist
	 * @throws DoesNotExistException if object does not exist
	 */
	public function findObject(ICalendar &$calendar, $objectURI) {

	}


	/**
	 * returns all objects in the calendar $calendarURI of the user $userId
	 * @param ICalendar $calendar
	 * @param integer $limit
	 * @param integer $offset
	 * @returns IObjectCollection
	 * @throws DoesNotExistException if calendar does not exist
	 */
	public function findObjects(ICalendar &$calendar, $limit, $offset) {

	}
}