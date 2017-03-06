<template>
    <div style="padding: 20px">Officers: {{ officers.length }}
        <table id="tbl-officers" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th>Municipal/City</th>
                    <th>Officer</th>
                    <th>Mobile No.</th>
                    <th>Landline No.</th>
                    <th>Email Address</th>
                    <th>Radio Frequency</th>
                    <th>Call Sign</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="officer in officers">
                    <td>{{ officer.city_municipality }}</td>
                    <td>{{ officer.drrm_officer }}</td>
                    <td>{{ officer.mobile_no }}</td>
                    <td>{{ officer.landline_no }}</td>
                    <td>{{ officer.emnail_address }}</td>
                    <td>{{ officer.radio_frequency }}</td>
                    <td>{{ officer.call_sign }}</td>
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
                $('#tbl-officers').dataTable();
            }, 3000);
        },
        props: {
            officers: {
                type: Array
            }
        }
    }
</script>
