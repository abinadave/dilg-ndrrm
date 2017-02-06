<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Manage Provinces</div>
                    <div class="panel-body">
                        <div>

                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create Province</a></li>
                            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">List of Provinces</a></li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                          
                            <div role="tabpanel" class="tab-pane active" id="messages">
                                <form-create-province @provinceadded="createProvince"></form-create-province>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="settings">
                                <list-of-provinces :provinces="provinces"></list-of-provinces>
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
    import CompFormCreateProvince from './form-create-province.vue'
    import CompProvinceLIst from './list-of-provinces.vue'
    export default {
        data(){
            return {
                provinces: []
            }
        },
        mounted() {
            console.log('Manage-province.vue successfully mounted.')
            this.fetch();
        },
        components: {
            'form-create-province': CompFormCreateProvince,
            'list-of-provinces': CompProvinceLIst
        },
        methods: {
            createProvince(province){
                let self = this;
                console.log(self.provinces.length);
                self.provinces.push(province);
                console.log(self.provinces.length)
            },
            fetch(){
                let self = this;
                axios.get('/province/management')
                .then(function (response) {
                    if (response.status === 200) {
                        let json = response.data;
                        self.provinces = json.provinces;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
