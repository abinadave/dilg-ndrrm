
<?php 
	$data = [];
	array_push($data, 
		array(
			'PROVINCE',
			'CITY/MUNICIPALITY',
			'FACILITY CATEGORY', 
			'FACILITY DESCRIPTION',
			'LOCATION',
			'TOTAL FACILITY',
			'PERSON RESPONSIBLE',
			'MOBILE NO',
			'LANDLINE NO'
			)
	);
	Excel::create('facilities', function($excel) use ($data, $facilities) {
	    $excel->sheet('region_eight_facilities', function($sheet) use ($data, $facilities) {
    		foreach ($facilities as $facility) {
				array_push($data, array(
					$facility->province->name,
					$facility->municipality->name,
					$facility->facility_category,
					$facility->facility_description,
					$facility->location,
					$facility->total_facility,
					$facility->person_responsible,
					$facility->mobile_no,
					$facility->landline_no
				));
			}
	        $sheet->fromArray($data, null, 'A1', false, false);
	    });
	})->download('csv');
?>
