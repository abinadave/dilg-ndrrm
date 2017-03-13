
<?php 
	$data = [];
	array_push($data, array('EVACUATION CENTER', 'LOCATION', 'FLOOR AREA','TOTAL_CAPACITY','MALE','FEMALE','POTABLE','NON_POTABLE'));
	Excel::create('evacuations', function($excel) use ($data, $evacuations) {
	    $excel->sheet('evacuation centers', function($sheet) use ($data, $evacuations) {
    		foreach ($evacuations as $evac) {
				array_push($data, array(
					$evac->evacuation_center, 
					$evac->location, 
					$evac->floor_area,
					$evac->total_capacity,
					$evac->male,
					$evac->female,
					$evac->potable,
					$evac->non_potable
				));
			}
	        $sheet->fromArray($data, null, 'A1', false, false);
	    });
	})->download('csv');
 ?>