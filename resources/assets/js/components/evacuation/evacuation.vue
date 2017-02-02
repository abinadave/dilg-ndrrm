<template>
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Evacuation Centers {{ evacuations.length }}</h3>
          </div>
          <div class="panel-body">
             <input type="text" v-model="search" class="form-control" style="border-radius: 25px; width: 350px; margin-bottom: 8px" placeholder="Search rescue team">
             <table class="table table-hover table-condensed table-bordered">
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
             <pagination-buttons :pagination="pagination"></pagination-buttons>
          </div>
        </div>
    </div>
</template>
<style type="text/css">
    .right {
        text-align: right;
    }
</style>
<script>
    import CompPaginationButton from './evacuation-buttons.vue'
    export default {
        data(){
            return {
                evacuations: [], search: '',
                pagination: {
                    to: 50,
                    per_page: 15,
                    last_page: 0,
                    total: 0,
                }
            }
        },
        mounted() {
           console.log('Evacuation.vue is mounted');
           this.fetch();
        },
        components: {
           'pagination-buttons': CompPaginationButton
        },
        methods: {
            fetch(){
                let self = this;
                axios.post('/evacuation/management', {
                    pagination: self.pagination

                }).then(function (response) {
                    if (response.status === 200) {
                        let json = response.data;
                        self.evacuations = json.data;
                        self.pagination.total = json.total;
                        self.pagination.to = json.to;
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
                
            }
        }
    }
</script>
