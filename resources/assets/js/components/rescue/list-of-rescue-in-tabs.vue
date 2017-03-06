<template>
    <div style="padding: 20px">Rescue: {{ rescues.length }}
        <table id="tbl-rescue" class="table table-hover table-condensed table-bordered">
                 <thead>
                     <tr>
                         <th>Rescue Team</th>
                         <th>Rescue Capability</th>
                         <th width="200" class="text-center">Hotline No.</th>
                         <th>Team Leader</th>
                         <th style="text-align: center">Manpower</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr v-for="rescue in rescues">
                         <td>{{ rescue.rescue_team }}</td>
                         <td>{{ rescue.rescue_capability }}</td>
                         <td class="text-center">{{ rescue.hotline_no }}</td>
                         <td>{{ rescue.team_leader }}</td>
                         <td style="text-align: right">{{ rescue.man_power }}</td>
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
                $('#tbl-rescue').dataTable();
            }, 3000);
        },
        props: {
            rescues: {
                type: Array
            }
        }
    }
</script>
