<template>
    <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">All Rescue teams <span class="badge"></span>{{ rescues.length }}</h3>
          </div>
          <div class="panel-body">
             <input type="text" v-model="search" class="form-control" style="border-radius: 25px; width: 350px; margin-bottom: 8px" placeholder="Search rescue team">
             <table class="table table-hover table-condensed table-bordered">
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
                     <tr v-for="rescue in filterRescueTeam">
                         <td>{{ rescue.rescue_team }}</td>
                         <td>{{ rescue.rescue_capability }}</td>
                         <td class="text-center">{{ rescue.hotline_no }}</td>
                         <td>{{ rescue.team_leader }}</td>
                         <td style="text-align: right">{{ rescue.man_power }}</td>
                     </tr>
                 </tbody>
             </table>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                rescues: [], search: ''
            }
        },
        mounted() {
           console.log('Rescue.vue is mounted');
           this.fetch();
        },
        components: {
           
        },
        methods: {
            fetch(){
                let self = this;
                axios.get('/rescue/management').then(function (response) {
                    if (response.status === 200) {
                        let data = response.data;
                        self.rescues = data.rescues;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        computed: {
            filterRescueTeam(){
                let self = this;
                let value = self.search.toLowerCase();
                return self.rescues.filter(function(index) {
                    return index.rescue_team.toLowerCase().indexOf(value) !== -1 ||
                           index.rescue_capability.toLowerCase().indexOf(value) !== -1 ||
                           index.hotline_no.toLowerCase().indexOf(value) !== -1 ||
                           index.team_leader.toLowerCase().indexOf(value) !== -1;
                });
            }
        }
    }
</script>
