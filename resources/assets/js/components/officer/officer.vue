<template>
    <div class="col-md-12">
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Officer List</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Create Officer</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Trashed Officers</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <officer-list
                 @populatecities="refreshCities"
                 @populateofficer="refreshData"
                 @syncofficerupdate="syncOfficerChild"
                 @deletedofficer="removeOfficerChild"
                 :provinces="provinces"
                 :city_municipalities="city_municipalities"
                 :officers="officers"
                 ></officer-list>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
                <create-officer @addedofficer="newChildOfficer"></create-officer>
            </div>
            <div role="tabpanel" class="tab-pane" id="messages">...</div>
            <div role="tabpanel" class="tab-pane" id="settings">...</div>
          </div>

        </div>
        <modal-update-officer :officer="childOfficer"></modal-update-officer>
    </div>
</template>

<script>
    import CompCreateOfficer from './create-officer.vue'
    import CompOfficerList   from './officer-list.vue'
    import CompModalEditOfficer from './edit_officer.vue'
    import alertify from 'alertify.js'
    export default {
        mounted() {
           this.fetch();
           this.fetchProvinces();
        },
        data(){
            return {
                officers: [],
                childOfficer: {},
                provinces: [],
                city_municipalities: []
            }
        },
        components: {
            'create-officer': CompCreateOfficer,
            'officer-list': CompOfficerList,
            'modal-update-officer': CompModalEditOfficer
        },
        methods: {
            refreshCities(respCities){
                this.city_municipalities = respCities;
            },
            refreshData(respOfficers){
                let self = this;
                self.officers = respOfficers;
            },
            syncOfficerChild(officer){
                let self = this;
                self.childOfficer = officer;
            },
            removeOfficerChild(index){
                let self = this;
                alertify.success("Successfully deleted");
                self.officers.splice(index, 1);
            },
            newChildOfficer(json){
                let self = this;
                self.officers.unshift(json);
            },
            fetch(){
                let self = this;
                axios.get('/officer/management').then(function (response) {
                    if (response.status === 200) {
                        let json = response.data;
                        self.officers = response.data;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            fetchProvinces(){
                let self = this;
                self.$http.get('/province/management').then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.provinces = json.provinces;
                        self.city_municipalities = json.city_municipalities;
                    }
                }, (resp) => {
                    console.log(resp);
                })
            }
        }
    }
</script>
