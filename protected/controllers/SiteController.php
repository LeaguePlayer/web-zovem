<?php

class SiteController extends FrontController
{

	/**
	 * Declares class-based actions.
	 */

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $this->title = Yii::app()->config->get('app.name');
		$this->render('index', array('sections' => Section::getIndexSections($this->city)));
	}

	private function readFile($file)
	{
		$path = Yii::getPathOfAlias('webroot').'/media/import/';
		$handle = fopen($path.$file, 'rb');
		$contents = stream_get_contents($handle);
		fclose($handle);
		return $contents;
	}

	
	private function recursive_array_search($needle,$haystack) {
	    foreach($haystack as $key=>$value) {
	        $current_key=$key;
	        if((strpos($value, $needle) !== FALSE) OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
	            return $current_key;
	        }
	    }
	    return false;
	}

	private function getLines($string) {
		return preg_split ('/$\R?^/m', $string);
	}

	private function getItem($lines, $from = 0) {

		$valuesFrom = $this->recursive_array_search('{{}}', $lines);
		if ($valuesFrom > $from)
			$from = $valuesFrom + 1;

		$to = NULL;
		for($i = $from; $i<count($lines); $i++)
			if (strpos($lines[$i], '{end}') !== FALSE) {
				$to = $i;
				break;
			}

		if (!is_null($to)) {
			return array(
				'data' => array_slice($lines, $from, $to - $from + 1),
				'end' => $to,
			);
		}
		else {
			return FALSE;
		}

	}

	private function getValue($item, $key)
	{
		$startKey = '{\}'.$key.'{}';
		$endKeys = array('{\}', '{end}');

		$from = $this->recursive_array_search($startKey, $item);
		$to = NULL;
		for($i = $from + 1; $i < count($item); $i++) {
			if (!is_null($to))
				break;
			foreach ($endKeys as $key) {
				if (strpos($item[$i], $key) !== FALSE) {
					$to = $i-1;
					break;
				}
			}
		}

		if (!is_null($to)) {
			$result = '';
			$fieldLines = array_slice($item, $from, $to - $from + 1);
			foreach ($fieldLines as $string) {
				$string = str_replace($startKey, '', $string);
				$result .= $string;
			}
			if (count($fieldLines) == 1)
				$result = trim(preg_replace('/\s+/', ' ', $string));

			return $result;
		}
		else {
			return FALSE;
		}
	}


	/* imports small files */
	private function import($filename, $keys)
	{
		$backup = $this->getLines( $this->readFile($filename) );

		$result = array();
		
		$backup_item = $this->getItem($backup);
		while ($backup_item != FALSE) {
			$record = array();
			foreach ($keys as $key) {
				$value = $this->getValue($backup_item['data'], $key);
				if ($value)
					$record[$key] = $value;
			}

			$result [] = $record;

			$backup_item = $this->getItem($backup, $backup_item['end'] + 1);
		}

		return $result;
	}

	private function dateDifference($date_1, $date_2, $differenceFormat = '%a' )
	{
	    $datetime1 = date_create($date_1);
	    $datetime2 = date_create($date_2);
	    
	    $interval = date_diff($datetime1, $datetime2);
	    
	    return $interval->format($differenceFormat);
	}

	private function validateDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}


	private function saveEvent($record, $i = 0)
	{
		if ($record['event_status'] == 9)
			return;
		if (!$this->validateDate($record['event_start']) OR !$this->validateDate($record['event_end']))
			return;

		echo $i . '<br>'; flush();

		$date_diff = $this->dateDifference($record['event_start'], $record['event_end']);
		if ( $date_diff < 4) {
			/*$event = new Event;
			$event->user_id = 1;
			$event->status = 0;
			if ($record['event_status'] == 1)
				$event->status = 2;
			if ($record['event_status'] == 9)
				$event->status = 1;

			$event->save();*/
			$status = 0;
			if ($record['event_status'] == 1)
				$status = 2;
			if ($record['event_status'] == 9)
				$status = 1;

			$command = Yii::app()->db->createCommand();

			$command->insert('tbl_event', array(
			    'user_id' => 1,
			    'status' => $status,
			));

			$event_id = Yii::app()->db->lastInsertID;

			$command->insert('tbl_contents', array(
			    'event_id' => $event_id,
			    'user_id' => 1,
			    'title' => $record['event_name'],
			    'country_id' => $record['event_strana'],
			    'city_id' => $record['event_town'],
			    'address' => ($record['event_map'] ? $record['event_map'] : $record['event_place']),
			    'way' => $record['event_place'],
			    'wswg_body' => $record['event_text'],
			    'is_free' => $record['event_free'],
			    'terms' => $record['event_requirements'],
			    'web' => $record['event_site'],
			    'section_id' => $record['event_razdel'],
			    'type' => $record['event_recomend'],
			    'label' => $record['event_note'],
			    'is_federal' => $record['event_show_everywhere'],
			));

			$contents_id = Yii::app()->db->lastInsertID;

			/*$contents = new Contents;
			$contents->event_id = $event->id;
			$contents->user_id = 1;
			$contents->title = $record['event_name'];
			$contents->country_id = $record['event_strana'];
			$contents->city_id = $record['event_town'];
			$contents->address = ($record['event_map'] ? $record['event_map'] : $record['event_place']);
			$contents->way = $record['event_place'];
			$contents->wswg_body = $record['event_text'];
			$contents->is_free = $record['event_free'];
			$contents->terms = $record['event_requirements'];
			$contents->web = $record['event_site'];
			$contents->section_id = $record['event_razdel'];
			$contents->type = $record['event_recomend'];
			$contents->label = $record['event_note'];
			$contents->is_federal = $record['event_show_everywhere'];
			$contents->save();*/


			/*($event->contents_id = $contents->id;
			$event->save();*/

			$command->update('tbl_event', array(
			    'contents_id'=>$contents_id,
			), 'id=:id', array(':id'=>$event_id));


			for($i = 0; $i<=$date_diff; $i++) {
				/*$time = new Time;
				$time->date =  date('Y-m-d', strtotime($record['event_start']." + ".$i." days")) ;
				$time->start_time =  ($record['event_time'] ? $record['event_time'].':00' : '09:00:00');
				
				$date = new DateTime($time->start_time);
				$date->add(new DateInterval('PT3H'));

				$time->end_time =  $date->format('H:i:s');
				$time->contents_id = $contents->id;
				$time->event_id = $event->id;
				$time->save();*/

				$command->insert('tbl_time', array(
				    'date' => date('Y-m-d', strtotime($record['event_start']." + ".$i." days")),
				    'start_time' => ($record['event_time'] ? $record['event_time'].':00' : '09:00:00'),
				    'end_time' => $date->format('H:i:s'),
				    'contents_id' => $contents_id,
				    'event_id' => $event_id,
				    'start_datetime' => date('Y-m-d', strtotime($record['event_start']." + ".$i." days")) . ' ' . ($record['event_time'] ? $record['event_time'].':00' : '09:00:00'),
				    'end_datetime' => date('Y-m-d', strtotime($record['event_start']." + ".$i." days")) . ' ' . $date->format('H:i:s'),
				));
			}
		}
	}

	private function eventsImport($filename)
	{
		$keys = array(
			'id', 
			'event_name', 
			'event_razdel', 
			'event_strana', 
			'event_town', 
			'event_metro', 
			'event_place', 
			'event_start', 
			'event_end', 
			'event_time', 
			'event_text', 
			'event_requirements', 
			'event_contact', 
			'event_site', 
			'event_status', 
			'event_recomend', 
			'event_note', 
			'event_show_everywhere', 
			'event_map', 
			'event_free', 
			'event_forum', 
			'event_region', 
			'event_map_geo',
		);
		$path = Yii::getPathOfAlias('webroot').'/media/import/';
		$handle = fopen($path.$filename, "r");
		$lines = array();
		$i = 0;
		if ($handle) {
			$data_starts = FALSE;
		    while (($buffer = fgets($handle, 4096)) !== FALSE) {

	        	if (strpos($buffer, '{{}}') !== FALSE) {
	        		$data_starts = TRUE;
	        		continue;
	        	}

	        	if ($data_starts) {
			    	$lines []= $buffer;
		        	if (strpos($buffer, '{end}') !== FALSE) {
		        		$record = array();
						foreach ($keys as $key) {
							$value = $this->getValue($lines, $key);
							if ($value)
								$record[$key] = $value;
						}

						$this->saveEvent($record, $i++);

		        		$lines = array();
		        	}
	        	}
		    }
		    fclose($handle);
		}
	}

	private function eventsDBImport()
	{
		 mysql_connect("localhost", "root", "") or die(mysql_error()); 
		 mysql_select_db("zovem_ru") or die(mysql_error()); 
		 $result = mysql_query("SELECT * FROM zevaka_events") 
		 or die(mysql_error()); 
		 $events = array();
		 while( $row = mysql_fetch_assoc( $result)){
		    $events[] = $row; // Inside while loop
		 }

	 	$connection=Yii::app()->db;

	 	$sql="INSERT INTO tbl_event(user_id, status) 
	 	VALUES(:user_id,:status)";
		$insertEventCommand = $connection->createCommand($sql);

	 	$sql="INSERT INTO tbl_contents(event_id, user_id, title, country_id, city_id, address, way, wswg_body, is_free, terms, web, section_id, type, label, is_federal) 
	 	VALUES(:event_id, :user_id, :title, :country_id, :city_id, :address, :way, :wswg_body, :is_free, :terms, :web, :section_id, :type, :label, :is_federal)";
		$insertContentsCommand = $connection->createCommand($sql);

	 	$sql="INSERT INTO tbl_time(date, start_time, end_time, contents_id, event_id, start_datetime, end_datetime) 
	 	VALUES(:date, :start_time, :end_time, :contents_id, :event_id, :start_datetime, :end_datetime)";
		$insertTimeCommand = $connection->createCommand($sql);

	 	$sql="UPDATE tbl_event SET contents_id=:contents_id WHERE id=:id";
		$updateEventCommand = $connection->createCommand($sql);

		 foreach ($events as $record) {
		 	if (!$this->validateDate($record['event_start']) OR !$this->validateDate($record['event_end']))
				continue;
			$date_diff = $this->dateDifference($record['event_start'], $record['event_end']);
			if ( $date_diff < 4) {
				$status = 0;
				if ($record['event_status'] == 1)
					$status = 2;
				if ($record['event_status'] == 9)
					$status = 1;
				$insertEventCommand->bindValue(':user_id', 1);
				$insertEventCommand->bindValue(':status', $status);
				$insertEventCommand->execute();

				$event_id = Yii::app()->db->lastInsertID;

				$insertContentsCommand->bindValue(':event_id', $event_id);
				$insertContentsCommand->bindValue(':user_id', 1);
				$insertContentsCommand->bindValue(':title', $record['event_name']);
				$insertContentsCommand->bindValue(':country_id', $record['event_strana']);
				$insertContentsCommand->bindValue(':city_id', $record['event_town']);
				$insertContentsCommand->bindValue(':address', ($record['event_map'] ? $record['event_map'] : $record['event_place']));
				$insertContentsCommand->bindValue(':way', $record['event_place']);
				$insertContentsCommand->bindValue(':wswg_body', $record['event_text']);
				$insertContentsCommand->bindValue(':is_free', $record['event_free']);
				$insertContentsCommand->bindValue(':terms', $record['event_requirements']);
				$insertContentsCommand->bindValue(':web', $record['event_site']);
				$insertContentsCommand->bindValue(':section_id', $record['event_razdel']);
				$insertContentsCommand->bindValue(':type', $record['event_recomend']);
				$insertContentsCommand->bindValue(':label', $record['event_note']);
				$insertContentsCommand->bindValue(':is_federal', $record['event_show_everywhere']);
				$insertContentsCommand->execute();

				$contents_id = Yii::app()->db->lastInsertID;

				$updateEventCommand->bindValue(':id', $event_id);
				$updateEventCommand->bindValue(':contents_id', $contents_id);
				$updateEventCommand->execute();

				for($i = 0; $i<=$date_diff; $i++) {
					$date = new DateTime($time->start_time);
					$date->add(new DateInterval('PT3H'));
					$insertTimeCommand->bindValue(':date', date('Y-m-d', strtotime($record['event_start']." + ".$i." days")));
					$insertTimeCommand->bindValue(':start_time', ($record['event_time'] ? $record['event_time'].':00' : '09:00:00'));
					$insertTimeCommand->bindValue(':end_time', $date->format('H:i:s'));
					$insertTimeCommand->bindValue(':contents_id', $contents_id);
					$insertTimeCommand->bindValue(':event_id', $event_id);
					$insertTimeCommand->bindValue(':start_datetime', date('Y-m-d', strtotime($record['event_start']." + ".$i." days")) . ' ' . ($record['event_time'] ? $record['event_time'].':00' : '09:00:00'));
					$insertTimeCommand->bindValue(':end_datetime', date('Y-m-d', strtotime($record['event_start']." + ".$i." days")) . ' ' . $date->format('H:i:s'));
					$insertTimeCommand->execute();
				}
			}
		 }
	}

	private function miscDBImport()
	{
	 	$connection=Yii::app()->db;

		 mysql_connect("localhost", "root", "") or die(mysql_error()); 
		 mysql_select_db("zovem_ru") or die(mysql_error()); 
		 $result = mysql_query("SELECT * FROM zevaka_town") 
		 or die(mysql_error()); 
		 $cities = array();
		 while( $row = mysql_fetch_assoc( $result)){
		    $cities[] = $row; // Inside while loop
		 }

	 	$sql="INSERT INTO tbl_city(country_id, title, status, sort) 
	 	VALUES(:country_id,:title,:status,:sort)";
		$insertCityCommand = $connection->createCommand($sql);

		$i = 1;
		 foreach ($cities as $record) {
		 	$insertCityCommand->bindValue(':country_id', $record['country_id']);
		 	$insertCityCommand->bindValue(':title', $record['name']);
		 	$insertCityCommand->bindValue(':status', 1);
		 	$insertCityCommand->bindValue(':sort', $i);
		 	$insertCityCommand->execute();
		 	$i++;
		 }


		 mysql_connect("localhost", "root", "") or die(mysql_error()); 
		 mysql_select_db("zovem_ru") or die(mysql_error()); 
		 $result = mysql_query("SELECT * FROM zevaka_razdel") 
		 or die(mysql_error()); 
		 $sections = array();
		 while( $row = mysql_fetch_assoc( $result)){
		    $sections[] = $row; // Inside while loop
		 }

	 	$sql="INSERT INTO tbl_section(title, sort, img_icon, img_map, img_active) 
	 	VALUES(:title,:sort,:img_icon,:img_map,:img_active)";
		$insertSectionCommand = $connection->createCommand($sql);

		$i = 1;
		 foreach ($sections as $record) {
		 	$insertSectionCommand->bindValue(':title', $record['name']);
		 	$insertSectionCommand->bindValue(':img_icon', '12fb42857.png');
		 	$insertSectionCommand->bindValue(':img_map', '45ab3cfe5.png');
		 	$insertSectionCommand->bindValue(':img_active', '28d1dfe1a.png');
		 	$insertSectionCommand->bindValue(':sort', $i);
		 	$insertSectionCommand->execute();
		 	$i++;
		 }
	}

	public function actionImport($what)
	{
		foreach (Yii::app()->log->routes as $route)
                        $route->enabled=false;
		$backup_files = array(
			'countries' => 'zevaka_country.txt',
			'cities' => 'zevaka_town.txt',
			'sections' => 'zevaka_razdel.txt',
			'events' => 'zevaka_events.txt',
		);

		/* СТРАНЫ И ГОРОДА 
		if ($what == 'countries') {
			
			$countries = $this->import($backup_files['countries'], array(
				'id',
				'event_name',
			));

			echo count($countries);


 		}*/

 		if ($what == 'events') {
 			$this->eventsDBImport();
 		}

 		if ($what == 'misc') {
 			$this->miscDBImport();
 		}


	}

	/**
	 * This is the action to handle external exceptions.
	 */

}