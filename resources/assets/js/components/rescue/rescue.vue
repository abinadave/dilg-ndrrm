<template>
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">All Rescue teams <span class="badge"></span>{{ rescues.length }}</h3>
          </div>
          <div class="panel-body">
             <select style="width: 15%; display: inline-block" class="form-control" v-model="selectedProvince">
                 <option :value="0">All Province</option>
                 <option :value="province.id" v-for="province in provinces"> 
                     {{ province.name }}
                 </option>
             </select>
             <select style="width: 15%; display: inline-block" class="form-control" v-model="selectedCity">
                 <option :value="0">All City/Municipalities</option>
                 <option :value="city.id" v-for="city in city_municipalities"> 
                     {{ city.name }}
                 </option>
             </select>
             <input @keyup.enter="searchNow" type="text" v-model="search" class="form-control" style="display: inline-block; border-radius: 25px; width: 350px; margin-bottom: 8px" placeholder="Search rescue team">
             <button class="btn btn-primary btn-sm" style="display: inline-block">Search</button>
             <table class="table table-hover table-condensed table-bordered" style="font-size: 12px">
                 <thead>
                     <tr>
                         <th width="200" class="text-center">Province</th>
                         <th width="200" class="text-center">City/Municipality</th>
                         <th>Rescue Team</th>
                         <th>Rescue Capability</th>
                         <th width="200" class="text-center">Hotline No.</th>
                         <th>Team Leader</th>
                         <th style="text-align: center">Manpower</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr v-for="rescue in rescues">
                         <td class="text-center">{{ getProvince(rescue) }}</td>
                         <td class="text-center">{{ getCity(rescue.municipality_id) }}</td>
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
                rescues: [], search: '',
                provinces: [], city_municipalities: [],
                skip: 50,
                take: 50,
                loadingMore: false,
                loadMoreHide: false,
                whileExporting: false,
                selectedProvince: 0,
                selectedCity: 0
            }
        },
        mounted() {
           console.log('Rescue.vue is mounted');
           this.fetch();
           this.fetchProvince();
        },
        components: {
           
        },
        methods: {
            getAllLgu(){
                let self = this;
                self.$http.post('/municipality/filterby/province', {
                    province: self.selectedProvince
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.city_municipalities = json.city_municipalities;
                    }
                }, (resp) => {
                    console.log(resp);
                })
            },
            searchNow(){
                let self = this;
                self.$http.post('/rescue/search', {
                    keyword: self.search,
                    province: self.selectedProvince,
                    city: self.selectedCity
                }).then((resp) => {
                    let json = resp.body;
                    if (json.length) {
                        self.rescues = json;
                    }
                }, (resp) => {
                    console.log(resp);
                })
            },
            fetchProvince(){
                let self = this;
                self.$http.get('/province/management').then((resp) => {
                    _.each(resp.body, function(value, key) {
                        self[key] = value;
                    });
                }, (resp) => {
                    console.log(resp);
                })
            },
            getProvince(rescue){
                let self = this;
                let rs = _.filter(self.provinces, { id: rescue.province_id });
                if (rs.length) {
                    return rs[0].name.toUpperCase();
                }
            },
            getCity(i){
                let self = this;
                let rs = _.filter(self.city_municipalities, { id: i });
                if (rs.length) {
                    return rs[0].name.toUpperCase();
                }
            },
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
            },
            filterDropdown(){
                let self = this;
                self.$http.post('/rescue/filterby/dropdown', {
                    province: self.selectedProvince,
                    city: self.selectedCity
                }).then((resp) => {
                    let json = resp.body;
                    self.rescues = json.rescues;
                }, (resp) => {
                    console.log(resp);
                });
            }
        },
        watch: {
            'search': function(newVal) {
                let self = this;
                clearTimeout(self.timer);
                self.timer = setTimeout(function(){
                    if (newVal == '') {
                        self.searchNow();
                        self.skip = 50;
                        self.take = 50;
                    }
                }, 700);
            },
            'selectedProvince': function(){
                let self = this;
                self.getAllLgu();
                self.filterDropdown();
            },
            'selectedCity': function(){
                let self = this;
                self.filterDropdown();
            }
        }
    }
</script>
