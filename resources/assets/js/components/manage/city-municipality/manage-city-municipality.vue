<template>
   <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">City Management</div>

                    <div class="panel-body">
                        <div>

                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create City</a></li>
                            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">List of City/Municipality <span class="badge">{{ city_municipalities.length }}</span></a></li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                          
                            <div role="tabpanel" class="tab-pane active" id="messages">
                                <create-city @cityadded="createCity" :provinces="provinces"></create-city>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="settings">
                                <list-of-cities :provinces="provinces" :city-municipalities="city_municipalities"></list-of-cities>
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
            console.log('Component manage-city-municipality.vue successfully');
            this.fetchProvince();
            this.fetch();
        },
        data(){
            return {
                provinces: [],
                city_municipalities: []
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
            fetchProvince(){
                // let self = this;
                // axios.get('/province/management')
                // .then(function (response) {
                //     if (response.status === 200) {
                //         let json = response.data;
                //         self.provinces = json.provinces;
                //     }
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });
            },
            fetch(){
                let self = this;
                self.$http.get('/city/management').then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.city_municipalities = json.city_municipalities;
                        self.provinces = json.provinces;
                    }
                }, (resp) => {
                    console.log(resp)
                })
            }
        }
    }
</script>
