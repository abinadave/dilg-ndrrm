<template>
    <div>
      <div class="col-md-3" id="div-search">
            <input type="text" class="form-control" v-model="search" placeholder="Search">
      </div>
       <table class="table-officers table table-hover table-bordered table-condensed">
           <thead>
               <tr>
                   <th>Province</th>
                   <th>City/Municipality</th>
                   <th>DRRM Officer</th>
                   <th>Mobile No.</th>
                   <th>Landline No.</th>
                   <th>Email Address</th>
                   <th>Radio Frequency</th>
                   <th>Call Sign</th>
               </tr>
           </thead>
           <tbody>
              <tr v-for="officer in searchFilter">
                  <td>{{ officer.province }}</td>
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
<style type="text/css">
    .table-officers {
        font-size: 12px;
        margin-top: 20px;
    }
    #div-search {
        padding: 20px;
        margin-left: -10px;
    }
    #div-search input {
        border-radius: 30px;
    }
</style>
<script>
    import CompCreateOfficer from './create-officer.vue'
    export default {
        mounted() {
           this.fetch();
        },
        data(){
            return {
                officers: [],
                search: ''
            }
        },
        components: {
            'create-officer': CompCreateOfficer
        },
        methods: {
            fetch(){
                let self = this;
                axios.get('/officer/management').then(function (response) {
                    if (response.status === 200) {
                        let json = response.data;
                        self.officers = json.officers;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        computed: {
            searchFilter(){
                let self = this;
                let value = self.search.toLowerCase();
                return self.officers.filter(function(index) {
                    return index.province.toLowerCase().indexOf(value) !== -1 ||
                           index.city_municipality.toLowerCase().indexOf(value) !== -1 ||
                           index.drrm_officer.toLowerCase().indexOf(value) !== -1 ||
                           index.mobile_no.toLowerCase().indexOf(value) !== -1 || 
                           index.landline_no.toLowerCase().indexOf(value) !== -1 || 
                           index.emnail_address.toLowerCase().indexOf(value) !== -1;
                           index.radio_frequency.toLowerCase().indexOf(value) !== -1;
                           index.call_sign.toLowerCase().indexOf(value) !== -1;
                });
            }
        }
    }
</script>
