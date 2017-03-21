
<?php 
	$data = [];
	array_push($data, 
		array(
			'PROVINCE',
			'CITY/MUNICIPALITY',
			'RESCUE_TEAM',
			'RESCUE CAPABILITY', 
			'HOTLINE NO',
			'TEAM LEADER',
			'MAN POWER'
			)
	);
	Excel::create('rescue', function($excel) use ($data, $rescues) {
	    $excel->sheet('rescue-units', function($sheet) use ($data, $rescues) {
    		foreach ($rescues as $rescue) {
				array_push($data, array(
					$rescue->province->name,
					$rescue->municipality->name,
					$rescue->rescue_team, 
					$rescue->rescue_capability,
					$rescue->hotline_no,
					$rescue->mon_power
				));
			}
	        $sheet->fromArray($data, null, 'A1', false, false);
	    });
	})->download('csv');
?>
