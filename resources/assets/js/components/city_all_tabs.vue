<template>

        <div class="col-md-12">
            <h3 class="page-header">
              <span>Province: </span>
              <span class="text-primary">
                {{ province.name.toUpperCase() }}
              </span>
            </h3>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Officers</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Rescue Units</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Evacuations</a></li>
              <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Facilities</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
                  <officers-list :officers="officers"></officers-list>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile">
                  <rescue-list :rescues="rescues"></rescue-list>
              </div>
              <div role="tabpanel" class="tab-pane" id="messages">
                  <evacuation-list :evacuations="evacuations"></evacuation-list>
                  <!-- <evacuation-list :evacuations="evacuations"></evacuation-list> -->
              </div>
              <div role="tabpanel" class="tab-pane" id="settings">
                <facility-list  :facilities="facilities"></facility-list>
              </div>
            </div>

        </div>
             
    </div>
</template>

<script>
    import CompTblOfficer     from './officer/list-of-officer-in-tabs.vue'
    import CompTblRescues     from './rescue/list-of-rescue-in-tabs.vue'
    import CompTblEvacuations from './evacuation/list-of-evacuations-in-tabs.vue'
    import CompTblFacilities  from './facility/list-of-facilities-in-tabs.vue'
    export default {
        data(){
           return {
              provinceId: 0,
              province: { name: 'Waiting....', id: 0 },
              officers: [], rescues: [], evacuations: [], facilities: []
           }
        },
        components: {
            'officers-list': CompTblOfficer,
            'rescue-list': CompTblRescues,
            'evacuation-list': CompTblEvacuations,
            'facility-list': CompTblFacilities
        },
        mounted() {
           this.setProvinceId();
           this.fetchCityProvinces();
        },
        methods: {
            fetchCityProvinces(){
                let self = this;
                // self.$http.get('/')
            },
            setProvinceId(){
               let self = this;
               let provinceId = router.currentRoute.fullPath.split('/').pop();
               self.provinceId = provinceId;
            },
            fetch(){
                let self = this;
                let resource = self.$resource('/Provinces/All/Tabs/{id}');
                resource.get({
                    id: self.provinceId
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.province = json.province;
                        self.officers = json.officers;
                        self.rescues = json.rescues;
                        self.evacuations = json.evacuations;
                        self.facilities = json.facilities;
                    }
                }, (resp) => {

                });
            }
        },
        watch: {
          '$route' (to, from) {
             // react to route changes...
             this.setProvinceId();
          },
          'provinceId': function(newVal, oldVal){
             this.fetch();
          }
        }
    }
</script>
