<template>
    <div style="padding: 23px; font-size: 12px">
        <table id="my-table" class="table table-bordered table-striped">
        	<thead>
        		<tr>
        			<th>City/Municipality</th>
        			<th>Province</th>
                    <th>Officers</th>
                    <th>Rescue Units</th>
                    <th>Evaciations</th>
                    <th>Facilities</th>
                    <th width="1"></th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr v-for="city in cityMunicipalities">
        			<td>{{ city.name.toUpperCase() }}</td>
        			<td>{{ getProvinceName(city.province_id) }}</td>
                    <td class="text-center">
                        <a href="" @click="showOfficers(city)">{{ countOfficers(city.id) }}</a>
                    </td>
                    <td class="text-center">
                        <a href="" @click="showRescueUnits(city)">{{ countRescue(city.id) }}</a>
                    </td>
                    <td class="text-center">
                        <a href="" @clikc="showEvacuations(city)">{{ countEvacuations(city.id) }}</a>
                    </td>
                    <td class="text-center">{{ countFacilities(city.id) }}</td>
                    <td class="text-center"><a @click="showTheLgus(city)" style="cursor: pointer; font-size: 15px"><i class="fa fa-folder" aria-hidden="true"></i></a></td>
        		</tr>
        	</tbody>
        </table>
    </div>
</template>

<script>
    import dt from 'datatables.net'

    export default {
        
    	props: {
            officers: {
                type: Array
            },
            rescues: {
                type: Array
            },
            evacuations: {
                type: Array
            },
            facilities: {
                type: Array
            },
    		cityMunicipalities: {
    			type: Array
    		},
    		provinces: {
    			type: Array
    		}
    	},
        mounted() {
            setTimeout(function(){
                $('#my-table').dataTable();
            }, 3000);
        },
        methods: {
            showEvacuations(city){
                let self = this;
                console.log(city)
            },
            showRescueUnits(city){
                let self = this;
                console.log(city);
            },
            showOfficers(){
                let self = this;
                console.log('good')
            },
            countOfficers(cityId){
                let self = this;
                return _.filter(self.officers, { municipality_id: cityId}).length;
            },
            countRescue(cityId){
                let self = this;
                return _.filter(self.rescues, { municipality_id: cityId}).length;
            },
            countEvacuations(cityId){
                let self = this;
                return _.filter(self.evacuations, { municipality_id: cityId}).length;
            },
            countFacilities(cityId){
                let self = this;
                return _.filter(self.facilities, { municipality_id: cityId}).length;
            },
            showTheLgus(city){
                let self = this;
                window.open('home#/Manage/City-Municipality/' + city.province_id);
            },
        	getProvinceName(province_id){
        		let self = this;
        		let rs = _.filter(self.provinces, {id: Number(province_id)});
        		return rs[0].name.toUpperCase();
        	}
        }
    }
</script>
