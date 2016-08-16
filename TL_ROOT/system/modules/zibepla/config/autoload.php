<?php

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'AvailabilityCalendar' => 'system/modules/zibepla/AvailabilityCalendar.php',
	'ContentAvailability'  => 'system/modules/zibepla/ContentAvailability.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_availability'      => 'system/modules/zibepla/templates',
));
