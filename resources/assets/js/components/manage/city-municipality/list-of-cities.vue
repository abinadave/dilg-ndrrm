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
                    <td class="text-center">{{ countOfficers(city.id) }}</td>
                    <td class="text-center">{{ countRescue(city.id) }}</td>
                    <td class="text-center">0</td>
                    <td class="text-center">0</td>
                    <td class="text-center"><a @click="showTheLgus(city)" style="cursor: pointer; font-size: 15px"><i class="fa fa-folder" aria-hidden="true"></i></a></td>
        		</tr>
        	</tbody>
        </table>
        <modal-tabs></modal-tabs>
    </div>
</template>

<script>
	import _ from 'lodash'
    import dt from 'datatables.net'
    import CompCityTabs from '../../city_tabs.vue'
    export default {
        components: {
            'modal-tabs': CompCityTabs
        },
    	props: {
            officers: {
                type: Array
            },
            rescues: {
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
            }, 1000);
        },
        methods: {
            countOfficers(cityId){
                let self = this;
                return _.filter(self.officers, { municipality_id: cityId}).length;
            },
            countRescue(cityId){
                let self = this;
                return _.filter(self.rescues, { municipality_id: cityId}).length;

            },
            showTheLgus(city){
                let self = this;
                $('#modalCityTabs').modal();
            },
        	getProvinceName(province_id){
        		let self = this;
        		let rs = _.filter(self.provinces, {id: Number(province_id)});
        		return rs[0].name.toUpperCase();
        	}
        }
    }
</script>
