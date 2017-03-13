<template>
    
    <div class="col-md-12">
        <div v-show="onTablePrint">Evacuation Centers</div>
        <div id="paste-here"></div>
        <div class="panel panel-default hide-on-print">
          <div class="panel-heading">
            <h3 class="panel-title">Evacuation Centers</h3>
            <a style="cursor:pointer; margin-top: -16px" @click="printTbl" class="pull-right"><i class="fa fa-print fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <a @click="exportTbl" style="margin-top: -16px; padding-right: 6px" href="/evacuations/download" class="pull-right">
              <i v-show="!whileExporting" class="fa fa-download fa-2x" aria-hidden="true"></i> 
              <i v-show="whileExporting" class="fa fa-spinner fa-pulse fa-2x fa-fw text-warning"></i>
            </a>
          </div>
          <div class="panel-body">
             <input @keyup="changeinKeyword" @keyup.enter="searchKeyWord" type="text" v-model="search" class="form-control hide-on-print" style="border-radius: 25px; width: 350px; display: inline; margin-bottom: 8px" placeholder="Search rescue team">
             <button @click="searchKeyWord" class="btn btn-primary btn-sm hide-on-print" style="display: inline" :disabled="searching">Search</button>
             <div class="col-md-2 hide-on-print">
             <select class="pull-right form-control" v-model="selectedProvince">
                 <option :value="0">All Province</option>
                 <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
             </select>
             </div>
             <div class="col-md-2 hide-on-print">
             <select class="pull-right form-control" v-model="selectedCity">
                 <option :value="0">All Municipality</option>
                 <option v-for="city in city_municipalities" :value="city.id">{{ city.name }}</option>
             </select>
             </div>
             <br>
             <table id="tbl-evacuations" class="table table-hover table-condensed table-striped" style="font-size: 12px">
                 <thead class="text-primary">
                     <tr>
                         <th style="text-align: center" width="200">Province</th>
                         <th style="text-align: center">City/Municipality</th>
                         <th>Evacuation Center</th>
                         <th style="text-align: center">Location</th>
                         <th style="text-align: center">Floor Area</th>
                         <th style="text-align: center">Total Capacity</th>
                         <th style="text-align: center">Male</th>
                         <th style="text-align: center">Female</th>
                         <th style="text-align: center">Potable</th>
                         <th style="text-align: center">Non Potable</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr v-for="evacuation in evacuations">
                         <td style="text-align: center">{{ getProvince(evacuation) }}</td>
                         <td style="text-align: center">{{ getCity(evacuation) }}</td>
                         <td>{{ evacuation.evacuation_center }}</td>
                         <td style="text-align: center">{{ evacuation.location }}</td>
                         <td style="text-align: center">{{ evacuation.floor_area }}</td>
                         <td style="text-align: center">{{ evacuation.total_capacity }}</td>
                         <td style="text-align: center">{{ evacuation.male }}</td>
                         <td style="text-align: center">{{ evacuation.female }}</td>
                         <td style="text-align: center">{{ evacuation.potable }}</td>
                         <td style="text-align: center">{{ evacuation.non_potable }}</td>
                     </tr>
                 </tbody>
                 
             </table>
             <div v-show="!loadMoreHide" class="text-center"><button :disabled="loadingMore" class="btn btn-xs btn-default" @click="loadMore">Load more <i class="fa fa-refresh" aria-hidden="true"></i></button></div>
            
          </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        data(){
            return {
                onTablePrint: false,
                evacuations: [], search: '',
                searching: false,
                provinces: [],
                city_municipalities: [],
                selectedProvince: 0,
                selectedCity: 0,
                skip: 100,
                take: 100,
                loadingMore: false,
                loadMoreHide: false,
                whileExporting: false
            }
        },
        watch: {
            'selectedProvince': function(newVal){
                this.fetch();
                this.getLgus();
            },
            'selectedCity': function(newVal){
                this.filterProvinceCity();
            }
        },
        mounted() {
           console.log('Evacuation.vue is mounted');
           this.fetch();
           this.fetchProvinces();
        },
        components: {
          
        },
        methods: {
            exportTbl(){
                let self = this;
                self.whileExporting = true;
                setTimeout(function(){
                    self.whileExporting = false;
                }, 1500);
            },
            searchFrontEnd(){
                let self = this;
                let array = self.evacuations;
                array.filter(function(index){
                    console.log(index)
                });
            },
            loadMore(){
                let self = this;
                self.loadingMore = true;
                setTimeout(function(){
                    self.$http.post('/evacuation/skip/take', {
                        skip: self.skip,
                        take: self.take
                    }).then((resp) => {
                        if (resp.status === 200) {
                            let json = resp.body;
                            self.skip += 100;
                            self.loadingMore = false;
                            for (var i = json.length - 1; i >= 0; i--) {
                                self.evacuations.push(json[i]);
                            }
                        }
                    }, (resp) => {
                        if (resp.status === 422) {
                          console.log(resp)
                        }
                    });
                }, 500);
                
            },
            printTbl(){
                let self = this;
                let hideElem = '.hide-on-print';
                let table = $('#tbl-evacuations').clone();
                $('.hide-on-print').hide();
                $('#paste-here').html(table);
                $('#paste-here table').css({
                    'font-size': '10px',
                    'padding': '0px'
                });
                self.onTablePrint = true;
                setTimeout(function(){
                    window.print();
                    setTimeout(function(){
                        $(hideElem).show();
                        $('#paste-here').empty();
                        self.onTablePrint = false;
                    }, 1000);
                }, 2000);
            },
            getProvince(evacuation){
                let self = this;
                let rs = _.filter(self.provinces, {id: evacuation.province_id});
                if (rs.length) {
                    return rs[0].name.toUpperCase();
                }
            },
            getCity(evacuation){
                let self = this;
                let rs = _.filter(self.city_municipalities, {id: evacuation.municipality_id});
                if (rs.length) {
                    return rs[0].name.toUpperCase();
                }
            },
            getLgus(i){
                let self = this;
                self.$http.post('/municipality/filterby/province', {
                    province: self.selectedProvince,
                    city: self.selectedCity
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
            filterProvinceCity(){
                let self = this;
                let obj = {
                    province: self.selectedProvince,
                    city: self.selectedCity
                };
                let resource = self.$resource('evacuations/filter{/pid}{/cid}');
                resource.get({
                    pid: self.selectedProvince,
                    cid: self.selectedCity
                }).then(resp => {
                if (resp.status === 200) {
                    let json = resp.body;
                    // console.log(json)
                    self.evacuations = json.evacuations;
                }
                }, resp => {
                    console.log(resp);
                });
            },
            fetchProvinces(){
                let self = this;
                self.$http.get('/province/management').then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.provinces = json.provinces;
                        self.city_municipalities = json.city_municipalities;
                        // console.log(json)
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
                        self.searchKeyWord();
                    }
                    
                }, 500);
            },
            searchUsingJs(){
                let self = this;
                console.log('')
            },
            searchKeyWord(){
                let self = this;
                self.searching = true;
                
                axios.post('/evacuation/search', {
                    keyword: self.search,
                    province: self.selectedProvince,
                    city: self.selectedCity
                })
                .then(function (response) {
                    if (response.status === 200) {
                        self.searching = false;
                        self.evacuations = response.data;
                        self.loadMoreHide = true;
                    }
                })
                .catch(function (error) {
                    self.searching = false;

                });
                
            },
            fetch(){
                let self = this;
                axios.post('/evacuation/management', {
                    pagination: self.pagination

                }).then(function (response) {
                    if (response.status === 200) {
                        self.evacuations = response.data.evacuations;
                        self.loadMoreHide = false;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    self.loadMoreHide = false;
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
