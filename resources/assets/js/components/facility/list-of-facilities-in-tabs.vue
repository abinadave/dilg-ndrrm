<template>
    <div style="padding: 20px; font-size: 12px">Facilities: {{ facilities.length }}
        <table id="tbl-facilities" class="table table-hover table-condensed table-bordered">
             <thead>
                 <tr>
                     <th>Facility Cateogory</th>
                     <th>Facility Description</th>
                     <th>Location</th>
                     <th>Total Facility</th>
                     <th>Person Responsible</th>
                     <th>Mobile No.</th>
                     <th>Landline No.</th>
                 </tr>
             </thead>
             <tbody>
                 <tr v-for="facility in facilities">
                     <td>{{ facility.facility_category }}</td>
                     <td>{{ facility.facility_description }}</td>
                     <td>{{ facility.location }}</td>
                     <td>{{ facility.total_facility }}</td>
                     <td>{{ facility.person_responsible }}</td>
                     <td>{{ facility.mobile_no }}</td>
                     <td>{{ facility.landline_no }}</td>
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
                $('#tbl-facilities').dataTable();
            }, 3000);
        },
        props: {
            facilities: {
                type: Array
            }
        }
    }
</script>
