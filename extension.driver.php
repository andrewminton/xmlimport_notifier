<?php

	require_once EXTENSIONS.'/xmlimporter/lib/class.xmlimporter.php';
	require_once(TOOLKIT . '/class.gateway.php');
	require_once(TOOLKIT . '/class.fieldmanager.php');
	require_once(TOOLKIT . '/class.entrymanager.php');
	require_once(TOOLKIT . '/class.sectionmanager.php');
	require_once(TOOLKIT . '/class.general.php');
	
	require_once(EXTENSIONS . '/xmlimporter/lib/class.xmlimporterhelpers.php');
	require_once(EXTENSIONS . '/xmlimport_notifier/lib/class.entrycounter.php');
		
	class extension_xmlimport_notifier extends Extension
	{	
		//public $total = 0;
		
		public function getSubscribedDelegates()
		{
			return array(
				array(
					'page' => '/xmlimporter/importers/run/',
					'delegate' => 'XMLImporterEntryPostCreate',
					'callback' => '__entryCreated'
				),
				array(
					'page' => '/xmlimporter/importers/run/',
					'delegate' => 'XMLImporterEntryPostEdit',
					'callback' => '__entryEdited'
				),
				array(
					'page' => '/xmlimporter/importers/run/',
					'delegate' => 'XMLImporterImportPostRun',
					'callback' => 'EmailNotify'
				),
				array(
					'page' => '/xmlimporter/importers/run/',
					'delegate' => 'XMLImporterImportPostRunErrors',
					'callback' => 'EmailNotifyErrors'
				),
			);
		}
		
		public function __construct()
		{
			
			parent::__construct();
			//self::EmailNotifier();
			//var_dump($this->total);
			
			
		}
		
		public function __entryCreated($context)
		{	
			$one = count($context['entry']);
			EntryCounter::getTotal($one);
			//
			//self::totalCount($one);
		
		}
		
		public function __entryEdited($context)
		{	
			$one = count($context['entry']);
			EntryCounter::getTotal($one);
			//
			//self::totalCount($one);

		}
		
		public function EmailNotify($context)
		{
			//var_dump($context);
			$created = $context[0];
			$updated = $context[1];
			$skipped = $context[2];
			
			var_dump($created,$updated,$skipped);
			if($created >0 || $updated > 0 || $skipped > 0)
			
			{
				$message = "A total of ".$created." new Entries have been created, ".$updated." entries updated and ".$skipped." entries skipped";
				$mail = mail('me@localhost', 'My Subject', $message);
			}
		}
		
		public function EmailNotifyErrors($context)
		{
			var_dump($context);
			//$created = $context[0];
			//$updated = $context[1];
			//$skipped = $context[2];
			
			//var_dump($created,$updated,$skipped);
			/*if($created >0 || $updated > 0 || $skipped > 0)
			
			{
				$message = "A total of ".$created." new Entries have been created, ".$updated." entries updated and ".$skipped." entries skipped";
				$mail = mail('me@localhost', 'My Subject', $message);
			}*/
		}
		
		// Check for Email entry in config for this extension.. if no email Throw notification to page and email the admin account to notify that Importers don't have a specified email address set..
		
	}