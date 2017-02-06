<template>
    <div style="padding: 23px; font-size: 12px">
        <table class="table table-bordered table-striped">
        	<thead>
        		<tr>
        			<th>City/Municipality</th>
        			<th>Province</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr v-for="city in cityMunicipalities">
        			<td>{{ city.name.toUpperCase() }}</td>
        			<td>{{ getProvinceName(city.province_id) }}</td>
        		</tr>
        	</tbody>
        </table>
    </div>
</template>

<script>
	import _ from 'lodash'
    export default {
    	props: {
    		cityMunicipalities: {
    			type: Array
    		},
    		provinces: {
    			type: Array
    		}
    	},
        mounted() {
            console.log('Component mounted. successfully')
        },
        methods: {
        	getProvinceName(province_id){
        		let self = this;
        		let rs = _.filter(self.provinces, {id: Number(province_id)});
        		return rs[0].name.toUpperCase();
        	}
        }
    }
</script>
