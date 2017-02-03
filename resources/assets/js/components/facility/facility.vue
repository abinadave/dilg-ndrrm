<template>
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Facilities {{ facilities.length }}</h3>
          </div>
          <div class="panel-body">
             <input @keyup="changeinKeyword" @keyup.enter="searchKeyword"  type="text" v-model="search" class="form-control" style="border-radius: 25px; width: 350px; display: inline; margin-bottom: 8px" placeholder="Search rescue team">
             <button @click="searchKeyword" class="btn btn-primary btn-sm" style="display: inline" :disabled="searching">Search</button>
             <table class="table table-hover table-condensed table-bordered">
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
        </div>
    </div>
</template>

<script>
    
    export default {
        data(){
            return {
                facilities: [], search: '',
                searching: false
            }
        },
        mounted() {
           console.log('Facility.vue is mounted');
           this.fetch();
        },
        components: {
          
        },
        methods: {
            changeinKeyword(){
                let self = this;
                clearTimeout(self.timer);
                self.timer = setTimeout(function(){
                    if (self.search == '') {
                        self.fetch();
                    }
                }, 1100);
            },
            searchKeyword(){
                let self = this;
                self.searching = true;
                axios.post('/facilities/search', {
                    keyword: self.search
                })
                .then(function (response) {
                    if (response.status === 200) {
                        self.searching = false;
                        self.facilities = response.data;
                    }
                })
                .catch(function (error) {
                    self.searching = false;
                    console.log(error);
                });
            },
            fetch(){
                let self = this;
                axios.post('/facility/management', {
                    pagination: self.pagination

                }).then(function (response) {
                    if (response.status === 200) {
                        self.facilities = response.data.facilities;
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
                return self.facilities.filter(function(index) {
                    return index.evacuation_center.toLowerCase().indexOf(value) !== -1;
                });
            }
        }
    }
</script>
