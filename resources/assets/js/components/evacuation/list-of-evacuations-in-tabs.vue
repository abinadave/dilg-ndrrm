<template>
    <div style="padding: 20px">Evacuations: {{ evacuations.length }}
        <table id="tbl-evacuations" class="table table-hover table-condensed table-bordered">
                 <thead>
                     <tr>
                         <th>Evacuation Center</th>
                         <th>Location</th>
                         <th class="right">Floor Area</th>
                         <th class="right">Total Capacity</th>
                         <th class="right">Male</th>
                         <th class="right">Female</th>
                         <th>Potable</th>
                         <th>Non Potable</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr v-for="evacuation in evacuations">
                         <td>{{ evacuation.evacuation_center }}</td>
                         <td>{{ evacuation.location }}</td>
                         <td class="right">{{ evacuation.floor_area }}</td>
                         <td class="right">{{ evacuation.total_capacity }}</td>
                         <td class="right">{{ evacuation.male }}</td>
                         <td class="right">{{ evacuation.female }}</td>
                         <td>{{ evacuation.potable }}</td>
                         <td>{{ evacuation.non_potable }}</td>
                     </tr>
                 </tbody>
             </table>
    </div>
</template>

<script>
    import dt from 'datatables.net'
    export default {
        mounted() {
            console.log('Component mounted. successfully');
            setTimeout(function(){
                $('#tbl-evacuations').dataTable();
            }, 3000);
        },
        props: {
            evacuations: {
                type: Array
            }
        }
    }
</script>
