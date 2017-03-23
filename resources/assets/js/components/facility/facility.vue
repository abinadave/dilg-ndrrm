<template>
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Facilities</h3>
          </div>

          <div class="panel-body">
            <div class="col-md-2">
                <select v-model="selectedProvince" class="form-control ">
                    <option :value="0">All Province</option>
                    <option :value="province.id" v-for="province in provinces">
                        {{ province.name }}
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                 <select v-model="selectedCity" class="form-control ">
                    <option :value="0">All lgu</option>
                    <option :value="city.id" v-for="city in city_municipalities">
                        {{ city.name }}
                    </option>
                </select>
            </div>
            <input @keyup.enter="fetch"  type="text" v-model="search" class="form-control" style="border-radius: 25px; width: 350px; display: inline; margin-bottom: 8px" placeholder="Search rescue team">
            <button @click="fetch" class="btn btn-primary btn-sm" style="display: inline" :disabled="searching">Search</button>
            <a style="cursor:pointer; margin-top: -16px" class="pull-right"><i class="fa fa-print fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <a @click="downloadNow" style="margin-top: -16px; padding-right: 6px" href="/facility/download" class="pull-right">
              <i v-show="!whileExporting" class="fa fa-download fa-2x" aria-hidden="true"></i> 
              <i v-show="whileExporting" class="fa fa-spinner fa-pulse fa-2x fa-fw text-warning"></i>
            </a>
            <table class="table table-hover table-condensed table-bordered" style="font-size: 12px">
                 <thead>
                     <tr>
                         <th width="200" style="text-align:center">Province</th>
                         <th width="200" style="text-align:center">City/Municipality</th>
                         <th width="200" style="text-align:center">Facility Cateogory</th>
                         <th width="250" style="text-align:center">Facility Description</th>
                         <th>Location</th>
                         <th style="text-align:center">Total Facility</th>
                         <th style="text-align:center">Person Responsible</th>
                         <th style="text-align:center">Mobile No.</th>
                         <th style="text-align:center">Landline No.</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr v-for="facility in facilities">
                         <td style="text-align: center">{{ getProvinceName(facility) }}</td>
                         <td style="text-align: center">{{ getMunicipalityName(facility) }}</td>
                         <td style="text-align:center">{{ facility.facility_category }}</td>
                         <td style="text-align:center">{{ facility.facility_description }}</td>
                         <td>{{ facility.location }}</td>
                         <td style="text-align:center">{{ facility.total_facility }}</td>
                         <td style="text-align:center">{{ facility.person_responsible }}</td>
                         <td style="text-align:center">{{ facility.mobile_no }}</td>
                         <td style="text-align:center">{{ facility.landline_no }}</td>
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
                searching: false,
                provinces: [],
                city_municipalities: [],
                selectedProvince: 0,
                selectedCity: 0,
                whileExporting: false
            }
        },
        mounted() {
           console.log('Facility.vue is mounted');
           this.fetch();
           this.fetchCityMunicipalities();
        },
        components: {
          
        },
        methods: {
            downloadNow(){
                let alertify = require('alertify.js');
                alertify.log('Please wait, Your document is being downloaded!');
            },
            fetchLgus(){
                let self = this;
                self.$http.post('/municipality/filterby/province', {
                    province: self.selectedProvince
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.city_municipalities = json.city_municipalities;
                    }
                }, (resp) => {
                    if (resp.status === 422) {
                      console.log(resp)
                    }
                });
            },
            getProvinceName(facility){
                let province = _.values(facility.province);
                if (typeof province[1] === 'string') {
                    return province[1];
                }else {
                    return '';
                }
            },
            getMunicipalityName(facility){
                let municipality = _.values(facility.municipality);
                if (typeof municipality[2] === 'string') {
                    return municipality[2];
                }else {
                    return '';
                }
            },
            fetchCityMunicipalities(){
                let self = this;
                self.$http.get('/province/management').then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.provinces = json.provinces;
                        self.city_municipalities = json.city_municipalities;
                    }
                }, (resp) => {
                    if (resp.status === 422) {
                      console.log(resp)
                    }
                });
            },
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
                self.$http.post('/facility/fetch',{
                    search: self.search,
                    province: self.selectedProvince,
                    city: self.selectedCity
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.facilities = json;
                    }
                }, (resp) => {
                    if (resp.status === 422) {
                      console.log(resp)
                    }
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
        },
        watch: {
            'selectedProvince': function(newVal){
                this.fetch();
                this.fetchLgus();
            },
            'selectedCity': function(newVal){
                this.fetch();
            },
            'search': function(newVal){
                let self = this;
                clearTimeout(self.timer);
                self.timer = setTimeout(function(){
                    if (newVal === '') {
                        self.fetch();
                    }
                }, 1000);
            }
        }
    }
</script>
