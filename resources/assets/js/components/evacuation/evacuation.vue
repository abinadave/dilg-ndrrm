<template>
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Evacuation Centers {{ evacuations.length }}</h3>
          </div>
          <div class="panel-body">
             <input @keyup="changeinKeyword" @keyup.enter="searchKeyWord" type="text" v-model="search" class="form-control" style="border-radius: 25px; width: 350px; display: inline; margin-bottom: 8px" placeholder="Search rescue team">
             <button @click="searchKeyWord" class="btn btn-default" style="display: inline">Search</button>
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
            
          </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        data(){
            return {
                evacuations: [], search: ''
            }
        },
        mounted() {
           console.log('Evacuation.vue is mounted');
           this.fetch();
        },
        components: {
          
        },
        methods: {
            changeinKeyword(){
                let self = this;
                cleareee
            },
            searchKeyWord(){
                let self = this;
                axios.post('/evacuation/search', {
                    keyword: self.search
                })
                .then(function (response) {
                    if (response.status === 200) {
                        self.evacuations = response.data;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            fetch(){
                let self = this;
                axios.post('/evacuation/management', {
                    pagination: self.pagination

                }).then(function (response) {
                    if (response.status === 200) {
                        self.evacuations = response.data.evacuations;
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
                return self.evacuations.filter(function(index) {
                    return index.evacuation_center.toLowerCase().indexOf(value) !== -1;
                });
            }
        }
    }
</script>
