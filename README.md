xmlimport_notifier
==================

Notify an Email address when Success or failure of Scheduled XMLImports in Symphony is triggered.

Requires 2 additional delegates be added to the XMLImporter extension:

My Branch has placed them in already for proof of concept: https://github.com/andrewminton/xmlimporter/tree/emailnotify

XMLImporterImportPostRun and XMLImporterImportPostRunError to be able to listed to these delegates and trigger an email condition of certain criteria is set in the config..

This is an experimental extension and is in early stages of creation.
