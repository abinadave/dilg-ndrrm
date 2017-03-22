<template>
   <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">City Management
                    <span> {{ officers.length }}</span>
                    </div>

                    <div class="panel-body">
                        <div>

                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">List of City/Municipality <span class="badge">{{ city_municipalities.length }}</span></a></li>
                            <!-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create City</a></li> -->
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tabpanel-pane active" id="settings">
                                <list-of-cities 
                                :officers="officers"
                                :rescues="rescues"
                                :provinces="provinces" 
                                :evacuations="evacuations"
                                :facilities="facilities"
                                :city-municipalities="city_municipalities"></list-of-cities>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages">
                                <create-city 
                                    @cityadded="createCity" 
                                    :provinces="provinces">
                                </create-city>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CompFormCity from './create-city-municipality'
    import CompListOfCities from './list-of-cities.vue'
    
    export default {
        mounted() {
            let self = this;
            self.fetch();
            self.tid = setInterval(self.iterateFetch(), 5000);
        },
        data(){
            return {
                provinces: [],
                city_municipalities: [],
                officers: [], rescues: [], evacuations: [], facilities: []
            }
        },
        components: {
            'create-city': CompFormCity,
            'list-of-cities': CompListOfCities
        },
        methods: {
            createCity(city){
                let self = this;
                console.log(city);
            },
            iterateFetch(){
                console.log(1)
            },
            fetch(){
                let self = this;
                self.$http.get('/city/management').then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.city_municipalities = json.city_municipalities;
                        self.provinces = json.provinces;
                        self.facilities = json.facilities;
                        self.evacuations = json.evacuations;
                        self.rescues = json.rescues;
                        self.officers = json.officers;
                    }
                }, (resp) => {
                    console.log(resp)
                })
            },
            abortTimer() { // to be called when you want to stop the timer
                let self = this;
                self.clearInterval(self.tid);
            },
            fetchOneByOne(){
                let arr = ['officers'];
            }
        }
    }
</script>
