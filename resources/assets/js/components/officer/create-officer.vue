<template>
    <div>
        <div class="col-md-5 panel-officer">
        
            <div class="panel panel-primary">
              <!-- Default panel contents -->
              <div class="panel-heading">Officer</div>
                <div class="panel-body">
                     <form @submit.prevent="submitOfficer">
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.drrm_officer }">
                          <label class="control-label" for="inputWarning1">RDRRM Officer</label>
                          <input v-model="drrmOfficer" type="text" class="form-control" id="inputWarning1">
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.province }">
                          <label class="control-label" for="inputWarning1">Province</label>
                          <select v-model="province" class="form-control">
                              <option :value="province.id" v-for="province in provinces">
                                  {{ province.name }}
                              </option>
                          </select>
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.city_municipality }">
                          <label class="control-label" for="inputWarning1">City/Municipality</label>
                          <select v-model="cityMunicipality" class="form-control">
                              <option :value="city.id" v-for="city in cities">
                                  {{ city.name }}
                              </option>
                          </select>
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.mobile_no }">
                          <label class="control-label" for="inputWarning1">Mobile No.</label>
                          <input v-model="mobileNo" type="text" class="form-control" id="inputWarning1">
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.landline_no }">
                          <label class="control-label" for="inputWarning1">Landline No.</label>
                          <input v-model="landlineNo" type="text" class="form-control" id="inputWarning1">
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.email_address }">
                          <label class="control-label" for="inputWarning1">Email Address</label>
                          <input v-model="email" type="email" class="form-control" id="inputWarning1">
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.radio_frequency }">
                          <label class="control-label" for="inputWarning1">Radio Frequency</label>
                          <input v-model="radioFreq" type="text" class="form-control" id="inputWarning1">
                        </div>
                        <div :class="{'form-group col-md-5': true, 'has-error': errors.call_sign }">
                          <label class="control-label" for="inputWarning1">Call sign</label>
                          <input v-model="callSign" type="text" class="form-control" id="inputWarning1">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-block btn-success">Add Officer</button>
                        </div>
                    </form>
                </div>
              <!-- Table -->
              <table class="table">
                ...
              </table>
            </div>
        </div>
        <!-- <create-province></create-province> -->
    </div>
</template>
<style type="text/css">
  .panel-officer {
     margin-top: 10px;
  }
</style>
<script>
    import CompCreateProvince from '../province/create-province.vue'
    // import toastr from 'toastr'
    import alertify from 'alertify.js'
    export default {
        mounted() {
            this.fetchProvince();
        },
        components: {
          'create-province': CompCreateProvince
        },
        data(){
            return {
                provinces: [],
                cities: [],
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
                }
            }
        },
        methods: {
            clearForm(){
                let self = this;
                self.province = '';
                self.drrmOfficer = '';
                self.cityMunicipality = '';
                self.mobileNo = '';
                self.landlineNo = '';
                self.email = '';
                self.radioFreq = '';
                self.callSign = '';
            },
            submitOfficer(){
                let self = this;
                let form = {
                    drrm_officer: self.drrmOfficer,
                    province: self.province,
                    city_municipality: self.cityMunicipality,
                    mobile_no: self.mobileNo,
                    landline_no: self.landlineNo,
                    email_address: self.email,
                    radio_frequency: self.radioFreq,
                    call_sign: self.callSign
                };
                console.log(form)
                self.$http.post('/officer', form).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        if (json.id) {
                            self.$emit('addedofficer', json);
                            alertify.alert('New RDRRM Officer was Added.');
                            self.clearForm();
                        }
                    }
                }, (resp) => {
                    if (resp.status === 422) {
                        let json = resp.body;
                        $.each(self.errors, function(index, val) {
                            self.errors[index] = false;
                        });
                        $.each(json, function(index, val) {
                            self.errors[index] = true;
                        });
                    }
                });
            },
            fetchProvince(){
                let self = this;
                self.$http.get('/province/management').then((resp) => {
                    if (resp.status == 200) {
                        let json = resp.body;
                        self.provinces = json.provinces;
                        self.cities = json.city_municipalities;
                    }
                }, (resp) => {
                    console.log(resp);
                })
            }
        }
    }
</script>
