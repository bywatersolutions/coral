<?php
/**
 * This module is required because it requires installation of chosen modules
 * It needs modules_to_use to find the chosen modules
 * It sets up those chosen modules as its own dependencies
 */

function register_modules_to_use_helper_provider()
{
	$PARENT_MODULE = "modules_to_use";
	$dynamic_dependencies = [ $PARENT_MODULE, "meets_system_requirements" ];

	$MODULE_VARS = [
		"uid" => "modules_to_use_helper",
		"translatable_title" => _("Modules to Use Helper"),
		"hide_from_completion_list" => true,
	];

	if (isset($_SESSION[$PARENT_MODULE]))
	{
		foreach ($_SESSION[$PARENT_MODULE]["useModule"] as $key => $val)
		{
			if ($val)
			{
				$dynamic_dependencies[] = $key;
			}
		}
	}

	return array_merge( $MODULE_VARS,[
		"bundle" => function($version = 0) use ($MODULE_VARS, $dynamic_dependencies){
			return [
				"dependencies_array" => $dynamic_dependencies,
				"function" => function($shared_module_info) use ($MODULE_VARS) {
					$return = new stdClass();
					$return->success = true;
					return $return;
				}
			];
		}
	]);
}
