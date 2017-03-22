<template>
    <div>
      <div class="col-md-3" id="div-search">
            <input type="text" class="form-control" v-model="search" placeholder="Search">
      </div>
      <div class="col-md-2" style="padding: 20px">
        <select v-model="selectProvince" class="form-control ">
            <option :value="0">All Province</option>
            <option :value="province.id" v-for="province in provinces">
                {{ province.name }}
            </option>
        </select>
      </div>
      <div class="col-md-2" style="padding: 20px">
         <select v-model="selectCity" class="form-control ">
            <option :value="0">All lgu</option>
            <option :value="city.id" v-for="city in city_municipalities">
                {{ city.name }}
            </option>
        </select>
      </div>
      <a style="cursor:pointer; margin-top: -16px" class="pull-right"><i class="fa fa-print fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <a style="margin-top: -16px; padding-right: 6px" href="/officer/download" class="pull-right">
              <i v-show="!whileExporting" class="fa fa-download fa-2x" aria-hidden="true"></i> 
              <i v-show="whileExporting" class="fa fa-spinner fa-pulse fa-2x fa-fw text-warning"></i>
            </a>
       <table class="table-officers table table-hover table-bordered table-condensed">
           <thead>
               <tr>
                   <th class="text-center">Province</th>
                   <th class="text-center">City/Municipality</th>
                   <th>DRRM Officer</th>
                   <th>Email Address</th>
                   <th class="text-center">Mobile No.</th>
                   <th class="text-center">Landline No.</th>
                   <th class="text-center">Radio Frequency</th>
                   <th class="text-center">Call Sign</th>
                   <th width="1"></th>
                   <th width="1"></th>
               </tr>
           </thead>
           <tbody>
              <tr v-for="(officer, index) in searchFilter">
                  <td class="text-center">{{ getProvinceName(officer) }}</td>
                  <td class="text-center">{{ getMunicipalityName(officer) }}</td>
                  <td><b class="text-info">{{ officer.drrm_officer }}</b></td>
                  <td>{{ officer.emnail_address }}</td>
                  <td class="text-center">{{ officer.mobile_no }}</td>
                  <td class="text-center">{{ officer.landline_no }}</td>
                  <td class="text-center">{{ officer.radio_frequency }}</td>
                  <td class="text-center">{{ officer.call_sign }}</td>
                  <th><a style="cursor: pointer" @click="removeOfficer(officer, index)"><span class="glyphicon glyphicon-remove"></span></a></th>
                  <th><a style="cursor: pointer" @click="editOfficer(officer, index)"><span class="glyphicon glyphicon-pencil"></span></a>
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
    import alertify from 'alertify.js'

    export default {
        props: {
            officers: {
                type: Array
            },
            provinces: {
                type: Array
            },
            city_municipalities: {
                type: Array
            }
        },
        mounted() {
           // this.fetch();
        },
        data(){
            return {
                whileExporting: false,
                search: '',
                selectProvince: 0,
                selectCity: 0
            }
        },
        components: {
            'create-officer': CompCreateOfficer
        },
        methods: {
            searchSQL(){
                let self = this;
                self.$http.post('/officers/search', {
                    province: self.selectProvince,
                    city: self.selectCity,
                    search: self.search
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.$emit('populateofficer', json);
                    }
                }, (resp) => {
                    if (resp.status === 422) {
                      console.log(resp)
                    }
                });
            },
            fetchDropDownLgus(){
                let self = this;
                self.$http.post('/municipality/filterby/province',  {
                  province: self.selectProvince
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.$emit('populatecities', json.city_municipalities);
                    }
                }, (resp) => {
                    if (resp.status === 422) {
                      console.log(resp)
                    }
                });
            },
            getProvinceName(officer){
                let province = _.values(officer.province);
                if (typeof province[1] === 'string') {
                    return province[1];
                }else {
                    return '';
                }
            },
            getMunicipalityName(officer){
                let municipality = _.values(officer.municipality);
                if (typeof municipality[2] === 'string') {
                    return municipality[2];
                }else {
                    return '';
                }
            },
            editOfficer(officer){
                let self = this;
                $('#modalEditOfficer').modal('show');
                self.$emit('syncofficerupdate', officer);
            },
            removeOfficer(officer, index){
                let self = this;
                alertify.confirm("Would you like to delete <b class='text-primary'>" + officer.drrm_officer + "</b> from the officer list?, Are you sure?", function () {
                    self.confirmDelete(officer, index);
                }, function() {
                    // user clicked "cancel"
                });
            },
            confirmDelete(officer, index){
                let self = this;
                let resource = self.$resource('officer{/id}');
                resource.delete({
                    id: officer.id
                }).then((resp) => {
                    if (resp.status === 200) {
                      let json = resp.body;
                      if (json.deleted) {
                         self.$emit('deletedofficer', index);
                      }
                    }
                }, (resp) => {
                    console.log(resp);
                });
            },
        },
        computed: {
            searchFilter(){
                let self = this;
                let value = self.search.toLowerCase();
                let province = {}, city = {};
                return self.officers.filter(function(index) {
                    province = self.getProvinceName(index);
                    city = self.getMunicipalityName(index);
                    return province.toLowerCase().indexOf(value) !== -1 ||
                           city.toLowerCase().indexOf(value) !== -1 ||
                           index.drrm_officer.toLowerCase().indexOf(value) !== -1 ||
                           index.mobile_no.toLowerCase().indexOf(value) !== -1 || 
                           index.landline_no.toLowerCase().indexOf(value) !== -1 || 
                           index.emnail_address.toLowerCase().indexOf(value) !== -1;
                           index.radio_frequency.toLowerCase().indexOf(value) !== -1;
                           index.call_sign.toLowerCase().indexOf(value) !== -1;
                });
            }
        },
        watch: {
            'selectProvince': function(newVal){
                let self = this;
                self.fetchDropDownLgus(newVal);
                self.searchSQL();
            },
            'selectCity': function(newVal){
                this.searchSQL();
            }
        }
    }
</script>
