<template>
    <div>
      <div class="col-md-3" id="div-search">
            <input type="text" class="form-control" v-model="search" placeholder="Search">
      </div>
      <div class="col-md-2" style="padding: 20px">
        <select v-model="selectProvince" class="form-control ">
            <option :value="0">All</option>
            <option :value="province.id" v-for="province in provinces">
                {{ province.name }}
            </option>
        </select>
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
                   <th width="1"></th>
                   <th width="1"></th>
               </tr>
           </thead>
           <tbody>
              <tr v-for="(officer, index) in searchFilter">
                  <td>{{ officer.province }}</td>
                  <td>{{ officer.city_municipality }}</td>
                  <td>{{ officer.drrm_officer }}</td>
                  <td>{{ officer.mobile_no }}</td>
                  <td>{{ officer.landline_no }}</td>
                  <td>{{ officer.emnail_address }}</td>
                  <td>{{ officer.radio_frequency }}</td>
                  <td>{{ officer.call_sign }}</td>
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
            }
        },
        mounted() {
           // this.fetch();
        },
        data(){
            return {
                search: '',
                selectProvince: 0
            }
        },
        components: {
            'create-officer': CompCreateOfficer
        },
        methods: {
            editOfficer(officer){
                let self = this;
                $('#modalEditOfficer').modal('show');
                self.$emit('syncofficerupdate', officer);
                $.each(officer, function(index, val) {
                      console.log(index + ' : ' +val);
                });
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
        },
        watch: {
            'selectProvince': function(newVal){
                let self = this;
                let resource = self.$resource('/officers/filter/province{/id}');
                resource.get({
                    id: newVal
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        if (json.officers.length) {
                            console.log(json)
                            self.$emit('populateofficer', json);
                        }else {
                            let rs = _.filter(self.provinces, {id: newVal});
                            let province = (rs.length > 0) ? rs[0].name : '-';
                            alertify.alert('There was no officer found in, <b class="text-primary">' +province+'</b>');
                        }
                    }
                }, (resp) => {
                    console.log(resp);
                })
            }
        }
    }
</script>
