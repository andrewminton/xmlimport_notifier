<?php

	require_once EXTENSIONS.'/xmlimporter/lib/class.xmlimporter.php';
	require_once(TOOLKIT . '/class.gateway.php');
	require_once(TOOLKIT . '/class.fieldmanager.php');
	require_once(TOOLKIT . '/class.entrymanager.php');
	require_once(TOOLKIT . '/class.sectionmanager.php');
	require_once(TOOLKIT . '/class.general.php');
	
	require_once(EXTENSIONS . '/xmlimporter/lib/class.xmlimporterhelpers.php');
		
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
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),
				
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => 'savePreferences'
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
			
			//
			//self::totalCount($one);
		
		}
		
		public function __entryEdited($context)
		{	
			$one = count($context['entry']);
			
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
		
		public function install()
		{
		
			Symphony::Configuration()->set('email','','xmlimport_notifier');
			Administration::instance()->saveConfig();
		
		}
		
		public function uninstall(){
		
			Symphony::Configuration()->remove('xmlimport_notifier');			
			Administration::instance()->saveConfig();
								
		}
		
		public function savePreferences($context){
		
		}
		
		public function appendPreferences($context){
			
			$fieldset = new XMLElement('fieldset');
			$fieldset->setAttribute('class', 'settings');
			$fieldset->appendChild(new XMLElement('legend', __('XMLimport Notifier')));
			$label = Widget::Label(__('Email Address to notify'));
			$label->appendChild(Widget::Input('settings[xmlimport_notifier][email]', General::Sanitize(Symphony::Configuration()->get('email', 'xmlimport_notifier'))));
			
			$fieldset->appendChild($label);
			
			$context['wrapper']->appendChild($fieldset);	
			
		}
	}