<?php 
	
	require_once(TOOLKIT . '/class.gateway.php');
	require_once(TOOLKIT . '/class.fieldmanager.php');
	require_once(TOOLKIT . '/class.entrymanager.php');
	require_once(TOOLKIT . '/class.sectionmanager.php');
	
	class EntryCounter {
	
		
		public function getTotal(&$total)
		{
			$total++;
			return $total;
		}
		
	}