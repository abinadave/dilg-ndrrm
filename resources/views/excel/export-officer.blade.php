
<?php 
	$data = [];
	array_push($data, 
		array(
			'PROVINCE',
			'CITY/MUNICIPALITY',
			'DRRM OFFICER', 
			'MOBILE NO',
			'LANDLINE NO',
			'EMAIL ADDRESS',
			'RADIO FREQUENCY',
			'CALL SIGN'
			)
	);
	Excel::create('officer', function($excel) use ($data, $officers) {
	    $excel->sheet('region_eight_officers', function($sheet) use ($data, $officers) {
    		foreach ($officers as $officer) {
				array_push($data, array(
					$officer->province,
					$officer->municipality->name,
					$officer->drrm_officer,
					$officer->mobile_no,
					$officer->landline_no,
					$officer->emnail_address,
					$officer->radio_frequency,
					$officer->call_sign
				));
			}
	        $sheet->fromArray($data, null, 'A1', false, false);
	    });
	})->download('csv');
?>
