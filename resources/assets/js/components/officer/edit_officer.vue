<template>
  <!-- Modal -->
  <div class="modal fade" id="modalEditOfficer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Update officer {{ officer.drrm_officer }}</h4>
        </div>
        <div class="modal-body">
             <div class="panel-body">
                
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.drrm_officer }">
                      <label class="control-label" for="inputWarning1">RDRRM Officer</label>
                      <input v-model="officer.drrm_officer" type="text" class="form-control" id="inputWarning1">
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.province }">
                      <label class="control-label" for="inputWarning1">Province</label>
                      <select class="form-control" v-model="officer.province_id">
                          <option :value="province.id" v-for="province in provinces">
                              {{ province.name }}
                          </option>
                      </select>
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.city_municipality }">
                      <label class="control-label" for="inputWarning1">City/Municipality</label>
                      <select v-model="officer.municipality_id" class="form-control">
                          <option :value="city.id" v-for="city in city_municipalities">
                              {{ city.name }}
                          </option>
                      </select>
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.mobile_no }">
                      <label class="control-label" for="inputWarning1">Mobile No.</label>
                      <input v-model="officer.mobile_no" type="text" class="form-control" id="inputWarning1">
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.landline_no }">
                      <label class="control-label" for="inputWarning1">Landline No.</label>
                      <input v-model="officer.landline_no" type="text" class="form-control" id="inputWarning1">
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.email_address }">
                      <label class="control-label" for="inputWarning1">Email Address</label>
                      <input v-model="officer.emnail_address" type="email" class="form-control" id="inputWarning1">
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.radio_frequency }">
                      <label class="control-label" for="inputWarning1">Radio Frequency</label>
                      <input v-model="officer.radio_frequency" type="text" class="form-control" id="inputWarning1">
                    </div>
                    <div :class="{'form-group col-md-5': true, 'has-error': errors.call_sign }">
                      <label class="control-label" for="inputWarning1">Call sign</label>
                      <input v-model="officer.call_sign" type="text" class="form-control" id="inputWarning1">
                    </div>
                   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button :disabled="whileUpdating" @click="updateOfficer" type="submit" class="btn btn-primary">
          <span v-if="whileUpdating">Please Wait... <i class="fa fa-spinner fa-pulse fa-fw"></i>
            <span class="sr-only">Loading...</span>
          </span>
          <span v-else>Save changes</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

    export default {
        props: {
            officer: {
                type: Object
            }
        },
        mounted() {
           this.fetch();
        },
        data(){
            return {
                provinces: [],
                city_municipalities: [],
                drrmOfficer: '',
                province: '',
                cityMunicipality: '',
                mobileNo: '',
                landlineNo: '',
                email: '',
                radioFreq: '',
                callSign: '',
                errors: {
                    drrm_officer: false,
                    province: false,
                    city_municipality: false,
                    mobile_no: false,
                    email_address: false,
                    landline_no: false,
                    mobile_no: false,
                    radio_frequency: false,
                    call_sign: false
                },
                whileUpdating: false
            }
        },
     
        methods: {
            updateOfficer(){
                let self = this;
                self.whileUpdating = true;
                self.$http.put('/officer', self.officer).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        if (json.updated) {
                            let alertify = require('alertify.js');
                            alertify.success('Officer ['+ self.officer.drrm_officer+ '] successfully updated.');
                            setTimeout(function(){
                              self.whileUpdating = false;
                              $('#modalEditOfficer').modal('hide');
                            }, 700);
                        }
                    }
                }, (resp) => {
                    self.whileUpdating = false;
                    if (resp.status === 422) {
                      console.log(resp)
                    }
                });
            },
            fetch(){
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
            }
        },
        watch: {
            'form.province_id': function(){
                console.log('changed')
            }
        }
    }
</script>
